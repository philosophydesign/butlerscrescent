<?php
/**
 * About sidebar.
 *
 * @package the7
 * @since 3.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

switch($wp->request) {//$post->post_name
	case 'about':
		/*if ( dynamic_sidebar( 'About' ) ) :
		dynamic_sidebar( 'About' );
		endif;*/
	break;
		echo '<div class="sub-menu-container">';
		wp_nav_menu( '4',  array(
			//'theme_location' => 'top',
			'container' => false,
			'items_wrap'     => '<ul class="top bc-sub-menu" role="menu">%3$s</ul>')
		);
		
		//primary menu breaks due to min menu js - use diff class than main-nav

		/*
		
		wp_get_nav_menu_items
		
		$about_items = wp_get_nav_menu_items ( '4', array() );
		
		if(count($about_items) > 0) {
				echo '<ul class="top main-nav" role="menu">';
				foreach($about_items AS $i){
					echo '<li class="menu-item">';
					echo '<a href="'.$i->url.'">'.$i->title.'</a>';
					echo '</li>';
				}
				echo '</ul>';
		}
		
		*/
		echo '</div>';
	break;
	case 'neighbourhood':
	case stripos($wp->request,'neighbourhood') !== false:
	case 'transport':
	case 'museum':
		echo '<div class="sub-menu-container">';
		wp_nav_menu(
			array(
			'theme_location' => 'neighbourhood-menu',
			'container' => false,
			//'items_wrap'     => '<ul class="top bc-sub-menu" role="menu">%3$s</ul>'
			)
		);
		echo '</div>';
		?>
		<!--
		<div data-vc-full-width="true" data-vc-full-width-init="true" data-vc-stretch-content="true" class="vc_row wpb_row vc_row-fluid vc_row-no-padding" style="position: relative; left: -352px; box-sizing: border-box; width: 1903px;"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper"><div class="ult_row_spacer"><div class="ult-sticky-anchor"><div class="ult-sticky-section ult-sticky" data-stick_behaviour="stick_with_scroll" data-sticky_position="top" data-mobile="no" data-support="no"><div class="vc_row wpb_row vc_inner vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-8 vc_col-lg-offset-4 vc_col-lg-4 vc_col-md-offset-2 vc_col-sm-offset-2"><div class="vc_column-inner "><div class="wpb_wrapper">
			<div class="wpb_widgetised_column wpb_content_element sidebar-content sub-menu-container solid-bg">
				<div class="wpb_wrapper">
					
					<section id="nav_menu-3" class="widget widget_nav_menu"><div class="menu-about-menu-container"><ul id="menu-about-menu" class="menu"><li id="menu-item-513" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-513 active"><a href="#about">About</a></li>
		<li id="menu-item-484" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-484"><a href="#site-plan">Site plan</a></li>
		<li id="menu-item-485" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-485"><a href="#history">History</a></li>
		<li id="menu-item-486" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-486"><a href="#developer">The developer</a></li>
		</ul></div></section>
				</div>
			</div>
		</div></div></div></div></div><div class="ult-space"></div></div></div></div></div></div></div>
		--->
		<?php
	break;
}