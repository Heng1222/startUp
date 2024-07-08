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
        <div id="-indicators-selector">
            <b for="indicators">選擇指標：</b>
            <select id="indicators" class="custom-select">
                <option value="A0A14_A15A65_RAT">扶幼比</option>
                <option value="A65_A0A14_RAT">老化指數</option>
                <option value="A65UP_A15A64_RAT">扶老比</option>
                <option value="DEPENDENCY_RAT">扶養比</option>
                <option value="M_F_RAT">性比例</option>
                <option value="P_DEN">人口密度</option>
                <option value="P_H_CNT">戶量</option>
            </select>
        </div>
        <div id="town-selector" style='margin-left:1%;'>
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

        var indicatorsToProperty = {
            'A0A14_A15A65_RAT': 'A0A14_A15A65_RAT',
            'A65_A0A14_RAT': 'A65_A0A14_RAT',
            'A65UP_A15A64_RAT': 'A65UP_A15A64_RAT',
            'DEPENDENCY_RAT': 'DEPENDENCY_RAT',
            'M_F_RAT': 'M_F_RAT',
            'P_DEN': 'P_DEN',
            'P_H_CNT': 'P_H_CNT',
        };

        fetch('indicators.json')
            .then(response => response.json())
            .then(data => {
                // Define the color scale for layers
                var colorScale = [
                    '#deebf7', '#c6dbef', '#9ecae1', '#6baed6',
                    '#4292c6', '#2171b5', '#08519c', '#08306b', '#000000'
                ];

                // Create a function to determine the color based on values

                function getFemaleColor(value) {
                    if (value >= 120) return colorScale[5];
                    if (value >= 110) return colorScale[4];
                    if (value >= 100) return colorScale[3];
                    if (value >= 90) return colorScale[2];
                    if (value >= 80) return colorScale[1];
                    return colorScale[0];
                }

                function getPColor(value) {
                    if (value >= 20000) return colorScale[9];
                    if (value >= 15000) return colorScale[8];
                    if (value >= 12000) return colorScale[7];
                    if (value >= 10000) return colorScale[6];
                    if (value >= 8000) return colorScale[5];
                    if (value >= 5000) return colorScale[4];
                    if (value >= 3000) return colorScale[3];
                    if (value >= 1000) return colorScale[2];
                    if (value >= 100) return colorScale[1];
                    return colorScale[0];
                }

                function getPHColor(value) {
                    if (value >= 3.2) return colorScale[6];
                    if (value >= 3.0) return colorScale[5];
                    if (value >= 2.8) return colorScale[4];
                    if (value >= 2.6) return colorScale[3];
                    if (value >= 2.4) return colorScale[2];
                    if (value >= 2.2) return colorScale[1];
                    return colorScale[0];
                }

                function getA15A65Color(value) {
                    if (value >= 25) return colorScale[5];
                    if (value >= 20) return colorScale[4];
                    if (value >= 15) return colorScale[3];
                    if (value >= 10) return colorScale[2];
                    if (value >= 5) return colorScale[1];
                    return colorScale[0];
                }

                function getA65_A0A14Color(value) {
                    if (value >= 700) return colorScale[7];
                    if (value >= 600) return colorScale[6];
                    if (value >= 500) return colorScale[5];
                    if (value >= 400) return colorScale[4];
                    if (value >= 300) return colorScale[3];
                    if (value >= 200) return colorScale[2];
                    if (value >= 100) return colorScale[1];
                    return colorScale[0];
                }

                function getA65UPColor(value) {
                    if (value >= 40) return colorScale[4];
                    if (value >= 30) return colorScale[3];
                    if (value >= 20) return colorScale[2];
                    if (value >= 10) return colorScale[1];
                    return colorScale[0];
                }

                function getDEPENDENCYColor(value) {
                    if (value >= 50) return colorScale[5];
                    if (value >= 40) return colorScale[4];
                    if (value >= 30) return colorScale[3];
                    if (value >= 20) return colorScale[2];
                    if (value >= 10) return colorScale[1];
                    return colorScale[0];
                }

                // indicators selector and GeoJSON layers
                var indicatorsSelect = document.getElementById('indicators');
                indicatorsSelect.addEventListener('change', function () {
                    var selectedIndicator = this.value;

                    // Clear existing layers from the map
                    map.eachLayer(function (layer) {
                        if (layer instanceof L.GeoJSON) {
                            map.removeLayer(layer);
                        }
                    });

                    data.features.forEach(feature => {
                        var valuePropertyName = indicatorsToProperty[selectedIndicator];
                        var value = feature.properties[valuePropertyName];

                        if (valuePropertyName === 'M_F_RAT') {
                            var fillColor = getFemaleColor(value);
                        } else if (valuePropertyName === 'P_DEN') {
                            var fillColor = getPColor(value);
                        } else if (valuePropertyName === 'P_H_CNT') {
                            var fillColor = getPHColor(value);
                        } else if (valuePropertyName === 'A0A14_A15A65_RAT') {
                            var fillColor = getA15A65Color(value);
                        } else if (valuePropertyName === 'A65_A0A14_RAT') {
                            var fillColor = getA65_A0A14Color(value);
                        } else if (valuePropertyName === 'A65UP_A15A64_RAT') {
                            var fillColor = getA65UPColor(value);
                        } else if (valuePropertyName === 'DEPENDENCY_RAT') {
                            var fillColor = getDEPENDENCYColor(value);
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

                        // Add a marker with popup showing the value
                        var centroid = turf.centroid(feature.geometry);
                        var centroidCoordinates = centroid.geometry.coordinates;

                        var marker = L.marker(centroidCoordinates.reverse(), {
                            opacity: 0, // Set opacity to 0 to make the marker invisible
                            interactive: false // Disable interaction with the marker
                        }).addTo(map)
                            .bindPopup("Town: " + feature.properties.TOWN + "<br>" +
                                selectedIndicator + ": " + value);
                    });
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
                            /*
                            <option value="A0A14_A15A65_RAT">扶幼比</option>
                        <option value="A65_A0A14_RAT">老化指數</option>
                        <option value="A65UP_A15A64_RAT">扶老比</option>
                        <option value="DEPENDENCY_RAT">扶養比</option>
                        <option value="M_F_RAT">性比例</option>
                        <option value="P_DEN">人口密度</option>
                        <option value="P_H_CNT">戶量</option>
                        */
                            // Bind a popup to the marker with the town name and selected indicator's value
                            var selectedIndicator = indicatorsSelect.value;
                            var valuePropertyName = indicatorsToProperty[selectedIndicator];
                            var value = selectedFeature.properties[valuePropertyName];
                            if (selectedIndicator === 'A0A14_A15A65_RAT') {
                                marker.bindPopup("行政區: " + selectedFeature.properties.TOWN + "<br>" +
                                    "扶幼比" + ": " + value)
                                    .openPopup();
                            }
                            if (selectedIndicator === 'A65_A0A14_RAT') {
                                marker.bindPopup("行政區: " + selectedFeature.properties.TOWN + "<br>" +
                                    "老化指數" + ": " + value)
                                    .openPopup();
                            }
                            if (selectedIndicator === 'A65UP_A15A64_RAT') {
                                marker.bindPopup("行政區: " + selectedFeature.properties.TOWN + "<br>" +
                                    "扶老比" + ": " + value)
                                    .openPopup();
                            }
                            if (selectedIndicator === 'DEPENDENCY_RAT') {
                                marker.bindPopup("行政區: " + selectedFeature.properties.TOWN + "<br>" +
                                    "扶養比" + ": " + value)
                                    .openPopup();
                            }
                            if (selectedIndicator === 'M_F_RAT') {
                                marker.bindPopup("行政區: " + selectedFeature.properties.TOWN + "<br>" +
                                    "性比例" + ": " + value)
                                    .openPopup();
                            }

                            if (selectedIndicator === 'P_DEN') {
                                marker.bindPopup("行政區: " + selectedFeature.properties.TOWN + "<br>" +
                                    "人口密度" + ": " + value)
                                    .openPopup();
                            }

                            if (selectedIndicator === 'P_H_CNT') {
                                marker.bindPopup("行政區: " + selectedFeature.properties.TOWN + "<br>" +
                                    "戶量" + ": " + value)
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