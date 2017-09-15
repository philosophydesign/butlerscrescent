<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package web2feel
 */
?>

	</div><!-- #content -->
	<div id="bottom">
			<div class="row">
			
			<?php if ( !function_exists('dynamic_sidebar')
			        || !dynamic_sidebar("Footer") ) : ?>  
			<?php endif; ?>
				
			</div>
	</div>
	<div class="row"> 
	<footer id="colophon" class="site-footer col-md-12" role="contentinfo">
		<div class="site-info">
			<div class="fcred col-12">
				<!--Copyright &copy; <?php echo date('Y');?> <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a> - <?php bloginfo('description'); ?>.-->
A development by Wates Homes<br>
©2016 Wates, Surrey KT22 7SW<br>

			</div>		
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
	</div>
	</div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
