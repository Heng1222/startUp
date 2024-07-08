<!DOCTYPE html>
<html>

<head>
    <title>Leaflet Map with Layers</title>
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
        <div id="-statistics-selector">
            <b for="statistics">統計數據：</b>
            <select id="statistics" class="custom-select">
                <option>請選擇統計數據</option>
                <option value="F_CNT">女性人口數</option>
                <option value="H_CNT">戶數</option>
                <option value="M_CNT">男性人口數</option>
                <option value="P_CNT">人口數</option>
            </select>
        </div>

        <div id="town-selector" style="margin-left:1%;">
            <b for="town">行政區：</b>
            <select id="town" class="custom-select">
                <option value="">請選擇一個行政區</option>
            </select>
        </div>
    </div>


    <script>
        var map = L.map('map').setView([23.6978, 120.9605], 7);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var statisticsToProperty = {
            'F_CNT': 'F_CNT',
            'H_CNT': 'H_CNT',
            'M_CNT': 'M_CNT',
            'P_CNT': 'P_CNT'
        };

        fetch('statistics.json')
            .then(response => response.json())
            .then(data => {
                // Define the color scale for layers
                var colorScale = [
                    '#deebf7', '#c6dbef', '#9ecae1', '#6baed6',
                    '#4292c6', '#2171b5', '#08519c', '#08306b', '#000000'
                ];

                // Create a function to determine the color based on values

                function getF_CNTColor(value) {
                    if (value >= 300000) return colorScale[9];
                    if (value >= 200000) return colorScale[8];
                    if (value >= 100000) return colorScale[7];
                    if (value >= 80000) return colorScale[6];
                    if (value >= 50000) return colorScale[5];
                    if (value >= 30000) return colorScale[4];
                    if (value >= 10000) return colorScale[3];
                    if (value >= 5000) return colorScale[2];
                    if (value >= 1000) return colorScale[1];
                    return colorScale[0];
                }

                function getH_CNTColor(value) {
                    if (value >= 300000) return colorScale[9];
                    if (value >= 200000) return colorScale[8];
                    if (value >= 100000) return colorScale[7];
                    if (value >= 80000) return colorScale[6];
                    if (value >= 50000) return colorScale[5];
                    if (value >= 30000) return colorScale[4];
                    if (value >= 10000) return colorScale[3];
                    if (value >= 5000) return colorScale[2];
                    if (value >= 1000) return colorScale[1];
                    return colorScale[0];
                }

                function getM_CNTColor(value) {
                    if (value >= 300000) return colorScale[9];
                    if (value >= 200000) return colorScale[8];
                    if (value >= 100000) return colorScale[7];
                    if (value >= 80000) return colorScale[6];
                    if (value >= 50000) return colorScale[5];
                    if (value >= 30000) return colorScale[4];
                    if (value >= 10000) return colorScale[3];
                    if (value >= 5000) return colorScale[2];
                    if (value >= 1000) return colorScale[1];
                    return colorScale[0];
                }

                function getP_CNTColor(value) {
                    if (value >= 500000) return colorScale[9];
                    if (value >= 300000) return colorScale[8];
                    if (value >= 200000) return colorScale[7];
                    if (value >= 100000) return colorScale[6];
                    if (value >= 80000) return colorScale[5];
                    if (value >= 50000) return colorScale[4];
                    if (value >= 30000) return colorScale[3];
                    if (value >= 10000) return colorScale[2];
                    if (value >= 5000) return colorScale[1];
                    return colorScale[0];
                }

                // statistics selector and GeoJSON layers
                var statisticsSelect = document.getElementById('statistics');
                statisticsSelect.addEventListener('change', function () {
                    var selectedstatistics = this.value;

                    // Clear existing layers from the map
                    map.eachLayer(function (layer) {
                        if (layer instanceof L.GeoJSON) {
                            map.removeLayer(layer);
                        }
                    });



                    data.features.forEach(feature => {
                        var valuePropertyName = statisticsToProperty[selectedstatistics];
                        var value = feature.properties[valuePropertyName];

                        if (valuePropertyName === 'F_CNT') {
                            var fillColor = getF_CNTColor(value);
                        } else if (valuePropertyName === 'H_CNT') {
                            var fillColor = getH_CNTColor(value);
                        } else if (valuePropertyName === 'M_CNT') {
                            var fillColor = getM_CNTColor(value);
                        } else if (valuePropertyName === 'P_CNT') {
                            var fillColor = getP_CNTColor(value);
                        }


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
                });

                // Loop through features and add invisible markers for each town
                data.features.forEach(feature => {
                    var centroid = turf.centroid(feature.geometry);
                    var centroidCoordinates = centroid.geometry.coordinates;

                    var marker = L.marker(centroidCoordinates.reverse(), {
                        opacity: 0, // Set opacity to 0 to make the marker invisible
                        interactive: false // Disable interaction with the marker
                    }).addTo(map)
                        .bindPopup("Town: " + feature.properties.TOWN);
                });

                // Populate the town options dynamically
                var townSelect = document.getElementById('town');
                var countyGroups = {}; // Store towns by county

                data.features.forEach(feature => {
                    var townName = feature.properties.TOWN;
                    var countyName = feature.properties.COUNTY;

                    if (!countyGroups[countyName]) {
                        countyGroups[countyName] = [];
                    }

                    countyGroups[countyName].push(townName);
                });

                for (var county in countyGroups) {
                    var optgroup = document.createElement('optgroup');
                    optgroup.label = county;

                    countyGroups[county].forEach(town => {
                        var option = document.createElement('option');
                        option.value = town;
                        option.textContent = town;
                        optgroup.appendChild(option);
                    });

                    townSelect.appendChild(optgroup);
                }

                // Add an event listener to the town select element
                // ...

                // Add an event listener to the town select element
                townSelect.addEventListener('change', function () {
                    var selectedTown = this.value;
                    if (selectedTown) {
                        var selectedFeature = data.features.find(feature => feature.properties.TOWN === selectedTown);
                        if (selectedFeature) {
                            var centroid = turf.centroid(selectedFeature.geometry);
                            var centroidCoordinates = centroid.geometry.coordinates;

                            // Clear existing markers from the map
                            map.eachLayer(function (layer) {
                                if (layer instanceof L.Marker) {
                                    map.removeLayer(layer);
                                }
                            });

                            // Create a marker for the selected town's centroid
                            var marker = L.marker(centroidCoordinates.reverse(), {
                                opacity: 1,
                                interactive: true
                            }).addTo(map);

                            // Bind a popup to the marker with the town name and selected indicator's value
                            var selectedstatistics = statisticsSelect.value;
                            var valuePropertyName = statisticsToProperty[selectedstatistics];
                            var value = selectedFeature.properties[valuePropertyName];
                            if (valuePropertyName === "H_CNT") {
                                marker.bindPopup("行政區: " + selectedFeature.properties.TOWN + "<br>" +
                                    value + "戶")
                                    .openPopup();
                            }
                            else {
                                marker.bindPopup("行政區: " + selectedFeature.properties.TOWN + "<br>" +
                                    value + "人")
                                    .openPopup();
                            }

                            map.setView([centroidCoordinates[0], centroidCoordinates[1]], 14); // Correct order [lat, lon]
                        }
                    }
                });

                // ...

            });
    </script>


</body>

</html>