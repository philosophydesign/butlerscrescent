<?php
/**
 * Inline header.
 *
 * @package the7
 * @since 3.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>

<div <?php presscore_header_class( 'masthead inline-header' ); presscore_header_inline_style(); ?> role="banner">
	<div id="blank"></div>
	<?php presscore_get_template_part( 'theme', 'header/top-bar' ); ?>
	
	<div class="header-top">
		<header class="header-bar">
			
			<?php presscore_get_template_part( 'theme', 'header/branding' ); ?>
			
			<div class="mid-col"></div>

			<div class="reg-col">
				<div style="float:left;width:75%;margin-left: 15%;">
					<p><a href="<?php echo home_url('/contact-register#register'); ?>" style="font-size:35px;">REGISTER</a></p>
					<a href="tel:08000852757">0800 0852 757</a>
				</div>
				<div style="float:left; width:0%;"></div>
				<div style="float:right; width:0%; position: relative; left: 0%;">
					<?php $img = home_url('wp-content/themes/butlerscrescent/images/htb_gov.svg'); ?>
					<a id="help_to_buy" href="http://www.helptobuy.gov.uk" target="_blank"><img border="0" width="100" src="<?php echo $img; ?>" onerror="this.onerror=null; this.src='<?php echo $img; ?>'"></a>
				</div>
				<br style="clear:both;"/>
			</div>
		</header>
	</div>
		
	<div class="custom-primary-menu">
		<header class="header-bar">
		<?php presscore_get_template_part( 'theme', 'header/primary-menu' ); ?>

		<?php presscore_render_header_elements( 'near_menu_right' ); ?>
		</header>
	</div>
	
	<!-- note: copy_htb in mac_firefox_fix.js -->

</div>