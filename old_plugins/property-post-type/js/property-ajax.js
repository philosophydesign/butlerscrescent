var clicked = [], loaded = [];

function getClicked(){
	return clicked;
};

function getLoaded(){
	return loaded;
};

jQuery(function($) {
	/* UPDATE property-post-type.php FIRST! - Needs to match shortcode! */
	
	var data = {
		'action': 'get_propertydata',
		'paged': ajax_object.paged
	};

	window.intMap = function() {
	
		window.propertydata.forEach(function(item,index) {
			
			//console.log({index,item});
		
			$("#item" + item.plot_no ).bind("click",function() {
				var id = $(this).attr('id');
				//console.log(id + ' click');
				console.log(item);
				window.location.href = item.permalink;
				
				//white border on click
				$('#' + id + ' rect:nth-child(1)').each(function(){
					var y = $(this).attr('y'),
					h = $(this).attr('height');
					$(this).css({'stroke':'#fff','stroke-width':'3'})
					if( clicked.indexOf( id.replace("item", "") ) > -1 ) {/* do nothing */} else {
						//$(this).attr({'y' : parseInt(y) - 10,'height': parseInt(h) + 18 });
						clicked.push( id.replace("item", "") );
					}
				});

			})
		
			$("#item" + item.plot_no ).bind("mouseover",function() {
				var id = $(this).attr('id');
				//console.log(id + ' hover');
				
				//black border on hover
				$('#' + id + ' rect:nth-child(1)').each(function(){
					var y = $(this).attr('y'),
					h = $(this).attr('height');
					$(this).css({'stroke':'#000','stroke-width':'3'})
				});
				
				/*fill: #91908F;
				fill-opacity: 0.5;*/
				
			}).after(function(){
				
				/*
				var id = $(this).attr('id');
				//green border on number (show active)
				$('#' + id + ' rect:nth-child(2)').each(function(){
					var y = $(this).attr('y'),
					h = $(this).attr('height');
					
					var color = '#ff0000'; //red
					if (item.availability == 'Available') color = '#00ff00'; //green
					if (item.availability == 'Reserved') color = '#FFFF00'; //yellow
					$(this).css({'stroke':color,'stroke-width':'3'});

					$('#' + id).css({'cursor':'pointer'});
					
					if( clicked.indexOf( id.replace("item", "") ) > -1 ) {/* do nothing *//*} else {
						$(this).attr({'y' : parseInt(y) - 10,'height': parseInt(h) + 18 });
						clicked.push( id.replace("item", "") );
					}
				});
				*/
				
			});
			
			$("#item" + item.plot_no ).bind("mouseout",function() {
				var id = $(this).attr('id');
				//console.log(id + ' hover');
				
				//black border on hover
				$('#' + id + ' rect:nth-child(1)').each(function(){
					var y = $(this).attr('y'),
					h = $(this).attr('height');
					$(this).css({'stroke':'#91908F','stroke-width':'0.5'})
				});
				
			})
			
		});
		
		

		
	};
	
	window.clearAll = function() {
		$("[id*='item']").each(function(){
			var id = $(this).attr('id');
			$('#' + id + ' rect').css({'stroke':'#91908F','stroke-width':'0.5'});
			$('#' + id).css({'cursor':'default'});
			$(this).unbind( "click" );
		});
		
		loaded = [];
		window.propertydata = [];
	}
	
	window.getPropertyData = function() {
	
		jQuery(document).ready(function($) {
			
			/*$.ajax({
				method: "POST",
				url: ajax_object.ajax_url,
				data: data,
				async: true
			}).done(function( response ) {
				window.propertydata = jQuery.parseJSON(response);
				console.log({"propertydata":window.propertydata});
			});*/

			// Assign handlers immediately after making the request,
			// and remember the jqXHR object for this request
			var jqxhr = $.ajax({
				method:"POST",
				url:ajax_object.ajax_url,
				data:data
			  })
			  .done(function(data) {
				//console.log( "success" );
				window.propertydata = jQuery.parseJSON(data);
			  })
			  .fail(function() {
				//console.log( "error" );
			  })
			 .always(function() {
				//console.log( "complete" );
				//console.log({"propertydata":window.propertydata});
			  });
			 
			// Perform other work here ...
			 
			// Set another completion function for the request above
			jqxhr.always(function() {
			  //console.log( "second complete" );
			  window.intMap();
			});

		});
	};
	
	window.getPropertyData();
 
});