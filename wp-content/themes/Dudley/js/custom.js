jQuery(document).ready(function($) {

  /*
    jQuery('#topmenu').mobileMenu({
			prependTo:'.mobilenavi'
			});	
	
    jQuery('.pushy').jScrollPane();
    
    
    //get text area to resize
	$( window ).resize(function() {
	   $('.wpcf7-form-control-wrap textarea').css('height','');
	});
  */  
  
  /* 
  	bind feilds:
	  - looking-for-copy -> looking-for
	  - bedrooms-copy -> bedrooms
	  - hear-about-copy -> hear-about
  */
    
  $( "#radio1-copy" ).click(function(e) {
     if(e.hasOwnProperty('originalEvent')) $( "#radio1" ).click();
  });
  
  $( "#radio2-copy" ).click(function(e) {
     if(e.hasOwnProperty('originalEvent')) $( "#radio2" ).click();
  });
  
  $( "#radio1" ).click(function(e) {
     if(e.hasOwnProperty('originalEvent')) $( "#radio1-copy" ).click();
  });
  
  $( "#radio2" ).click(function(e) {
     if(e.hasOwnProperty('originalEvent')) $( "#radio2-copy" ).click();
  });
  
  $( "input[name='bedrooms-copy']" ).change(function(e) {
     // Check input( $( this ).val() ) for validity here
     if(e.hasOwnProperty('originalEvent')) $( "input[name='bedrooms']" ).val( $( this ).val() );
  });
  
  $( "input[name='bedrooms']" ).change(function(e) {
     // Check input( $( this ).val() ) for validity here
     if(e.hasOwnProperty('originalEvent')) $( "input[name='bedrooms-copy']" ).val( $( this ).val() );
  });
  
  $('#hear-about-copy').change(function(e) {
     if(e.hasOwnProperty('originalEvent')) {
	     var $id = $(this).val();
	     var selectfirst = false;
		
	     $('#hear-about option').each(function() {
		if($(this).val() != $id) {
		   //$(this).hide();
		   $(this).removeAttr("selected");
		} else {
		   if(selectfirst == false) {
		     selectfirst = true;
		     $(this).attr('selected', 'selected');
		}
	
		}
	     });
     }
  });
  
  $('#hear-about').change(function(e) {
     if(e.hasOwnProperty('originalEvent')) {
	     var $id = $(this).val();
	     var selectfirst = false;
		
	     $('#hear-about-copy option').each(function() {
		if($(this).val() != $id) {
		   //$(this).hide();
		   $(this).removeAttr("selected");
		} else {
		   if(selectfirst == false) {
		     selectfirst = true;
		     $(this).attr('selected', 'selected');
		}
	
		}
	     });
     }
  });
	
});