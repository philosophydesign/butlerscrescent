<?php
/**
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

	<?php do_action( 'presscore_before_main_container' ); ?>

	<?php if ( presscore_is_content_visible() ): ?>

	<div id="main" <?php presscore_main_container_classes(); ?>><!-- class="sidebar-none", class="sidebar-left", class="sidebar-right" -->
	
		<?php global $wp, $post; if(/*$wp->request=="properties" &&*/ $property_category = wp_get_object_terms($post->ID, 'property_category') ): ?>
		<div data-vc-stretch-content="true" class="vc_row wpb_row vc_row-fluid vc_row-no-padding back-btn" style="opacity: 1;">
			<div class="wpb_column vc_column_container vc_col-sm-10 vc_col-xs-offset-1">
				<div class="vc_column-inner">
					<div class="wpb_wrapper">
						<div class="vc_row wpb_row vc_inner vc_row-fluid">
							<div class="wpb_column vc_column_container vc_col-sm-12 vc_col-lg-offset-2">
								<div class="vc_column-inner ">
									<div class="wpb_wrapper">
										<div class="wpb_text_column wpb_content_element">
											<div class="wpb_wrapper">
												<p><a style="font-size: 16px;" href="http://www.butlerscrescent.co.uk/properties">&lt; BACK TO PROPERTIES</a></p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
	
		<?php do_action( 'presscore_main_container_begin' ); ?>

		<div class="main-gradient"></div>
		<div class="wf-wrap">
			<div class="wf-container-main">

				<?php do_action( 'presscore_before_content' ); ?>

	<?php endif; ?>