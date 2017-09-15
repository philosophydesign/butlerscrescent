<?php
/* Template Name: Property - list */

/**
 * Property list template
 *
 * @package vogue
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

//$config = Presscore_Config::get_instance();
//$config->set( 'template', 'blog' );
//$config->set( 'template.layout.type', 'list' );

// add content controller
//add_action( 'presscore_before_main_container', 'presscore_page_content_controller', 15 );

get_header();

if ( presscore_is_content_visible() ): ?>

			<!-- Content -->
			<div id="content" class="content" role="main">
				<article id="post-1050" class="post-1050 property type-property status-publish property_category-hipkins property_tag-house description-off">
					<div data-vc-full-width="true" data-vc-full-width-init="true" data-vc-stretch-content="true" data-vc-parallax="1.5" class="vc_row wpb_row vc_row-fluid vc_row-has-fill vc_row-no-padding vc_general">
						<div class="wpb_column vc_column_container vc_col-sm-6">
							<div class="vc_column-inner "><div class="wpb_wrapper">
								<h2 style="color: #000000;text-align: left" class="vc_custom_heading vc_custom_1463477621089">Custom Heading with Theme Font</h2>
								<div class="wpb_text_column wpb_content_element ">
									<div class="wpb_wrapper">
										<p>This section is a perfect place to display introduction description for your products and services with an option to access more information by clicking “Read More” button.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="wpb_column vc_column_container vc_col-sm-6">
						<div class="vc_column-inner">
							<div class="wpb_wrapper">
								<div class="wpb_single_image wpb_content_element vc_align_center">
									<figure class="wpb_wrapper vc_figure">
										<div class="vc_single_image-wrapper vc_box_rounded  vc_box_border_grey">
											<img class="vc_img-placeholder vc_single_image-img" src="http://butlerscrescent.stage.philosophydesign.com/wp-content/plugins/js_composer/assets/vc/no_image.png">
										</div>
									</figure>
								</div>
							</div>
						</div>
						
					</div>
					
					<div class="vc_parallax-inner skrollable skrollable-between" data-bottom-top="top: -50%;" data-top-bottom="top: 0%;" style="height: 150%; top: -28.392%;"></div>
				</div>
				<div class="vc_row-full-width vc_clearfix"></div>
			</article>
		</div>

<?php
endif; // if content visible

get_footer(); ?>