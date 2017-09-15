<script type="text/javascript">
jQuery(function($){

	var standard = [],
	names = ["WALKER","PARKER","EARL","WOODHOUSE", "BRIDGEWATER","HIPKINS","TAYLOR","TILLEY","POOLE","GARRATT","COLDICOTT"];
	clicked = [];

	$.get(ajax_object.svg_url, function(data) {
		$("#site-plan .container").append(data.documentElement).after(function(){
			
			window.testmap = function() {

				names.forEach(function(item,index) {
					
					//console.log({index,item});
				
					$("#" + item + " [id^=item]").click(function() {
						var id = $(this).attr('id');
						console.log(id + ' click');
						
						//special treatment - white border on number
						$('#' + id + ' rect:nth-child(2)').each(function(){
							var y = $(this).attr('y'),
							h = $(this).attr('height');
							$(this).css({'stroke':'#fff','stroke-width':'3'})
							if( clicked.indexOf( item + id.replace("item", "") ) > -1 ) {/* do nothing */} else {
								$(this).attr({'y' : parseInt(y) - 10,'height': parseInt(h) + 18 });
								clicked.push( item + id.replace("item", "") );
							}
						});
						
					});
				});
			};
			
			$("#resetAll").click(function() {
				$("[id*='item']").each(function(){
					var id = $(this).attr('id');
					$('#' + id + ' rect').css({'stroke':'#91908F','stroke-width':'0.5'});
				});
			});
			
		});
	});
	
});
</script>