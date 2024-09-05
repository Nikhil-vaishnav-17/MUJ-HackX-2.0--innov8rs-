var map = L.map('map').setView([28.7041, 77.1025], 8); 
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var geocoder = L.Control.Geocoder.nominatim();
        L.Control.geocoder({
            position: 'topleft',
            geocoder: geocoder
        }).addTo(map);

        var marker = L.marker([28.7041, 77.1025], { draggable: true }).addTo(map);

        function updateLatLng(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

        marker.on('dragend', function(event) {
            var position = marker.getLatLng();
            updateLatLng(position.lat, position.lng);
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                map.setView([lat, lng], 13); 
                marker.setLatLng([lat, lng]); 
                updateLatLng(lat, lng); 
            });
        }
        updateLatLng(28.7041, 77.1025); 