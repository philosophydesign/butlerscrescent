<?php
function register_theme_scripts_styles() {
    global $wp, $wp_scripts, $wp_query;
	
	//wp_register_style('reset-css', ( home_url('wp-content/themes/butlerscrescent/reset.css') ), false);
	wp_enqueue_script( 'firefox-mac-fix', home_url('wp-content/themes/butlerscrescent/js/mac_firefox_fix.js'), array('jquery') );
	//wp_enqueue_style('css_main', get_stylesheet_directory_uri() . '/admin.css', array(), '0', 'all');
	
	if( $wp->request=="neighbourhood" || $wp->request=="contact-register" ) {
		
		wp_enqueue_script( 'ajax-script', plugins_url( 'map-location-post-type/js/map-ajax.js'), array('jquery') );
		
		wp_localize_script( 'ajax-script', 'ajax_object',
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'paged' => $paged, 'pins_url' => plugins_url("map-location-post-type/pins/") )
		);
		
	}
	
	if( $wp->request=="neighbourhood" || ( isset($wp_query->query_vars['taxonomy']) && $wp_query->query_vars['taxonomy'] == 'maplocation_category' ) ): //|| $wp->request=="contact-register"
		/*wp_deregister_script('jquery');
		wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/latest/jquery.js"), false, '1.3.2');
		wp_enqueue_script('jquery');*/
		
		wp_deregister_style('js_composer_front-css');
		wp_register_style('js_composer_front-css', (plugins_url("js_composer/assets/css/js_composer.min.css")), false);
		wp_enqueue_style('js_composer_front-css');
		
		//wp_register_script('js_composer_front-js', (plugins_url("js_composer/assets/js/dist/js_composer_front.min.js?ver=4.11.1")), false);
		//wp_enqueue_script('js_composer_front-js');
		
		//wp_deregister_script('dt-main');
		
	endif;
	
	if( $wp->request=="properties" ) {
		
		wp_enqueue_script( 'ajax-script', home_url( 'wp-content/plugins/property-post-type/js/property-ajax.js?ver=4.5.2'), array('jquery') );
		
		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		
		// in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
		wp_localize_script( 'ajax-script', 'ajax_object', array( 'svg_url' => home_url('wp-content/themes/butlerscrescent/images/bcspg1_edit-04.svg'), 'ajax_url' => admin_url( 'admin-ajax.php' ), 'paged' => $paged ) );
		
		//to list loaded scripts
		/*global $wp_scripts;
		foreach( $wp_scripts->queue as $handle ) :
			echo $handle . ' | ';
		endforeach;*/
		
		//wp_deregister_script('dt-main');
		//wp_deregister_script('jquery');

	}
	
	if( $wp->request=="about" ) {
		// in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
		wp_localize_script( 'jquery', 'ajax_object', array( 'svg_url' => home_url('wp-content/themes/butlerscrescent/images/bcspg1_edit-04.svg') ) );	
	}
}

// Register Scripts/Styles FrontEnd
add_action('wp_enqueue_scripts', 'register_theme_scripts_styles',100);

function register_my_menus() {
  register_nav_menus(
    array(
      'neighbourhood-menu' => __( 'Neighbourhood Menu' )
    )
  );
}
add_action( 'init', 'register_my_menus' );

/*function add_custom_query_var( $vars ){
  $vars[] = "category";
  $vars[] = "taxonomy";
  $vars[] = "term";
  return $vars;
}
add_filter( 'query_vars', 'add_custom_query_var' );*/

function remove_butlers( $wp_query){
	 if(is_tax()){
		$wp_query->set('posts_per_page', '-1');
		$wp_query->set('post__not_in', array(582));
		$wp_query->set('orderby', 'menu_order');
		$wp_query->set('order', 'ASC');
	 }
}
//filter butlers from results
add_action('pre_get_posts','remove_butlers');