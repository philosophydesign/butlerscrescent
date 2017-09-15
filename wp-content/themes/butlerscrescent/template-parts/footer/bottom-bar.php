<?php
/**
 * Bottom bar template
 *
 * @package vogue
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if( !is_front_page() ):
?>
<!-- !Bottom-bar -->
<div id="bottom-bar" <?php echo presscore_bottom_bar_class(); ?> role="contentinfo">
	<div class="wf-wrap">
		<div class="wf-container-bottom">
			<div class="wf-table wf-mobile-collapsed">

				<?php
				$logo = presscore_get_the_bottom_bar_logo();
				if ( $logo ) {
					echo '<div id="branding-bottom" class="wf-td">';
						presscore_display_the_logo( $logo );
					echo '</div>';
				}

				do_action( 'presscore_credits' );

				$config = presscore_config();

				$bottom_text = $config->get( 'template.bottom_bar.text' );;
				if ( $bottom_text ) : ?>

					<div class="wf-td bottom-text-block">

						<?php echo wpautop( do_shortcode( $bottom_text ) ); ?>
						
						<p>A development by Wates Homes ©<?php echo date('Y')?><br />Wates Group plc, Wates House, Station Approach, Leatherhead, Surrey, KT22 7SW<br />Registered number 1824828</p>
						
						<?php presscore_nav_menu_list( 'bottom' ); ?>
						
					</div>

				<?php endif; ?>
			</div>
		</div><!-- .wf-container-bottom -->
	</div><!-- .wf-wrap -->
</div><!-- #bottom-bar -->
<?php endif; ?>