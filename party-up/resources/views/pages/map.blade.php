@extends ('layouts.manager')
@section('headerFiles')
@endsection
@section('content')
	<div>
        <input id="pac-input" class="controls" type="text" placeholder="Search Box">
        <button id="locationButton">Add Location</button>
        <button id="startButton" onclick="createRouteStart()">Add Start</button>
        <button id="endButton" onclick="createRouteEnd()">Add End</button>
    </div>

    <div id="map"></div>
    <script>
        var map; //Main map
        var currentDriver; //Current Driver Position
        var otherDrivers; //Other Drivers
        var locations; //Locations On Route
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
                zoom: 8,
                mapTypeId: 'roadmap'
            });

            directionsDisplay.setMap(map);

            /*
            if (routeStart != null) {
                addWaypoints();
                addOtherDrivers();
                addCurrentDriver();
            }
            */

            addWaypoints();
            addOtherDrivers();
            addCurrentDriver();

            // Create the search box and link it to the UI element.
            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function () {
                searchBox.setBounds(map.getBounds());
            });
            
            searchBox.addListener('places_changed', function () {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                placeSearch = places[0];

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function (place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }

                });
                map.fitBounds(bounds);
            });
        }

        //Create route start
        function createRouteStart() {
            routeStart = placeSearch;
            console.log("Route Start: " + routeStart);

            //Set Waypoint For Start
        }

        //Create route end
        function createRouteEnd() {
            routeEnd = placeSearch;
            console.log("Route End: " + routeEnd);

            //Set Waypoint For End
        }

        function addWaypoints() {
            var pos = [{ lat: -25.363, lng: 131.044 }, { lat: 41.878, lng: -87.629 }]; //Need to get waypoint data / add to it

            locations = pos;

            addWaypointMarkers();
        }

        function addWaypointMarkers() {
            var i;
            for (i = 0; i < locations.length; i++) {
                var way = locations[i];

                var lat = way.lat;
                var long = way.lng;
                var position = new google.maps.LatLng(lat, long);

                addLocationMarker(position, 'TITLE', '<p>CONTENT<p>');
            }
        }

        function addOtherDrivers() {
            var drivers = [{ lat: 41.878, lng: -87.639 }, { lat: 41.878, lng: -85.629 }, { lat: 41.878, lng: -83.619 }, { lat: 41.878, lng: -81.609 }]; //Need to get other driver data / add to it

            otherDrivers = drivers;

            addOtherDriverMarkers();
        }

        function addOtherDriverMarkers() {

            var i;
            for (i = 0; i < otherDrivers.length; i++) {
                var way = otherDrivers[i];

                addDriverMarkers(way, 'Uluru2', '<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large ' +
                    'sandstone rock formation in the southern part of the ' +
                    'Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) ' +
                    'south west of the nearest large town, Alice Springs; 450&#160;km ' +
                    '(280&#160;mi) by road. Kata Tjuta and Uluru are the two major ' +
                    'features of the Uluru - Kata Tjuta National Park. Uluru is ' +
                    'sacred to the Pitjantjatjara and Yankunytjatjara, the ' +
                    'Aboriginal people of the area. It has many springs, waterholes, ' +
                    'rock caves and ancient paintings. Uluru is listed as a World ' +
                    'Heritage Site.</p>' +
                    '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' +
                    'https://en.wikipedia.org/w/index.php?title=Uluru</a> ' +
                    '(last visited June 22, 2009).</p>', 'other');
            }
        }

        function addCurrentDriver() {
            var curr = { lat: 61.878, lng: -87.659 }
            currentDriver = curr;

            addCurrentDriverMarker();
        }

        function addCurrentDriverMarker() {
            addDriverMarkers({ lat: 61.878, lng: -87.659 }, 'Uluru', '<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large ' +
                'sandstone rock formation in the southern part of the ' +
                'Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) ' +
                'south west of the nearest large town, Alice Springs; 450&#160;km ' +
                '(280&#160;mi) by road. Kata Tjuta and Uluru are the two major ' +
                'features of the Uluru - Kata Tjuta National Park. Uluru is ' +
                'sacred to the Pitjantjatjara and Yankunytjatjara, the ' +
                'Aboriginal people of the area. It has many springs, waterholes, ' +
                'rock caves and ancient paintings. Uluru is listed as a World ' +
                'Heritage Site.</p>' +
                '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' +
                'https://en.wikipedia.org/w/index.php?title=Uluru</a> ' +
                '(last visited June 22, 2009).</p>', 'driver');


            map.setCenter(new google.maps.LagLng(currentDriver));
        }

        function addRouteStartEndMarker(pos, type) {

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
                i = 'marker1.png';
            }
            else {
                i = 'marker2.png';
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
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYVN9D5r-6ZZ90YqB-gFg0_aPuwveXzus&libraries=places&callback=initAutocomplete"
        async defer></script>
@endsection

