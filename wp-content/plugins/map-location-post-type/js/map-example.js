<script>
            
        var infoWindows = [];
        function closeAllInfoWindows() {
          for (var i=0;i<infoWindows.length;i++) {
             infoWindows[i].close();
          }
        }
            
		function initMap() {
		  var customMapType = new google.maps.StyledMapType([
			  {
				stylers: [
				  {hue: '#008900'},
				  {visibility: 'simplified'},
				  {gamma: 0.5},
				  {weight: 0.5}
				]
			  },
			  {
				elementType: 'labels',
				stylers: [{visibility: 'on'}]
			  },
			  {
				featureType: 'water',
				stylers: [{color: '#e3eedc'}]
			  }
			], {
			  name: 'Custom Style'
		  });
		  var customMapTypeId = 'custom_style';

		  var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 15,
			//center: {lat: 51.2627806, lng: 0.520078},  // Maidstone.
			center: {lat:  51.27262803309403, lng: 0.5270198},
			
			mapTypeControlOptions: {
			  //mapTypeIds: [google.maps.MapTypeId.ROADMAP, customMapTypeId]
			  mapTypeIds:[] //to hide options
			},
			streetViewControl:false,
            scrollwheel: false
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
              icon: greenPin
            });
            
            marker.addListener('click', function() {
              
              	closeAllInfoWindows();
              
              	var infowindow = new google.maps.InfoWindow({content:info});
              
                //add infowindow to array
                infoWindows.push(infowindow); 
              
              	infowindow.open(map, marker);
              
            });

          }
          
          addMarker({ lat: 51.2744368, lng: 0.5270198 }, "Maidstone Community Support Centre, 39-48 Marsham Street, Maidstone, Kent, ME141HH" ,map);
          addMarker({ lat: 51.2733591, lng: 0.5217033 }, "High Street Maidstone Kent ME14 1TF", map);
		}

			</script>