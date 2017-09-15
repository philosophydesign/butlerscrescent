var iconurl = '';
var markerattributes = new Array();
function initializegooglemap() {
		 
    	var roadAtlasStyles = [
    {
        "featureType": "all",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#d7d2cb"
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
        "elementType": "geometry",
        "stylers": [
            {
                "lightness": 30
            },
            {
                "saturation": 30
            }
        ]
    },
    {
        "featureType": "landscape.natural.landcover",
        "elementType": "all",
        "stylers": [
            {
                "color": "#5c7f90"
            }
        ]
    },
    {
        "featureType": "landscape.natural.terrain",
        "elementType": "all",
        "stylers": [
            {
                "color": "#85b09a"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "color": "#85b09a"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "geometry",
        "stylers": [
            {
                "saturation": 20
            }
        ]
    },
    {
        "featureType": "poi.park",
        "elementType": "geometry",
        "stylers": [
            {
                "lightness": 20
            },
            {
                "saturation": -20
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "color": "#ffffff"
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
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "saturation": 25
            },
            {
                "lightness": 25
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "lightness": -20
            },
            {
                "color": "#5c7f90"
            }
        ]
    }
	]
	
    var mapOptions = {
    	center: new google.maps.LatLng(52.520069,-2.073945),
	    zoom: 14
	};
	var map = new google.maps.Map(document.getElementById("googlemap"),
			mapOptions);
	var styledMapOptions = {
	                
	};

    var usRoadMapType = new google.maps.StyledMapType(
        roadAtlasStyles, styledMapOptions);
    var marker;
    var markers = new Array();
    var infobox = new InfoBox({
        content: "test",
        disableAutoPan: false,
        maxWidth: 150,
        pixelOffset: new google.maps.Size(20, -140),
        zIndex: null,
        boxStyle: {
           background: "#b8b8af",
           opacity: 1,
           width: "280px",
           height: "auto",
           padding: "10px",
           fontFamily: 'Aldine'
       },
       closeBoxMargin: "5px 4px 2px 2px",
       closeBoxURL: iconBase + 'closebox.png',
       infoBoxClearance: new google.maps.Size(1, 1)
   });
			
	map.mapTypes.set('usroadatlas', usRoadMapType);
	map.setMapTypeId('usroadatlas');
	setMarkers(map, infobox, locations);
	}

 function setMarkers(map, infobox, locations) {
		for (var i = 0; i < locations.length; i++) {
			debug(i+' '+locations[i][0]);
		    var location = locations[i];
		    var myLatLng = new google.maps.LatLng(location[1], location[2]);
		    var marker = new google.maps.Marker({
		        position: myLatLng,
		        map: map,
		        icon: {
		        	url: iconurl,
		        	origin: new google.maps.Point(markerattributes[location[4]][0], markerattributes[location[4]][1]),
		        	size: new google.maps.Size(markerattributes[location[4]][2], markerattributes[location[4]][3])
		        },
		        title: location[0],
		        content: location[3]
		    });
		    google.maps.event.addListener(marker, 'click', function ()
		            {
		    	infobox.setContent(this.content);
		    	infobox.open(map, this);
	    		map.panTo(this.getPosition());
		    });
		}
	}
jQuery(document).ready(function($) {
	
	iconurl = iconBase + 'sprite.png';
	markerattributes['hurstbournelogo'] = new Array (13,97,50,48);
	markerattributes['pointer'] = new Array(15,8,17,22);
	
	google.maps.event.addDomListener(window, 'load', initializegooglemap);

});
