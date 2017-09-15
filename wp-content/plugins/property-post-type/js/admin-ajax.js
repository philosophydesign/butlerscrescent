jQuery(function($){
	
	//$('select[name="_status"] option[value="publish"]').remove();
	//$('input[value="Publish"]').remove();
	$('select option[value="publish"]').text('Available');
	$('select option[value="draft"]').text('Unreleased');
	
	window.addStates = function() {
		var states = ['Reserved','Sold'], //'Unreleased - draft','Available - publish'
		current = $('#hidden_post_status').val();
		
		states.forEach(function(value, index){
			//alert( index + ' = ' + value );
			$('select[name="_status"], #post_status').prepend('<option value="' + value.toLowerCase() + '">' + value + '</option>');
		});
		
		$('select[name="_status"]').each(function(value, index){
				//console.log(index + ' ' + current + ' ' + $(this).val().toLowerCase());
				if( current == $(this).val().toLowerCase() ) {
					$('#selectBox')[0].selectedIndex=index;
				}
		})
		
		$('#post_status option').each(function(index, value ){
			
				var txt = $(this).text(); //.toLowerCase(),
				val = $(this).val(); //.toLowerCase()
				
				//console.log( { index, val, txt} );
				
				if( val == current ) {
					$('#post_status').selectedIndex=index;
					//$( "#post_status option[selected='selected'] " ).text()
					$('#post-status-display').text(txt);
				}
				
		})

		//$('#post-status-display').text( current );
		
		if(current == 'reserved' || current == 'sold') { $('#publish').removeClass('button-primary').addClass('button-disabled').attr('disabled','disabled'); }
		
	}
	
	$(document).ready(function($) {
		//alert('script runs!');
		window.addStates();
		
	});
	
});