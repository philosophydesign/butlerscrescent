jQuery(function($){
	var geocoder;

	function codeAddress(address){
		geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				return results[0].geometry.location;
			} else { return "Geocode was not successful for the following reason: " + status; }
		});
	};

	
	$(document).ready(function($) {
		//alert('script runs!');
		
		$('#acf-geo_code .label').append('<button id="geocode_btn" class="button button-large">Get GeoCode from Address</button>');
		
		$('#geocode_btn').click(function(e){
			var address = $("#acf-field-address").val(), url = encodeURI('https://maps.googleapis.com/maps/api/geocode/json?address=' + address + '&key=AIzaSyD1mTwIBQ5fMfQIKRCtt99qstD31zYQV_M');
			
			$.get( url, function( data ) {
				var result = data.results[0].geometry.location.lat + ',' + data.results[0].geometry.location.lng
				$("#acf-field-geo_code").val(result);
				console.log({address,result});
			});
			
			//alert("button clicked \n\r" + address);
			
			//console.log( codeAddress(address) );
			
			e.preventDefault();
			
			
		});
		
	});
	
	
});