@extends ('layouts.manager')
@section('headerFiles')
@endsection
@section('content')
	<div>
        <input id="pac-input" class="controls" type="text" placeholder="Search Box">
		<button id="notificationsButton" onclick="toggleNotifications()">Notifications</button>
        <button id="locationButton" onclick="createWaypoint()">Add Location</button>
        <button id="startButton" onclick="createRouteStart()">Add Start</button>
        <button id="endButton" onclick="createRouteEnd()">Add End</button>
		<button id="menuButton" onclick="toggleMenu()">More</button>
        <button id="broadcastButton" onclick="broadcast()">Broadcasting</button>
        {{$group_name}}
        {{$group_code}}
        {{$group_dest}}
    </div>

	<div id="notifications">
		<button class="backButton" onclick="toggleNotifications()">Back</button>
		<div id="messages">
		</div>
	</div>
    <div id="map"></div>
	<div id="menu">
		<button class="backButton" onclick="toggleMenu()">Back</button>
		<button class="groupsButton" onclick="location.href='/Groups'">Groups</button>
		<h1> Current Party </h1>
		<div id="currentGroup"> 
			@foreach ($cars as $car)	
			<div class="teamMember">
				<h2> {!! $car[4].' '.$car[5] !!} </h2>
			</div>
			@endforeach
		</div>
	</div>
    <script>
		$("#notifications").toggle();
		$("#menu").toggle();
		
		$(document).ready(function() {
			$.ajax({url: "/stopBroadcast"});
		});

		$(window).on('beforeunload', function(){
			$.ajax({url: "/stopBroadcast"});
		});

		var toggled = false;

        broadcast = function() {
            $.ajax({
              url: "/setBroadcast",
            }); 

			if (!toggled) {
				toggled = true;
				$("#broadcastButton").css('color', 'red !important');
				$("#broadcastButton").css('background-color', '#fc5b5b');
				$("#broadcastButton").css('border-color', '#fc5b5b');
			} else {
				toggled = false;
				$("#broadcastButton").css('color', 'white !important');
				$("#broadcastButton").css('background-color', 'rgba(0,0,0,0)'); 
				$("#broadcastButton").css('border-color', 'white');
			}
			
        };

		var myVar = setInterval(myTimer, 5000);

        function myTimer() {

            addWaypoints();
            addOtherDrivers();
            addCurrentDriver();

            updateCenter();
			
		    $.ajax({url: "/getVehicles"});
        }

        var map; //Main map
        var currentDriver; //Current Driver Position
        var otherDrivers = []; //Other Drivers
        var locations = []; //Locations On Route
        var routeStart; //Route Start
        var routeEnd; //Route End
        var directionsService;
        var directionsDisplay;
        var placeSearch;

        function initAutocomplete() {
            directionsService = new google.maps.DirectionsService;
            directionsDisplay = new google.maps.DirectionsRenderer;

            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 40, lng: -100 },
                mapTypeId: 'roadmap'
            });

            directionsDisplay.setMap(map);

            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            map.addListener('bounds_changed', function () {
                searchBox.setBounds(map.getBounds());
            });
            
            searchBox.addListener('places_changed', function () {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                placeSearch = {lat: places[0].geometry.location.lat(), lng: places[0].geometry.location.lng()} ;

                var bounds = new google.maps.LatLngBounds();
                places.forEach(function (place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }

                    if (place.geometry.viewport) {
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }

                });
                map.fitBounds(bounds);
            });

			if(navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            }

            function showPosition(position) {
                currentDriver = {lat: position.coords.latitude, lng: position.coords.longitude};
                
                var bounds = new google.maps.LatLngBounds();
                bounds.extend(currentDriver);
                map.fitBounds(bounds);

				zoomChangeBoundsListener = 
   				google.maps.event.addListenerOnce(map, 'bounds_changed', function(event) {
        			if (this.getZoom()){
            			this.setZoom(16);
       				 }
				});
				setTimeout(function(){google.maps.event.removeListener(zoomChangeBoundsListener)}, 2000);
            }   
        }

        function updateCenter() {
             if ((!map.getBounds().contains(currentDriver))) {
                var bounds = new google.maps.LatLngBounds();
                bounds.extend(currentDriver);
                map.fitBounds(bounds);
            }
        }

        function createRouteStart() {
            routeStart = placeSearch;
            console.log("Route Start: " + routeStart);

            pushStart();

            addRouteStartEndMarker("start");
        }

        function pushStart() {
            //implement
        }

        function createRouteEnd() {
            routeEnd = placeSearch;
            console.log("Route End: " + routeEnd);

            pushDestination();

            addRouteStartEndMarker("end");
        }

        function pushDestination() {
            //implement
        }

        function createWaypoint() {
            console.log(placeSearch);
            locations.push(placeSearch);

            pushWaypoint(placeSearch);

            addWaypoints();
        }

        function pushWaypoint(pos) {
            //Implement
        }

        function addWaypoints() {
            addWaypointMarkers();
        }

        function addWaypointMarkers() {
            var i;
            for (i = 0; i < locations.length; i++) {
                var way = locations[i];

                var lat = way.lat;
                var long = way.lng;
                var position = new google.maps.LatLng(lat, long);

                addLocationMarker(position, 'Waypoint', '');
            }
        }

        function addOtherDrivers() {
            // var drivers = [{ lat: 41.878, lng: -87.639 }, { lat: 41.878, lng: -85.629 }, { lat: 41.878, lng: -83.619 }, { lat: 41.878, lng: -81.609 }]; //Need to get other driver data / add to it

            //Retrieve Data From Service
            var username;
            var broadcasting;
            var lat;
            var long;
			otherDrivers = [];

            @foreach ($cars as $car)
                username = "{{$car[0]}}";
                broadcasting = "{{$car[1]}}";
                lat = Number("{{$car[2]}}");
                long = Number("{{$car[3]}}");
                if(broadcasting == '1') {
				// Need to not push if the this is the driver. 
                    otherDrivers.push({lat: lat, lng: long, name: username});
                }
            @endforeach
            //Driver {lat: , lng: , name: }

            //otherDrivers = drivers;

            addOtherDriverMarkers();
        }

       function addOtherDriverMarkers() {

            //Get Driver Info As Parameters

            var i;
            for (i = 0; i < otherDrivers.length; i++) {
                var way = {lat: otherDrivers[i].lat, lng: otherDrivers[i].lng};

                addDriverMarkers(way,  otherDrivers[i].name, '<p>Hello!</p>', 'other');
            }
        }

        function addCurrentDriver() {
            if(currentDriver == null) {
                var curr = { lat: 61.878, lng: -87.659 }
                currentDriver = curr;
            } 

            //Push to Service ?

            addCurrentDriverMarker();
        }

        function addCurrentDriverMarker() {
            addDriverMarkers(currentDriver, 'Driver Name', '<p>Hello!</p>', 'driver');

        }

        function CalcDriverTrip() {

        }

        function addRouteStartEndMarker(type) {

            //Update to remove old start / end

            var pos;
            var letter;

            if(type == "start") {
                pos = routeStart;
                letter = "A";
            }
            else {
                pos = routeEnd;
                letter = "B";
            }

            var marker = new google.maps.Marker({
                position: pos,
                map: map,
                label: letter
            });
        }

        function addLocationMarker(pos, title, content) {
            var contentString = '<div id="content">' +
                '<div id="siteNotice">' +
                '</div>' +
                '<h1 id="firstHeading" class="firstHeading">' + title + '</h1>' +
                '<div id="bodyContent">' + content +
                '</div>' +
                '</div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            var marker = new google.maps.Marker({
                position: pos,
                map: map,
                title: title
            });
            marker.addListener('click', function () {
                infowindow.open(map, marker);
            });
        }

        function addDriverMarkers(pos, title, content, type) {
            var contentString = '<div id="content">' +
                '<div id="siteNotice">' +
                '</div>' +
                '<h1 id="firstHeading" class="firstHeading">' + title + '</h1>' +
                '<div id="bodyContent">' + content +
                '</div>' +
                '</div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            var i;

            if (type == 'driver') {
                i = '/images/marker1.png';
            }
            else {
                i = '/images/marker2.png';
            }

            var marker = new google.maps.Marker({
                position: pos,
                map: map,
                icon: i,
                title: title
            });
            marker.addListener('click', function () {
                infowindow.open(map, marker);
            });
        }

		function toggleNotifications() {
			$("#notifications").toggle();	
			$("#notifications").css('background-color', 'rgba(84, 84, 84, .8)');
		}

		function toggleMenu() {
			$("#menu").toggle();
			$("#menu").css('background-color', 'rgba(84, 84, 84, .8)');
		}
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYVN9D5r-6ZZ90YqB-gFg0_aPuwveXzus&libraries=places&callback=initAutocomplete"
        async defer></script>
@endsection
