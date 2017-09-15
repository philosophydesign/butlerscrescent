<script type="text/javascript">
jQuery(function($){
	
	//special = ["21", "41", "40"];
	var standard = [],
	special = ["WALKER","PARKER","EARL","WOODHOUSE", "BRIDGEWATER",/* STD */"HIPKINS","TAYLOR","TILLEY","POOLE","GARRATT","COLDICOTT"/*,"OTHER"*/];
	clicked = [];

	$.get(ajax_object.svg_url, function(data) {
		$("#site-plan .container").append(data.documentElement).after(function(){
			
			console.log("standard");
			standard.forEach(function(item,index) {
				
				console.log({index,item});
			
				$("#" + item + " [id^=item]").click(function() {
					var id = $(this).attr('id');
					console.log(id + ' click');

					/*if( special.indexOf( id.replace("item", "") ) > -1 ) {
						//special treatment - do nothing
					} else {*/
						//standard treatment - black border
						$('#' + id + ' rect:nth-child(1)').css({'stroke':'#000','stroke-width':'3'});
					/*}*/
					
				});
				
			});
			
			console.log("special");
			special.forEach(function(item,index) {
				
				console.log({index,item});
			
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