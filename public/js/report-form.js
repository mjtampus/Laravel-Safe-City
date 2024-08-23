        // Function to fill latitude and longitude from URL parameters
        function fillLocationFromURL() {
            const urlParams = new URLSearchParams(window.location.search);
            const latitude = urlParams.get('lat');
            const longitude = urlParams.get('lng');

            if (latitude && longitude) {
                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;
            }
        }

        // Function to submit the accident report
        
            // Here you can send the data to a server or perform further actions
    
        
        // Fill location when the page loads
        fillLocationFromURL();