var map;
var marker;
var currentInfoWindow = null;

// Function to initialize the map
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 10.3022592, lng: 123.8827008},
        zoom: 16
    });
    fetch('/get-locations')
        .then(response => response.json())
        .then(data => {
            console.log('Data:', data); // Log the data to the console

            // Add markers for confirmed locations
            data.confirmedLocations.forEach(location => {
                addMarker(location.latitude, location.longitude,location.location_status);
            });

            // Add markers for pending locations
            data.pendingLocations.forEach(location => {
                addMarker(location.latitude, location.longitude,location.location_status);
            });
        })
        .catch(error => console.error('Error fetching locations:', error));
}

function addMarker(latitude,longitude,location_status) {
    console.log('Location Status:', location_status);
    // Set marker icon based on locationStatus
    const markerIcon = location_status
    ? 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
    : 'http://maps.google.com/mapfiles/ms/icons/purple-dot.png';
    const marker = new google.maps.Marker({
        position: { lat: parseFloat(latitude), lng: parseFloat(longitude) },
        map: map,
        title: 'Reported location',
        icon: markerIcon,  // Set the marker icon dynamically
        draggable: true
    });
    google.maps.event.addListener(marker, 'dragend', function (event) {
        // Get the updated position
        const updatedPosition = marker.getPosition();
        const updatedLatitude = updatedPosition.lat();
        const updatedLongitude = updatedPosition.lng();

        // Log the updated position (you can use it as needed)
        console.log('Marker dragged to:', updatedLatitude, updatedLongitude);
    });

    
}
    // Initialize the Places Autocomplete service
initMap();