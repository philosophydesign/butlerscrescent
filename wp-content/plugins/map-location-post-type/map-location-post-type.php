<?php
/**
 * Map Location Post Type
 *
 * @package   Map_location_Post_Type
 * @author    Matthew Bull
 * @license   GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Map location Post Type
 * Description: Enables map location post type and taxonomies.
 * Version:     0.0.1
 * Author:      Matthew Bull
 * Text Domain: maplocationposttype
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Required files for registering the post type and taxonomies.
require plugin_dir_path( __FILE__ ) . 'includes/class-maplocation-post-type.php';
require plugin_dir_path( __FILE__ ) . 'includes/interface-gamajo-registerable.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-gamajo-post-type.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-gamajo-taxonomy.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-maplocation-post-type-post-type.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-maplocation-post-type-taxonomy-category.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-maplocation-post-type-taxonomy-tag.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-maplocation-post-type-registrations.php';

// Instantiate registration class, so we can add it as a dependency to main plugin class.
$maplocation_post_type_registrations = new Maplocation_Post_Type_Registrations;

// Instantiate main plugin file, so activation callback does not need to be static.
$maplocation_post_type = new Maplocation_Post_Type( $maplocation_post_type_registrations );

// Register callback that is fired when the plugin is activated.
register_activation_hook( __FILE__, array( $maplocation_post_type, 'activate' ) );

// Initialise registrations for post-activation requests.
$maplocation_post_type_registrations->init();

add_action( 'init', 'maplocation_post_type_init', 100 );

/**
 * Adds styling to the dashboard for the post type and adds maplocation posts
 * to the "At a Glance" metabox.
 *
 * Adds custom taxonomy body classes to maplocation posts on the front end.
 *
 * @since 0.8.3
 */
function maplocation_post_type_init() {

	flush_rewrite_rules(true);

	if ( is_admin() ) {
		global $maplocation_post_type_admin, $maplocation_post_type_registrations;
		
		// Loads for users viewing the WordPress dashboard
		if ( ! class_exists( 'Gamajo_Dashboard_Glancer' ) ) {
			wp_enqueue_style('admin_css', plugins_url( 'css/admin.css', __FILE__ ), array(), '1', 'all');
			require plugin_dir_path( __FILE__ ) . 'includes/class-gamajo-dashboard-glancer.php';  // WP 3.8
		}
		require plugin_dir_path( __FILE__ ) . 'includes/class-maplocation-post-type-admin.php';
		$maplocation_post_type_admin = new Maplocation_Post_Type_Admin( $maplocation_post_type_registrations );
		$maplocation_post_type_admin->init();
	} else {
		// Loads for users viewing the front end
		if ( apply_filters( 'maplocation_posttype_add_taxonomy_terms_classes', true ) ) {
			if ( ! class_exists( 'Gamajo_Single_Entry_Term_Body_Classes' ) ) {
				require plugin_dir_path( __FILE__ ) . 'includes/class-gamajo-single-entry-term-body-classes.php';
			}
			$maplocation_post_type_body_classes = new Gamajo_Single_Entry_Term_Body_Classes;
			$maplocation_post_type_body_classes->init( 'maplocation' );
		}
	}

}

require plugin_dir_path( __FILE__ ) . 'includes/shortcodes.php';

// Get data admin via Ajax
add_action( 'wp_ajax_get_mapdata', 'get_mapdata_callback' );
// Get data frontend via Ajax
add_action( 'wp_ajax_nopriv_get_mapdata', 'get_mapdata_callback' );

function get_mapdata_callback(){
	global $wpdb, $post, $query; // this is how you get access to the database
	
	if(!session_id()) {
		session_start();
	}
	
	//$whatever = $_POST['whatever'];
	//echo $whatever;
	
	$paged = $_POST['paged']; //( get_query_var('paged') ) ? get_query_var('paged') : 1;
	
	$args = array(
		/*'posts_per_page' => 3,*/
		'post_type' => 'maplocation',
		'post_status' => 'publish',
		//'orderby' => 'menu_order',
		'order' => 'ASC',
		//'ID' => 582,
		/*'paged' => $paged,*/
		
	);
	
	if(isset($_SESSION['maplocation_category'])) {
		$term = $_SESSION['maplocation_category'];
		
		if( isset($term) && $term != "") {
			
			
			/*$args['meta_query'] = array(
				'relation' => 'OR',
				array(
					'key' => 'icon',
					'value' => 'butlers.png',
					'compare' => '=',
				)
			);*/
			
			$args['tax_query'] = array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'maplocation_category',
					'field' => 'slug',
					//'terms' => array ('food-drink')
					'terms' => array($term)
				)
			);
			
		} 
		
	} else {
			
			//only show butlers pin

			$args['meta_query'] = array(
				array(
					'key'     => 'icon',
					'value'   => 'butlers.png',
					'compare' => '=',
				),
			);
	}
	

	
	//var_dump($args);
	
	$query = new WP_Query( $args );
	
	$mapdate = array();
	
	while( $query->have_posts()) : $query->the_post();
		$icon = get_post_meta(get_the_ID(),'icon',true);
		$address = get_post_meta(get_the_ID(),'address',true);
		$geo_code = get_post_meta(get_the_ID(),'geo_code',true);
		$website = get_post_meta(get_the_ID(),'website',true);
		$category = get_the_terms( get_the_ID(), 'maplocation_category' );
		
		$row = array(
			'id'=>get_the_ID(),
			'title'=>get_the_title(),
			'excerpt'=>get_the_excerpt()
		);
		
		if ( isset($icon) && ($icon != null || $icon != "") ) $row['icon'] = $icon; //plugins_url("pins/",__FILE__).
		else {
			//base icon off category

			//check file before setting
			if ( $icon = file_exists( plugin_dir_path( __FILE__ ) . 'pins/'.$category[0]->name ) ) { $row['icon'] = $icon; } else {$row['icon'] = 'pin.png?v2';}


		}
		
		if ( isset($address) && ($address != null && $address != "") ) $row['address'] = $address;
		if ( isset($geo_code) && ($geo_code != null && $geo_code != "") ) $row['geo_code'] = $geo_code;
		if ( isset($website) && ($website != null && $website != "") ) $row['website'] = 'http://'.$website;
		if ( isset($category) && count($category) > 0 ) {
			$row['category'] = array();
			for($i = 0; $i <= count($category)-1; $i++){
				if($category[$i]->name && $category[$i]->name != "")array_push($row['category'],$category[$i]->name);
			}
			if( count($row['category']) < 1) unset($row['category']);
		}
		
		$mapdate[] = $row;
	endwhile;
	
	//$mapdate = $args;
	
	echo json_encode($mapdate);
	

	wp_die(); // this is required to terminate immediately and return a proper response
}

// Add Admin Ajax JS 
add_action( 'admin_enqueue_scripts', 'map_admin_enqueue' ); /* admin_ */
function map_admin_enqueue($hook) {
	global $post;
	//echo '<h1>hook:'.$hook.'</h1>';
	if ($post->post_type == 'maplocation') {
		switch($hook){
			case 'index.php':
			// Only applies to dashboard panel
			break;
			//Add to following when address needs geo coading
			case 'post.php':
			case 'post-new.php':
			case 'edit.php':
				wp_enqueue_script( 'ajax-script', plugins_url( '/js/geocode-ajax.js', __FILE__ ), array('jquery') );
				wp_enqueue_script( 'geocoder-script', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAPotK7TVo5pK49PIAKSJyX2RmKWVugejg' );
				// in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
				/*wp_localize_script( 'ajax-script', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'whatever' => 1234 ) );*/
			break;
		}
		return;
	} else return;
}

// Add Frontend Ajax JS 
add_action( 'wp_enqueue_scripts', 'map_front_enqueue' );
function map_front_enqueue() {
	if (!is_post_type_archive('maplocation') && !is_tax('maplocation_category') ) {return;}

	/*moved to archive template*/
	wp_enqueue_script( 'ajax-script', plugins_url( '/js/map-ajax.js', __FILE__ ), array('jquery') );
	//wp_enqueue_script( 'googlemap-script','https://maps.googleapis.com/maps/api/js?signed_in=false&amp;key=AIzaSyD1mTwIBQ5fMfQIKRCtt99qstD31zYQV_M&amp;callback=initMap' );
	
	//wp_enqueue_script( 'googlemap-script',plugins_url( '/js/googlemaps.js?signed_in=false&amp;key=AIzaSyD1mTwIBQ5fMfQIKRCtt99qstD31zYQV_M&amp;callback=initMap', __FILE__ ) );
	
	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	
	// in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
	
	wp_localize_script( 'ajax-script', 'ajax_object',
		array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'paged' => $paged, 'pins_url' => plugins_url("pins/",__FILE__) )
	);
}
/*
function map_cats_rewrite() {
    add_rewrite_rule( 'map/(.*)/?', 'index.php?post_type=maplocation&category=$matches[1]', 'top' );
}
//add_action( 'init', 'map_cats_rewrite' );

function filter_query_vars( $query_vars ) {
    $query_vars[] = 'category';

    return $query_vars;
}
add_filter( 'query_vars', 'filter_query_vars' );
*/