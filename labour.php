<!DOCTYPE html>
<html>

<head>
    <title>Tourist Map</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/@turf/turf@6.3.0"></script>
    <style>
        .custom-select {
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            padding: 5px;
            /* Add more styling properties as needed */
        }
    </style>
</head>

<body style='margin:0px'>

    <div id="map" style="width: 100%; height: 600px;"></div>
    <div style='display:flex;padding:1%;justify-content: center;'>
        <div id="county-selector">
            <b for="county">縣市：</b>
            <select id="county" class="custom-select">
                <option value="">請選擇一個縣市</option>
                <!-- County options will be populated dynamically -->
            </select>
        </div>

    </div>
    <script>
        var map = L.map('map').setView([23.6978, 120.9605], 7);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var markersLayer = L.layerGroup().addTo(map);

        fetch('labour.json')
            .then(response => response.json())
            .then(data => {
                // Populate the county options dynamically
                var countySelect = document.getElementById('county');
                var counties = {}; // Store unique counties

                data.features.forEach(feature => {
                    var countyName = feature.properties.COUNTY;
                    counties[countyName] = true; // Store as a key to ensure uniqueness
                });

                for (var county in counties) {
                    var option = document.createElement('option');
                    option.value = county;
                    option.textContent = county;
                    countySelect.appendChild(option);
                }

                // Define the color scale for markers
                var colorScale = [
                    '#deebf7', '#c6dbef', '#9ecae1', '#6baed6',
                    '#4292c6', '#2171b5', '#08519c', '#08306b', '#000000'
                ];

                // Create a function to determine the color based on values
                function getColor(value) {
                    if (value >= 2000) return colorScale[6];
                    if (value >= 1500) return colorScale[5];
                    if (value >= 1000) return colorScale[4];
                    if (value >= 500) return colorScale[3];
                    if (value >= 200) return colorScale[2];
                    if (value >= 100) return colorScale[1];
                    return colorScale[0];
                }

                data.features.forEach(feature => {
                    var value = feature.properties.COLUMN1; // Use the 'COLUMN1' property

                    var fillColor = getColor(value);

                    L.geoJSON(feature, {
                        style: {
                            fillColor: fillColor,
                            weight: 1,
                            opacity: 1,
                            color: 'white',
                            fillOpacity: 0.7
                        }
                    }).addTo(map);
                });

                // Add an event listener to the county select element
                countySelect.addEventListener('change', function () {
                    var selectedCounty = this.value;
                    if (selectedCounty) {
                        markersLayer.clearLayers(); // Clear existing markers

                        var selectedFeatures = data.features.filter(feature => feature.properties.COUNTY === selectedCounty);
                        selectedFeatures.forEach(feature => {
                            var centroid = turf.centroid(feature.geometry);
                            var centroidCoordinates = centroid.geometry.coordinates;

                            var marker = L.marker(centroidCoordinates.reverse(), {
                                opacity: 1,
                                interactive: true,
                                fillColor: getColor(feature.properties.COLUMN1), // Get color based on COLUMN1 value
                                color: 'white',
                                fillOpacity: 0.7
                            }).addTo(markersLayer)
                                .bindPopup("縣市: " + feature.properties.COUNTY + "<br>人數: " + feature.properties.COLUMN1 * 1000)
                                .openPopup();
                        });

                        if (selectedFeatures.length > 0) {
                            var centroid = turf.centroid(selectedFeatures[0].geometry);
                            var centroidCoordinates = centroid.geometry.coordinates;
                            map.setView([centroidCoordinates[1], centroidCoordinates[0]], 10); // Reverse order for Leaflet [lat, lon]
                        }
                    }
                });
            });
    </script>

</body>

</html>