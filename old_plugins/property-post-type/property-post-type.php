<?php
/**
 * Property Post Type
 *
 * @package   Property_Post_Type
 * @author    Matthew Bull
 * @license   GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Property Post Type
 * Description: Enables property post type and taxonomies.
 * Version:     0.0.1
 * Author:      Matthew Bull
 * Text Domain: propertyposttype
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Required files for registering the post type and taxonomies.
require plugin_dir_path( __FILE__ ) . 'includes/class-property-post-type.php';
require plugin_dir_path( __FILE__ ) . 'includes/interface-gamajo-registerable.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-gamajo-post-type.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-gamajo-taxonomy.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-property-post-type-post-type.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-property-post-type-taxonomy-category.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-property-post-type-taxonomy-tag.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-property-post-type-registrations.php';

// Instantiate registration class, so we can add it as a dependency to main plugin class.
$property_post_type_registrations = new Property_Post_Type_Registrations;

// Instantiate main plugin file, so activation callback does not need to be static.
$property_post_type = new Property_Post_Type( $property_post_type_registrations );

// Register callback that is fired when the plugin is activated.
register_activation_hook( __FILE__, array( $property_post_type, 'activate' ) );

// Initialise registrations for post-activation requests.
$property_post_type_registrations->init();

add_action( 'init', 'property_post_type_init', 100 );

/**
 * Adds styling to the dashboard for the post type and adds property posts
 * to the "At a Glance" metabox.
 *
 * Adds custom taxonomy body classes to property posts on the front end.
 *
 * @since 0.8.3
 */
function property_post_type_init() {
	if ( is_admin() ) {
		global $property_post_type_admin, $property_post_type_registrations;
		
		// Loads for users viewing the WordPress dashboard
		if ( ! class_exists( 'Gamajo_Dashboard_Glancer' ) ) {
			wp_enqueue_style('admin_css', plugins_url( 'css/admin.css', __FILE__ ), array(), '1', 'all');
			require plugin_dir_path( __FILE__ ) . 'includes/class-gamajo-dashboard-glancer.php';  // WP 3.8
		}
		require plugin_dir_path( __FILE__ ) . 'includes/class-property-post-type-admin.php';
		$property_post_type_admin = new Property_Post_Type_Admin( $property_post_type_registrations );
		$property_post_type_admin->init();
	} else {
		// Loads for users viewing the front end
		if ( apply_filters( 'property_posttype_add_taxonomy_terms_classes', true ) ) {
			if ( ! class_exists( 'Gamajo_Single_Entry_Term_Body_Classes' ) ) {
				require plugin_dir_path( __FILE__ ) . 'includes/class-gamajo-single-entry-term-body-classes.php';
			}
			$property_post_type_body_classes = new Gamajo_Single_Entry_Term_Body_Classes;
			$property_post_type_body_classes->init( 'property' );
		}
	}
flush_rewrite_rules();
}

function get_propertydata(){
	global $wpdb, $post, $query; // this is how you get access to the database
	
	$propertydate = array();
	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	
	$args = array(
		'post_type' => 'property',
		'post_status' => 'publish',
		'order' => 'ASC',
		'paged' => $paged
	);
	
	//if( isset($atts['post_status']) ) $args['post_status'] = $atts['post_status'];

	$query = new WP_Query( $args );
	
	while( $query->have_posts() ) : $query->the_post();
		
		$category = get_the_terms( get_the_ID(), 'property_category');
		$tag = get_the_terms( get_the_ID(), 'property_tag' );
		$permalink = esc_url( get_permalink(get_the_ID()) );
		
		switch ($post->post_status) {
			case "draft":
				$availability = "Unreleased";
				break;
			
			case "publish":
				$availability = "Available";
				break;
				
			case "reserved":
				$availability = "Reserved";
				break;
			
			case "sold":
				$availability = "Sold";
				break;
		}

		$row = array(
			'plot_no'=>get_the_title(),
			'type'=>$tag[0]->name,
			'name'=>$category[0]->name,
			'availability'=>$availability,
			'permalink'=>$permalink
		);
		
		setlocale(LC_MONETARY, 'en_GB.UTF-8');
		
		if( $beds = get_post_meta( get_the_ID(), 'beds', true ) ) $row['no_of_beds'] = $beds;
		if( $floor = get_post_meta( get_the_ID(), 'floor', true ) ) $row['floor'] = $floor;
		if( $asking_price = get_post_meta( get_the_ID(), 'asking_price', true ) ) $row['asking_price'] = money_format('%.0n', $asking_price);
		
		$propertydata[] = $row;
		
	endwhile;

	return $propertydata;	
}

require plugin_dir_path( __FILE__ ) . 'includes/shortcodes.php';

// Get data admin via Ajax
add_action( 'wp_ajax_get_propertydata', 'get_propertydata_callback' );
// Get data frontend via Ajax
add_action( 'wp_ajax_nopriv_get_propertydata', 'get_propertydata_callback' );

function get_propertydata_callback(){
	$propertydata = get_propertydata();
	echo json_encode($propertydata);
	wp_die(); // this is required to terminate immediately and return a proper response
}

// Add Admin Ajax JS 
add_action( 'admin_enqueue_scripts', 'property_admin_enqueue' ); /* admin_ */
function property_admin_enqueue($hook) {
	global $post;
	//echo '<h1>hook:'.$hook.'</h1>';
	if ($post->post_type == 'property') {
		switch($hook){
			case 'index.php':
			// Only applies to dashboard panel
			break;
			//Add to following when address needs geo coading
			case 'post.php':
			case 'post-new.php':
			case 'edit.php':
				wp_enqueue_script( 'ajax-script', plugins_url( '/js/admin-ajax.js', __FILE__ ), array('jquery') );
			break;
		}
		return;
	} else return;
}

// Add Frontend Ajax JS 
//add_action( 'wp_enqueue_scripts', 'property_front_enqueue' );
function property_front_enqueue() {
	if (!is_post_type_archive('property') && !is_tax('property_category') ) return;

	wp_enqueue_script( 'ajax-script', plugins_url( '/js/property-ajax.js', __FILE__ ), array('jquery') );
	
	/**
	*	Use latest jQuery release
	*/
	//wp_deregister_script('jquery');
	//wp_register_script('jquery', ("http://code.jquery.com/jquery-latest.min.js"), false, '');
	
	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	
	// in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
	wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'paged' => $paged ) );
}

	// Register Custom Status
	function custom_post_status() {
		
		$args = array(
			'label'                     => _x( 'Available', 'Status General Name', 'property-post-type' ),
			'label_count'               => _n_noop( 'Available (%s)',  'Available (%s)', 'property-post-type' ), 
			'public'                    => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'exclude_from_search'       => false,
		);
		register_post_status( 'publish', $args );

		$args = array(
			'label'                     => _x( 'Unreleased', 'Status General Name', 'property-post-type' ),
			'label_count'               => _n_noop( 'Unreleased (%s)',  'Unreleased (%s)', 'property-post-type' ), 
			'public'                    => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'exclude_from_search'       => false,
		);
		register_post_status( 'draft', $args );
		
		$args = array(
			'label'                     => _x( 'Reserved', 'Status General Name', 'property-post-type' ),
			'label_count'               => _n_noop( 'Reserved (%s)',  'Reserved (%s)', 'property-post-type' ), 
			'public'                    => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'exclude_from_search'       => false,
		);
		register_post_status( 'reserved', $args );
		
		$args = array(
			'label'                     => _x( 'Sold', 'Status General Name', 'property-post-type' ),
			'label_count'               => _n_noop( 'Sold (%s)',  'Sold (%s)', 'property-post-type' ), 
			'public'                    => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'exclude_from_search'       => false,
		);
		register_post_status( 'sold', $args );
		

	}
	add_action( 'init', 'custom_post_status', 0 );