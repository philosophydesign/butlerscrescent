<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the <div class="wf-container wf-clearfix"> and all content after
 *
 * @package vogue
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( presscore_is_content_visible() ): ?>

			</div><!-- .wf-container -->
		</div><!-- .wf-wrap -->
	</div><!-- #main -->

	<?php
	if ( presscore_config()->get( 'template.footer.background.slideout_mode' ) ) {
		echo '</div>';
	}

	do_action( 'presscore_after_main_container' );
	?>

<?php endif; // presscore_is_content_visible ?>

	<div id="newfooterbar" style="display: none;">
		<a id="help_to_buy" href="http://www.helptobuy.gov.uk" target="_blank"><img border="0" width="100" src="http://www.butlerscrescent.co.uk/wp-content/themes/butlerscrescent/images/htb_gov.svg" onerror="this.onerror=null; this.src='http://www.butlerscrescent.co.uk/wp-content/themes/butlerscrescent/images/htb_gov.svg'" data-pin-nopin="true"></a>
		<a id="consumer_code" href="http://www.consumercode.co.uk" target="_blank"><img border="0" width="100" src="http://www.butlerscrescent.co.uk/wp-content/themes/butlerscrescent/images/consumercode.png" onerror="this.onerror=null; this.src='http://www.butlerscrescent.co.uk/wp-content/themes/butlerscrescent/images/consumercode.png'" data-pin-nopin="true"></a>
	</div>
	<a href="#" class="scroll-top"></a>
</div><!-- #page -->

<!-- The Modal -->
<div id="virtualModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
		<iframe width="100%" height="480" src="https://my.matterport.com/show/?m=jezA18wqGvT" frameborder="0" allowfullscreen></iframe>
  </div>

</div>


<script type="text/javascript">

// Get the modal
var modal = document.getElementById('virtualModal');

// Get the button that opens the modal
var btn = document.getElementById("virtualBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

</script>



<?php wp_footer(); ?>

</body>
</html>