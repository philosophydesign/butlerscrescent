<?php
/**
 * Template Name: Neighbourhood
 *
 * @package vogue
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if(!session_id()) {
	session_start();
}

unset($_SESSION['maplocation_category']);
	
get_header(); ?>

			<!-- Content -->
			<div id="content" class="content" role="main">
				<?php /* VC sticky and widget used now. Only used on local area sections */ presscore_get_template_part( 'theme', 'header/get-submenu' ); ?>
				
				<div id="maprow" class="vc_row wpb_row wf-container full-width-wrap" style="padding-left: 0px; padding-right: 0px; margin-top:0px; margin-bottom: 0px; /*width: 1903px*/ width:100%; margin-left: -371px; opacity: 1; min-height: 500px;">
						<div class="wpb_column vc_column_container vc_col-sm-12">
							<div class="wpb_wrapper">
								<div id="wrap_map_56e6c552e6fc9" class="ultimate-map-wrapper" style="height:500px;">
									<div id="map_56e6c552e6fc9" data-map_override="0" class="ultimate_google_map wpb_content_element page_margin_top" style="/*width: 1903px;*/ width:100%; height: 500px;margin-left: 0px;position: relative; overflow: hidden; transform: translateZ(0px); background-color: rgb(229, 227, 223);"></div>
									<!--<script type="text/javascript" src="<?php echo home_url('wp-content/plugins/map-location-post-type-1/js/googlemaps.js?signed_in=false&amp;key=AIzaSyD1mTwIBQ5fMfQIKRCtt99qstD31zYQV_M&amp;callback=initMap&amp;ver=4.4.2');?>"></script>-->
									
									<!--<script type="text/javascript" src="<?php echo home_url('wp-content/plugins/map-location-post-type/js/map-ajax.js'); ?>"></script>-->
									
									<script>
									<!--
									jQuery(document).ready(function($) {

									});
									-->
									</script>
									
									<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?signed_in=false&amp;key=AIzaSyAPotK7TVo5pK49PIAKSJyX2RmKWVugejg"></script><!-- callback=initMap -->
									
								</div>
							</div>
						</div>
				</div>
				<!--<div id="map_56e6c552e6fc9"></div>-->
				
				<div style="clear:both;"></div>
				
				<?php 
					$categories = get_terms("maplocation_category", array('orderby'=>'id'));
					//$category = get_query_var('category');

					//$queried_object = get_queried_object();
					//echo '<pre>'; var_dump( array('queried_object'=>$queried_object) ); echo '</pre>';
					
					$category = get_query_var($wp_query->query_vars['taxonomy']);
					if($category && $category !="") $category = get_term_by('slug', $category, $wp_query->query_vars['taxonomy']);
					
					
				?>
				
				<div id="map-results">
					<div class="wpb_column vc_column_container vc_col-xs-12 vc_col-sm-12 vc_col-lg-12">
						<div class="vc_column-inner ">
							<div class="wf-container-main">
									<div class="wpb_column vc_column_container vc_col-xs-12 vc_col-sm-12 vc_col-md-3 vc_col-lg-3"><div class="vc_column-inner">
										<div class="wpb_wrapper">
											<!--<h2 style="text-align: left" class="vc_custom_heading">Categories</h2>-->
											<div class="wpb_text_column wpb_content_element categories">
												<div class="wpb_wrapper">
													<ul id="category-list">
													<?php foreach($categories AS $c):
														echo '<li><a href="'.get_term_link($c->term_id).'"><div><span>'.$c->name.'<i class="Defaults-angle-right"></i></span></div></a></li>';
													endforeach; ?>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								
								<div class="wpb_column vc_column_container vc_col-xs-12 vc_col-sm-12 vc_col-md-9 vc_col-lg-9">
									<div class="vc_column-inner ">
										<div class="wpb_wrapper">
										<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
											<h1 style="text-align: left" class="vc_custom_heading category-name"><?php the_title(); ?></h1>
											
											<div class="wpb_text_column wpb_content_element ">
												<div class="wpb_wrapper">
													<?php the_content(); ?>
												</div>
											</div>
											
										<?php endwhile; endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div><!-- #content -->

			<?php do_action('presscore_after_content'); ?>
			
			<div style="clear:both;"></div>
<?php get_footer(); ?>