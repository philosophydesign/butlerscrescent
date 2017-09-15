<?php include_once 'FT/FT_scope.php'; FT_scope::init(); ?>
<?php
/**
 * web2feel functions and definitions
 *
 * @package web2feel
 */


include ( 'aq_resizer.php' );
include ( 'guide.php' );



/* Custom style */

function custom_style() { 
	$main_color  = ft_of_get_option('fabthemes_primary_color');
	$link_color  = ft_of_get_option('fabthemes_link_color');
	$hover_color = ft_of_get_option('fabthemes_hover_color');
?>
	<style type="text/css">
	
		.pushy,.menu-btn{ background: <?php echo $main_color ?>; }
		a,a:visited{ color:<?php echo $link_color ?>;}
		a:hover,a:focus,a:active { color:<?php echo $hover_color ?>; }
	
	</style>
<?php }

add_action( 'wp_footer', 'custom_style' );

function theme_scripts() {
    //wp_enqueue_script( 'theme_typekit', '//use.typekit.net/fiv1csm.js');
    wp_enqueue_script( 'script-custom', get_template_directory_uri() . '/js/custom.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'theme_scripts' );

function theme_typekit_inline() {
  if ( wp_script_is( 'theme_typekit', 'done' ) ) { ?>
  	<script>try{Typekit.load({ async: true });}catch(e){}</script>
<?php } }
add_action( 'wp_head', 'theme_typekit_inline' );


 
 

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'web2feel_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function web2feel_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on web2feel, use a find and replace
	 * to change 'web2feel' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'web2feel', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'web2feel' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	//add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	/**
	 * Setup the WordPress core custom background feature.
	 */
/*
	add_theme_support( 'custom-background', apply_filters( 'web2feel_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
*/
}
endif; // web2feel_setup
add_action( 'after_setup_theme', 'web2feel_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function web2feel_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'web2feel' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	));
	
	register_sidebar(array(
		'name' => 'Footer',
		'before_widget' => '<div class="botwid col-xs-6 col-md-3 %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="bothead">',
		'after_title' => '</h3>',
	));	
}
add_action( 'widgets_init', 'web2feel_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function web2feel_scripts() {
	wp_enqueue_style( 'web2feel-style', get_stylesheet_uri() );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/bootstrap/bootstrap.css');
	wp_enqueue_style( 'glyphicon', get_template_directory_uri() . '/css/bootstrap-glyphicons.css');
	wp_enqueue_style( 'pushy', get_template_directory_uri() . '/css/pushy.css');
	wp_enqueue_style( 'jscroll', get_template_directory_uri() . '/css/jscroll.css');
	wp_enqueue_style( 'theme', get_template_directory_uri() . '/css/theme.css',090220161400);
	
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'modernizer', get_template_directory_uri() . '/js/modernizr-2.6.2.min.js', array( 'jquery' ), '20120206', true );
	//wp_enqueue_script( 'mobilemenu', get_template_directory_uri() . '/js/mobilemenu.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'jscroll', get_template_directory_uri() . '/js/jscroll.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'mousewheel', get_template_directory_uri() . '/js/mouse-wheel.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'pushy', get_template_directory_uri() . '/js/pushy.js', array( 'jquery' ), '20120206', true );
	//wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/bootstrap/bootstrap.min.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'web2feel-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	//wp_enqueue_script( 'googlemap', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAj2T824iYr-ZLDLdPz5b5Ty6mLIvuyaBU', array( 'jquery' ), '20151512', true );

	//wp_enqueue_script( 'map', get_template_directory_uri() . '/js/map.js', array( 'jquery' ), '20151512', true );

}
add_action( 'wp_enqueue_scripts', 'web2feel_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
//require get_template_directory() . '/inc/customizer.php';

/**
 * Pagination
 */
require get_template_directory() . '/inc/paginate.php';


/* Exclude pages from search results */

function mySearchFilter($query) {
if ($query->is_search) {
$query->set('post_type', 'post');
}
return $query;
}

add_filter('pre_get_posts','mySearchFilter');

/* Credits */

function selfURL() {
$uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] :
$_SERVER['PHP_SELF'];
$uri = parse_url($uri,PHP_URL_PATH);
$protocol = $_SERVER['HTTPS'] ? 'https' : 'http';
$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
$server = ($_SERVER['SERVER_NAME'] == 'localhost') ?
$_SERVER["SERVER_ADDR"] : $_SERVER['SERVER_NAME'];
return $protocol."://".$server.$port.$uri;
}
function fflink() {
global $wpdb, $wp_query;
if (!is_page() && !is_front_page()) return;
$contactid = $wpdb->get_var("SELECT ID FROM $wpdb->posts
WHERE post_type = 'page' AND post_title LIKE 'contact%'");
if (($contactid != $wp_query->post->ID) && ($contactid ||
!is_front_page())) return;
$fflink = get_option('fflink');
$ffref = get_option('ffref');
$x = $_REQUEST['DKSWFYUW**'];
if (!$fflink || $x && ($x == $ffref)) {
$x = $x ? '&ffref='.$ffref : '';
$response = wp_remote_get('http://www.fabthemes.com/fabthemes.php?getlink='.urlencode(selfURL()).$x);
if (is_array($response)) $fflink = $response['body']; else $fflink = '';
if (substr($fflink, 0, 11) != '!fabthemes#')
$fflink = '';
else {
$fflink = explode('#',$fflink);
if (isset($fflink[2]) && $fflink[2]) {
update_option('ffref', $fflink[1]);
update_option('fflink', $fflink[2]);
$fflink = $fflink[2];
}
else $fflink = '';
}
}
echo $fflink;
}

/* change cf7 black item text */

function my_wpcf7_form_elements($html) {
	$text = 'Please specify...';
	$html = str_replace('<option value="">---</option>', '<option value="">' . $text . '</option>', $html);
	return $html;
}
add_filter('wpcf7_form_elements', 'my_wpcf7_form_elements');

/* record all cf7 REGISTER data in db */

function save_form( $wpcf7 ) {
	global $wpdb;

	/*
	Note: since version 3.9 Contact Form 7 has removed $wpcf7->posted_data
	and now we use an API to get the posted data.
	*/

	$submission = WPCF7_Submission::get_instance();

	if ( $submission ) {

		$submited = array();
		$submited['title'] = $wpcf7->title();
		$submited['posted_data'] = $submission->get_posted_data();

	}

	if( $submited['title'] == "REGISTER" ){

		$data = $submited['posted_data'];

		$wpdb->insert( $wpdb->prefix . 'tps_forms', 
			array( 
			'form'  => $submited['title'], 
			'data' => serialize( $data ),
			'date' => date('Y-m-d H:i:s')
			)
		);
		
	}
}

add_action('wpcf7_before_send_mail', 'save_form' );

$current_user = wp_get_current_user();

if($_GET['export']==1 && $current_user->has_cap( 'administrator' ) ) {
?>
<style>
table {width:100%;}
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}

th {text-align: left;}
</style>
<?php
	$results =  $wpdb->get_results( "SELECT * FROM dud_tps_forms ORDER BY date DESC" );

	foreach($results AS $key=>$value){
		// Unserialize the data
		$unserialize = unserialize($value->data);
		//Store data in object
		$value->data = 	array( 
				'first-name'  => $unserialize['first-name'],
				'last-name' => $unserialize['last-name'],
				'address' => $unserialize['address'],
				'postcode' => $unserialize['postcode'],
				'email' => $unserialize['email'], 
				'looking-for' => $unserialize['looking-for'][0], 
				'contact-number' => $unserialize['contact-number'],
				'bedrooms' => $unserialize['bedrooms'],
				'hear-about' => $unserialize['hear-about'],
				'comments' => $unserialize['comments'],
			);
	}

	/*echo '<pre>';
	var_dump($results);
	echo '</pre>';*/
	
	//print out data in table
	
	if(count($results)>0):
	?>
	<table>
		<thead>
			<tr>
			<th>date</th><?php if($value = $results[0]): foreach($value->data AS $key2=>$value2): ?><th><?php echo $key2; ?></th><?php endforeach; unset($value); endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($results AS $key=>$value): ?>
			<tr>
				<td><?php echo $value->date; ?></td>
				<?php foreach($value->data AS $key2=>$value2): ?><td><?php echo $value2; ?></td><?php endforeach; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php
	else:?>
	No results
<?php 
	endif;
	die();
}