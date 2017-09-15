function loadMapdata() {
	
         var infoWindows = [];
        function closeAllInfoWindows() {
          for (var i=0;i<infoWindows.length;i++) {
             infoWindows[i].close();
          }
		  
		 // Removes the markers from the map, but keeps them in the array.
		 //setMapOnAll(null);
		 // Shows any markers currently in the array.
		 //setMapOnAll(mapdata);
		  
        }
            
		function initMap(mapdata, start_lat, start_lng) {
		  var customMapType = new google.maps.StyledMapType([
    {
        "featureType": "all",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#85b09a"
            }
        ]
    },
    {
        "featureType": "all",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "gamma": 0.01
            },
            {
                "lightness": 20
            }
        ]
    },
    {
        "featureType": "all",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "saturation": -31
            },
            {
                "lightness": -33
            },
            {
                "weight": 2
            },
            {
                "gamma": 0.8
            }
        ]
    },
    {
        "featureType": "all",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "gamma": "1"
            },
            {
                "color": "#92bca5"
            }
        ]
    },
    {
        "featureType": "landscape.natural",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#cbddd2"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "geometry",
        "stylers": [
            {
                "lightness": 10
            },
            {
                "saturation": -30
            },
            {
                "gamma": "2"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "gamma": "2.00"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "labels",
        "stylers": [
            {
                "weight": "0.01"
            },
            {
                "color": "#b1b1b1"
            },
            {
                "gamma": "0.30"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry",
        "stylers": [
            {
                "gamma": "3.00"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "labels.text",
        "stylers": [
            {
                "weight": "0.60"
            },
            {
                "lightness": "0"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "lightness": -20
            }
        ]
    }
], {
			  name: 'Custom'
		  });
		  var customMapTypeId = 'custom_style',
		  isDraggable = jQuery(window).width() < 800 ? false : true, //!('ontouchstart' in document.documentElement),
		  zoomlev = jQuery(window).width() < 800 || ( navigator.userAgent.match(/iPad/i) != null ) ? 13 : 14,
		  map = new google.maps.Map(document.getElementById('map_56e6c552e6fc9'), {
			zoom: zoomlev,
			center: {lat: parseFloat(start_lat),lng: parseFloat(start_lng)},
			mapTypeControlOptions: {
			  //mapTypeIds: [google.maps.MapTypeId.ROADMAP, customMapTypeId]
			  mapTypeIds:[] //to hide options
			},
			streetViewControl:false,
			scrollwheel: false,
			draggable: isDraggable //http://trulycode.com/bytes/disable-google-maps-drag-zoom-mobile-iphone/
		  });
		  

		 map.mapTypes.set(customMapTypeId, customMapType);
		 map.setMapTypeId(customMapTypeId);
          
          /*var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          var labelIndex = 0;*/
          
          // Adds a marker to the map.
          function addMarker(location, info, map, icon, index) {
            // Add the marker at the clicked location, and add the next-available label
            // from the array of alphabetical characters.
			
            if (icon == "") icon = null;
			
            var marker = new google.maps.Marker({
				position: location,
				animation: google.maps.Animation.DROP,
				//label: labels[labelIndex++ % labels.length],
				map: map,
				icon: icon
            });
			
			
			function pinClick() {
				//just center
				//map.setCenter(marker.getPosition());
				//animate center
				//map.panTo(marker.getPosition());
				
              	//closeAllInfoWindows();
              	var infowindow = new google.maps.InfoWindow({content:info});
                //add infowindow to array
                infoWindows.push(infowindow); 
              	infowindow.open(map, marker);
				
				var string = marker.getIcon(),
					substring = "butlers.png";
					
				//don't touch butlers icon
				if(string.indexOf(substring) == -1) {
					marker.setIcon(ajax_object.pins_url + "pin_selected.png");
					google.maps.event.addListener(infowindow, 'closeclick', function() {  
						marker.setIcon(ajax_object.pins_url + "pin.png");
					});
				}

            };

            marker.addListener('click',function(){pinClick();});
			
			//focus a pin and open info window
			//if(index == 0) setTimeout(function(){ pinClick(); },mapdata.length * 1000 ); 

          }
		  

		  
		setTimeout(function(){
			if(mapdata && mapdata != 'undefined') {
				jQuery.each(mapdata, function (index, value) {
					if(value.geo_code) {
						var latlng = value.geo_code.split(','), icon = ajax_object.pins_url + value.icon, html = '<strong>'+value.title+'</strong><pre style="font-family:Roboto, Arial, sans-serif;">'+value.address+'</pre>';
						if(value.website) html = html + '<a href="'+value.website+'" target="_blank" style="color:black;">Visit Website</a>';
						//setTimeout(function(){ addMarker({ lat: parseFloat(latlng[0]), lng: parseFloat(latlng[1]), }, html, map, icon, index); },1000 * index);
						addMarker({ lat: parseFloat(latlng[0]), lng: parseFloat(latlng[1]), }, html, map, icon, index);
					}
				});
			}
		},1000);


}
 
 jQuery(function($) {
	$("#map_56e6c552e6fc9").html('<p style="text-align:center; width:100%;position: absolute;top: 50%;">Loading...</p>');
	var data = {
		'action': 'get_mapdata',
		'paged': ajax_object.paged      // We pass php values differently!
	};
	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
	
	$.post(ajax_object.ajax_url, data, function(response) {
		//alert('Got this from the server: ' + response);
		mapdata = jQuery.parseJSON(response);
		//console.log({mapdata});
		}).done(function() {
			
			var pin0 = mapdata[0];
			//load first pin as map center
			
			if(pin0.geo_code) {
				var lat_lng = pin0.geo_code.split(',');
				var lat = lat_lng[0];
				var lng = lat_lng[1];
				//console.log(lat_lng);
				//console.log({lat,lng});
				initMap(mapdata,lat,lng); 
			} else {
				
				$("#map_56e6c552e6fc9").html('<p style="text-align:center; width:100%;position: absolute;top: 50%;">No location geo codes loaded in admin!</p>');
			}
			
	});
 });
 
}
	
jQuery(document).ready(function($) {
	loadMapdata();
});


            


          