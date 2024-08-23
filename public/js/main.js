

var map;
var marker;
var directionsRenderer;
var autocomplete;
var currentInfoWindow = null;
let markers =  [];
var chosenMarker;
let isCircleVisible = true;


// Function to initialize the map
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 10.3022592, lng: 123.8827008},
        zoom: 16,
        streetViewControl: false,
        zoomControl: false,
        
    });


    fetch('/accident-reports')
    .then(response => response.json())
    .then(data => {
        // Add markers for each accident report
        data.forEach(report => {
            addMarker(report.latitude, report.longitude, report.name, report.email, report.description, report.image_url, report.location_status, report.created_at);
            
        });
    })
    .catch(error => console.error('Error fetching accident reports:', error));

}

function addMarker(latitude, longitude, name, email, description, imageUrl, locationStatus, created_at) {
    // Check the location status before adding a marker
    if (locationStatus) {
        const marker = new google.maps.Marker({
            position: { lat: parseFloat(latitude), lng: parseFloat(longitude) },
            map: map,
            title: description
        });

        markers.push(marker);

        // Parse created_at into a Date object
        const createdAtDate = new Date(created_at);

        // Format the date to only display the date part
        const formattedDate = createdAtDate.toLocaleDateString('en-US');
        const formattedTime = createdAtDate.toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric' });

        // Create a circle around the marker
        const circle = new google.maps.Circle({
            map: map,
            radius: 100, // Set the radius in meters (adjust as needed)
            fillColor: '#e6bbf2', // Set the fill color of the circle
            strokeColor: '#fc4e42',  // Light purple color
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillOpacity: 0.2, // Set the stroke color of the circle
            visible: true // Set the initial visibility state
        });
        circle.bindTo('center', marker, 'position'); // Bind the circle to the marker

        // Store the circle as a property of the marker
        marker.circle = circle;

        // Create HTML content for the info window
        const infoWindowContent = `
            <div class="info-card">
                <div class="reportImage" id="reportImage">
                    <img src="${window.baseUrl + imageUrl}" alt="Report Image"><br>
                    <a href="#" onclick="toggleContent(event, '${window.baseUrl + imageUrl}', '${name}', '${email}', '${description}', '${formattedDate} ${formattedTime}')">
                        See more Details
                    </a>
                </div>   
                <div class="content" id="additionalContent" style="display: none;">
                    <strong>Name: ${name}</strong>
                    <h3>Reported by:</h3>${email}
                    <h3>Description:</h3> ${description}
                    <h3>DateReported:</h3>${formattedDate}
                    <h3>TimeHappened:</h3>${formattedTime}<br><br>
                    <a href="#" onclick="toggleContent(event, '${window.baseUrl + imageUrl}', '${name}', '${email}', '${description}', '${formattedDate} ${formattedTime}')">
                        See Reported Image
                    </a>
                </div>
            </div>
        `;

        // Create an info window with the HTML content
        const infoWindow = new google.maps.InfoWindow({ maxWidth: 250, content: infoWindowContent });

        // Attach a click event listener to the marker to open the info window
        marker.addListener('click', function () {
            // Close the current info window if one is open
            if (currentInfoWindow) {
                currentInfoWindow.close();
            }

            // Open the clicked info window
            infoWindow.open(map, marker);

            // Set the current info window to the clicked one
            currentInfoWindow = infoWindow;
        });
    }



    // Initialize the Places Autocomplete service
    autocomplete = new google.maps.places.Autocomplete(
        document.getElementById('destination'),
        { types: ['geocode'] }
    );

    // Create a DirectionsRenderer to display the route
    directionsRenderer = new google.maps.DirectionsRenderer({ map: map });
}



function toggleRadiusCircle() {
    markers.forEach(marker => {
        const circle = marker.circle;
        if (circle) {
            circle.setVisible(isCircleVisible);
        }
    });

    isCircleVisible = !isCircleVisible;
}

function toggleContent(event, name, email, description, time) {
    event.preventDefault(); // Prevent anchor tag from navigating

    const reportImage = document.getElementById('reportImage');
    const additionalContent = document.getElementById('additionalContent');

    // Toggle the visibility of the image and additional content
    if (reportImage.style.display === 'none' ) {
        reportImage.style.display = 'block';
        additionalContent.style.display = 'none';
    } else {
        reportImage.style.display = 'none';
        additionalContent.style.display = 'block';
    }
}


// Function to get user's location
function getUserLocation() {
    // Check if geolocation is supported
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            // Success callback
            function (position) {
                // Display the user's latitude and longitude in the input elements
                var latitudeInput = document.getElementById('latitude');
                latitudeInput.value = position.coords.latitude;

                var longitudeInput = document.getElementById('longitude');
                longitudeInput.value = position.coords.longitude;
                map.setCenter({ lat: position.coords.latitude, lng: position.coords.longitude });
                // Fetch the user's chosen marker from the server
                fetch('/get-chosen-marker')
                    .then(response => response.json())
                    .then(data => {
                        var chosenMarker = data;

                        if (chosenMarker === 'default') {
                            // If chosen marker is '1', create the default marker
                            createDefaultMarker(position.coords.latitude, position.coords.longitude);
                        } else {
                            // Otherwise, set the custom marker based on the chosen marker
                            setCustomMarker(position.coords.latitude, position.coords.longitude, chosenMarker);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching chosen marker:', error);
                        // Handle the error as needed
                        // Create a default marker if there's an error fetching the chosen marker
                        createDefaultMarker(position.coords.latitude, position.coords.longitude);
                    });
            },
            // Error callback
            function (error) {
                console.error('Error getting user location:', error);
            }
        );
    } else {
        console.error('Geolocation is not supported by this browser.');
    }
}
                
function setCustomMarker(latitude, longitude, chosenMarker) {
    try {
        marker = new google.maps.Marker({
            position: { lat: parseFloat(latitude), lng: parseFloat(longitude) },
            map: map,
            title: 'Your Location',
            animation: google.maps.Animation.DROP,
            icon: '/img/' + chosenMarker,
        });
    } catch (error) {
        console.error('Error setting custom marker:', error);
        // If there's an error setting the custom marker, create a default marker
        createDefaultMarker(latitude, longitude);
    }
}
    
// Function to create a default marker
function createDefaultMarker(latitude, longitude) {
    marker = new google.maps.Marker({
        position: { lat: parseFloat(latitude), lng: parseFloat(longitude) },
        map: map,
        title: 'Your Location',
        animation: google.maps.Animation.DROP,
    });
}
// Function to compute the route between the user's location and the searched destination
function computeRoute() {
    // Get the destination from the input element
    var destinationInput = document.getElementById('destination');
    var destination = destinationInput.value;

    // Get the latitude and longitude from the input elements
    var originLatitude = parseFloat(document.getElementById('latitude').value);
    var originLongitude = parseFloat(document.getElementById('longitude').value);

    // Create a LatLng object with the user's location
    var origin = new google.maps.LatLng(originLatitude, originLongitude);

    // If a marker exists, remove it
    if (marker) {
        marker.setMap(null);
    }

    // Clear previous route and reset directionsRenderer
    directionsRenderer.setMap(null);
    directionsRenderer = new google.maps.DirectionsRenderer({ map: map });

    // Use Places Autocomplete to get the place details, including the location's LatLng
    var placesService = new google.maps.places.PlacesService(map);

    placesService.findPlaceFromQuery(
        {
            query: destination,
            fields: ['geometry']
        },
        function (results, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK && results && results.length > 0) {
                var destinationLocation = results[0].geometry.location;

                // Create a DirectionsService to compute the route
                var directionsService = new google.maps.DirectionsService();

                // Create a request object with the origin, destination, and travel mode
                var request = {
                    origin: origin,
                    destination: destinationLocation,
                    travelMode: google.maps.TravelMode.DRIVING
                };

                // Use the DirectionsService to compute the route
                directionsService.route(request, function (result, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        // Check if the route passes near any stored markers
                        if (checkRouteNearMarkers(result.routes[0])) {
                            Swal.fire({
                                title: '<p style="color: red" >Luffy Warning!</p>You are about to pass an Reported incidents',
                                html: 'PROCEED WITH <span style="color: red; font-size: 30px; font-weight: bold ">CAUTION</span>',
                                imageUrl: "/images/hehe.png",
                                imageWidth: 300,
                                imageHeight: 400,
                                imageAlt: "Custom image"
                              });
                            // If the route passes near markers, compute the alternative route
                            computeAlternativeRoute();
                        } else {
                            // Display the route on the map
                            directionsRenderer.setDirections(result);
                        }
                    } else {
                        console.error('Error computing route:', status);
                    }
                });
            } else {
                console.error('Error getting destination details:', status);
            }
        }
    );
}

function checkRouteNearMarkers(route) {
    // Adjust the threshold distance if needed
    var thresholdDistance = 500; // in meters

    // Iterate over each step in the route
    for (var i = 0; i < route.legs.length; i++) {
        var leg = route.legs[i];
        for (var j = 0; j < leg.steps.length; j++) {
            var step = leg.steps[j];

            // Iterate over each stored marker
            for (var k = 0; k < markers.length; k++) {
                var marker = markers[k];

                // Calculate the distance between the step's end location and the marker
                var distance = google.maps.geometry.spherical.computeDistanceBetween(
                    step.end_location,
                    marker.getPosition()
                );

                // If the distance is within the threshold, return true
                if (distance < thresholdDistance) {
                    return true;
                }
            }
        }
    }

    // If no markers are near the route, return false
    return false;
}



function toggleUserLocationMarker() {
    if (marker) {
        // If marker exists, toggle visibility
        if (marker.getMap()) {
            marker.setMap(null); // Hide marker
        } else {
            marker.setMap(map); // Show marker
        }
    }
}

function showUserLocationMarker() {
    // Fetch the user's chosen marker from the server
    fetch('/get-chosen-marker')
        .then(response => response.json())
        .then(data => {
            var chosenMarker = data;

            if (chosenMarker === 'default') {
                // If chosen marker is '1', create the default marker
                createDefaultMarker(parseFloat(document.getElementById('latitude').value), parseFloat(document.getElementById('longitude').value));
            } else {
                // Otherwise, set the custom marker based on the chosen marker
                setCustomMarker(parseFloat(document.getElementById('latitude').value), parseFloat(document.getElementById('longitude').value), chosenMarker);
            }
        })
        .catch(error => {
            console.error('Error fetching chosen marker:', error);
            // Handle the error as needed
            // Create a default marker if there's an error fetching the chosen marker
            createDefaultMarker(parseFloat(document.getElementById('latitude').value), parseFloat(document.getElementById('longitude').value));
        });
}

function computeAlternativeRoute() {
    // Get the destination from the input element
    var destinationInput = document.getElementById('destination');
    var destination = destinationInput.value;

    // Get the latitude and longitude from the input elements
    var originLatitude = parseFloat(document.getElementById('latitude').value);
    var originLongitude = parseFloat(document.getElementById('longitude').value);

    // Create a LatLng object with the user's location
    var origin = new google.maps.LatLng(originLatitude, originLongitude);

    // If a marker exists, remove it
    if (marker) {
        marker.setMap(null);
    }

    // Clear previous route and reset directionsRenderer
    directionsRenderer.setMap(null);
    directionsRenderer = new google.maps.DirectionsRenderer({ map: map });

    // Use Places Autocomplete to get the place details, including the location's LatLng
    var placesService = new google.maps.places.PlacesService(map);

    placesService.findPlaceFromQuery(
        {
            query: destination,
            fields: ['geometry']
        },
        function (results, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK && results && results.length > 0) {
                var destinationLocation = results[0].geometry.location;

                // Create a DirectionsService to compute the alternative route
                var directionsService = new google.maps.DirectionsService();

                // Create a request object with the origin, destination, and travel mode
                var request = {
                    origin: origin,
                    destination: destinationLocation,
                    travelMode: google.maps.TravelMode.DRIVING
                };

                // Use the DirectionsService to compute the alternative route
                directionsService.route(request, function (result, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        // Log additional information for debugging
                        console.log('Alternative Route:', result);

                        // Check if the alternative route passes near any stored markers
                        if (checkRouteNearMarkers(result.routes[0])) {
                            // Display an alert indicating that the alternative route passes near a stored marker location
                        
                        }

                        // Display the alternative route on the map
                        directionsRenderer.setDirections(result);
                    } else {
                        console.error('Error computing alternative route:', status);
                    }
                });
            } else {
                console.error('Error getting destination details:', status);
            }
        }
    );
}
// Function to redirect to the accident report form
function redirectToReportForm() {
    // Get the latitude and longitude from the input elements
    var userLatitude = document.getElementById('latitude').value;
    var userLongitude = document.getElementById('longitude').value;

    // Redirect to the accident report form with user's location parameters
    window.location.href = '/form?lat=' + userLatitude + '&lng=' + userLongitude;
}

window.onload = function() {
    getUserLocation();
};

// Initialize the map when the page loads

// template

const body = document.querySelector("body");

const sidebar = document.querySelector(".sidebar");
const submenuItems = document.querySelectorAll(".submenu_item");
const sidebarOpen = document.querySelector("#sidebarOpen");
const sidebarClose = document.querySelector(".collapse_sidebar");
const sidebarExpand = document.querySelector(".expand_sidebar");
const floatingButtons = document.getElementById('floating-buttons');

sidebarOpen.addEventListener("click", () => {
    sidebar.classList.toggle("close");
    adjustFloatingButtons();
});

sidebarClose.addEventListener("click", () => {
    sidebar.classList.add("close");
    adjustFloatingButtons();
});

sidebarExpand.addEventListener("click", () => {
    sidebar.classList.remove("close");
    adjustFloatingButtons();
});

submenuItems.forEach((item, index) => {
    item.addEventListener("click", () => {
        item.classList.toggle("show_submenu");
        submenuItems.forEach((item2, index2) => {
            if (index !== index2) {
                item2.classList.remove("show_submenu");
            }
        });
    });
});

document.querySelector('#destination').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        computeRoute();
    }
});

function adjustFloatingButtons() {
    if (sidebar.classList.contains('close')) {
        floatingButtons.style.left = '30px'; // Adjust as needed when sidebar is collapsed
    } else {
        floatingButtons.style.left = '300px'; // Adjust as needed when sidebar is expanded
    }
}

// Initial adjustment based on the current state of the sidebar
adjustFloatingButtons();


initMap();