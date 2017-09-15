var copy_htb = function(){jQuery(function($) {
    $(".mobile-header-bar .mobile-navigation").append( $('<a id="help_to_buy2"></a>') );
	$(".mobile-navigation #help_to_buy2").html( $("#help_to_buy").html() );
})};

jQuery(document).ready(function($){
	
	//console.log( navigator.userAgent );
	
	if (navigator.userAgent.indexOf(") Gecko") != -1) {
		$("body").addClass('ff');
	}
	
	if (navigator.platform.indexOf("Mac") != -1 && navigator.userAgent.indexOf(") Gecko") != -1) {
		$("body").addClass('macff');
	}
	
	if( navigator.userAgent.indexOf("Safari/9") != -1) {
		//$("body").addClass('oldsafari');
		//console.log('oldsafari');
	}
	
	
	$('.mfp-image, .mfp-arrow').live('click', function(){
		var txt = $('.mfp-title-wrap small').html();
		$('.mfp-title-wrap').html('<small>' + txt + '</small>');
	});
	
	copy_htb();

})



