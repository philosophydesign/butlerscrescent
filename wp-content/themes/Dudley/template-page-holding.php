<?php
/*
File: template-page-holding.php
Template Name: HOLDING
Author: Matthew Bull
*/
while (have_posts()) : the_post(); 
$id = get_the_id();
?>
<!DOCTYPE html>
<html>
<head> 
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
	/************************************/
	/*********** PAGE TITLE *************/
	/************************************/
	$title = get_post_meta($id,'meta-title',true);
	if(empty($title) || $title == '') { ?>
    	<title><?php echo the_title(); ?></title>
    <?php } else { ?>
    	<title><?php echo $title; ?></title>
    <?php } 
	/************************************/
	/*********** #PAGE TITLE ************/
	/************************************/	
	?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
    <meta name="keywords" content="<?php echo get_post_meta($id,'meta-keyword',true); ?>">
    <meta name="description" content="<?php echo get_post_meta($id,'meta-description',true); ?>">
    <link rel="shortcut icon" href="<?php echo get_post_meta($id,'meta-favicon',true); ?>">
    
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-60205633-13', 'auto');
	  ga('send', 'pageview');
	
	</script>
    
	<?php wp_head(); ?>
</head>
<body id="vconepage" <?php body_class(); ?> class="<?php echo get_post_permalink( $ad_onepage_id ); ?>">
<?php 

echo the_content(); 

?>    
    <?php endwhile; ?>
    <?php wp_footer(); ?>
    <?php 
	/************************************/
	/*********** CUSTOM CODE ************/
	/************************************/	
	$custom_js = get_post_meta($id,'meta-custom-js',true);	
	if(!empty($custom_js) || $custom_js != '') { ?>
		<script type="text/javascript">
			<?php echo $custom_js; ?>
		</script>
	<?php }
	$custom_css = get_post_meta($id,'meta-custom-css',true);	
	if(!empty($custom_css) || $custom_css != '') { ?>
		<style type="text/css">
			<?php echo $custom_css; ?>
		</style>
	<?php }  
	/************************************/
	/*********** #CUSTOM CODE ***********/
	/************************************/	
	?> 
    <link rel="stylesheet" type="text/css" href="<?php echo AD_VCOP_URL; ?>assets/css/main.css" />   

  
		  <script>
            
        var infoWindows = [];
        function closeAllInfoWindows() {
          for (var i=0;i<infoWindows.length;i++) {
             infoWindows[i].close();
          }
        }
            
		function initMap() {
		  var customMapType = new google.maps.StyledMapType([{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#d7d2cb"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"hue":"#1900ff"},{"color":"#85b09a"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"color":"#ffffff"},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":700}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#5C7F71"}]}], {
			  name: 'Custom Style'
		  });
		  var customMapTypeId = 'custom_style';

		  var map = new google.maps.Map(document.getElementById('googlemap'), {
			zoom: 15,
			center: {lat:52.5200688,lng:-2.0739452},
			
			mapTypeControlOptions: {
			  //mapTypeIds: [google.maps.MapTypeId.ROADMAP, customMapTypeId]
			  mapTypeIds:[] //to hide options
			},
			streetViewControl:false,
			scrollwheel: false,
			disableDoubleClickZoom: true,
			draggable: false,
			panControl: false
		  });

		  map.mapTypes.set(customMapTypeId, customMapType);
		  map.setMapTypeId(customMapTypeId);
          
          //var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          //var labelIndex = 0;

          var greenPin = {
            path: 'M51.833,0C23.207,0,0,23.206,0,51.833c0,18.068,9.25,33.97,23.268,43.247l28.564,53.088 L80.396,95.08c14.018-9.277,23.268-25.179,23.268-43.247C103.664,23.206,80.458,0,51.833,0 M51.833,75.393 c-13.012,0-23.56-10.548-23.56-23.56s10.548-23.56,23.56-23.56s23.56,10.548,23.56,23.56S64.844,75.393,51.833,75.393',
            fillColor: '#027a37',
            fillOpacity: 1,
            scale: 0.4,
            strokeColor: '#027a37',
            strokeWeight: 1
          };
          
          // Adds a marker to the map.
          function addMarker(location, info, map) {
            // Add the marker at the clicked location, and add the next-available label
            // from the array of alphabetical characters.
            var marker = new google.maps.Marker({
              position: location,
              //label: labels[labelIndex++ % labels.length],
              map: map,
              icon: 'wp-content/themes/Dudley/imgs/map-pin.png'//greenPin
            });
            
            marker.addListener('click', function() {
              
              	closeAllInfoWindows();
              
              	var infowindow = new google.maps.InfoWindow({content:info});
              
                //add infowindow to array
                infoWindows.push(infowindow); 
              
              	infowindow.open(map, marker);
              
            });

          }
          
		  addMarker({lat:52.5200688,lng:-2.0739452}, "Butler’s Crescent,<br> Tipton Road, Dudley,<br> West Midlands,<br> DY1 4SE", map);
		}
		
		
		jQuery(document).ready(function($){
			
			$('#slide1_home').append('<a href="#slide2_launch"><div class="read-more"></div></a>');
			
			$(".read-more").click(function() {
				$('html, body').animate({
					scrollTop: $("#slide2_launch").offset().top
				}, 2000);
				e.preventDefault();
			});
			
		});
			</script>
			<script src="https://maps.googleapis.com/maps/api/js?signed_in=false&amp;callback=initMap" async="" defer=""></script>
	
</body>
</html>