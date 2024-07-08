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
    <div id='outside'>
        <div id="map" style="width: 100%;height:600px;"></div>
        <div style='display:flex;padding:1%;justify-content: center;'>
            <div id="time-period-selector">
                <b for="time-period">選擇時間區間：</b>
                <select id="time-period" class="custom-select">
                    <option>請選擇資料</option>
                    <option value="NIGHT_WORK">平日夜間停留人數</option>
                    <option value="DAY_WORK(7:00~13:00)">平日上午活動人數</option>
                    <option value="DAY_WORK(13:00~19:00)">平日下午活動人數</option>
                    <option value="DAY_WORK">平日日間活動人數</option>
                    <option value="NIGHT_WEEKEND">假日夜間停留人數</option>
                    <option value="DAY_WEEKEND(7:00~13:00)">假日上午活動人數</option>
                    <option value="DAY_WEEKEND(13:00~19:00)">假日下午活動人數</option>
                    <option value="DAY_WEEKEND">假日日間活動人數</option>
                    <option value="MORNING_WORK">平日早晨旅次</option>
                    <option value="MIDDAY_WORK">平日中午旅次</option>
                    <option value="AFTERNOON_WORK">平日午後旅次</option>
                    <option value="EVENING_WORK">平日晚上旅次</option>
                    <option value="MORNING_WEEKEND">假日早晨旅次</option>
                    <option value="MIDDAY_WEEKEND">假日中午旅次</option>
                    <option value="AFTERNOON_WEEKEND">假日午後旅次</option>
                    <option value="EVENING_WEEKEND">假日晚上旅次</option>
                </select>
            </div>
            <div id="town-selector" style='margin-left:1%;'>
                <b for="town">行政區：</b>
                <select id="town" class="custom-select">
                    <option value="">請選擇一個行政區</option>
                </select>
            </div>
        </div>
    </div>
    <script>
        var map = L.map('map').setView([23.6978, 120.9605], 7);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        var timePeriodToProperty = {
            'NIGHT_WORK': 'NIGHT_WORK',
            'DAY_WORK(7:00~13:00)': 'DAY_WORK(7:00~13:00)',
            'DAY_WORK(13:00~19:00)': 'DAY_WORK(13:00~19:00)',
            'DAY_WORK': 'DAY_WORK',
            'NIGHT_WEEKEND': 'NIGHT_WEEKEND',
            'DAY_WEEKEND(7:00~13:00)': 'DAY_WEEKEND(7:00~13:00)',
            'DAY_WEEKEND(13:00~19:00)': 'DAY_WEEKEND(13:00~19:00)',
            'DAY_WEEKEND': 'DAY_WEEKEND',
            'MORNING_WORK': 'MORNING_WORK',
            'MIDDAY_WORK': 'MIDDAY_WORK',
            'AFTERNOON_WORK': 'AFTERNOON_WORK',
            'EVENING_WORK': 'EVENING_WORK',
            'MORNING_WEEKEND': 'MORNING_WEEKEND',
            'MIDDAY_WEEKEND': 'MIDDAY_WEEKEND',
            'AFTERNOON_WEEKEND': 'AFTERNOON_WEEKEND',
            'EVENING_WEEKEND': 'EVENING_WEEKEND',
        };
        fetch('segis2.json')
            .then(response => response.json())
            .then(data => {
                // Define the color scale for layers
                var colorScale = ['#fee5d9', '#fcae91', '#fb6a4a', '#de2d26', '#a50f15'];

                // Create a function to determine the color based on values
                function getColor(value) {
                    if (value >= 100000) return colorScale[4];
                    if (value >= 70000) return colorScale[3];
                    if (value >= 50000) return colorScale[2];
                    if (value >= 30000) return colorScale[1];
                    return colorScale[0];
                }

                // Time period selector and GeoJSON layers
                var timePeriodSelect = document.getElementById('time-period');
                timePeriodSelect.addEventListener('change', function () {
                    var selectedTimePeriod = this.value;

                    // Clear existing layers from the map
                    map.eachLayer(function (layer) {
                        if (layer instanceof L.GeoJSON) {
                            map.removeLayer(layer);
                        }
                    });



                    data.features.forEach(feature => {
                        var valuePropertyName = timePeriodToProperty[selectedTimePeriod];
                        var value = feature.properties[valuePropertyName];

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
                            var selectedTimePeriod = timePeriodSelect.value;
                            var valuePropertyName = timePeriodToProperty[selectedTimePeriod];
                            var value = selectedFeature.properties[valuePropertyName];
                            marker.bindPopup("行政區: " + selectedFeature.properties.TOWN + "<br>" +
                                "人次" + ": " + value)
                                .openPopup();

                            map.setView([centroidCoordinates[0], centroidCoordinates[1]], 14); // Correct order [lat, lon]
                        }
                    }
                });



                // ...

            });
    </script>


</body>

</html>