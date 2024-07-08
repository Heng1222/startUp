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

<body style='margin:0px;'>

    <div id="map" style="width: 100%; height: 600px;"></div>
    <div style='display:flex;padding:1%;justify-content: center;'>
        <div id="time-period-selector">
            <b for="time-period">行業：</b>
            <select id="time-period" class="custom-select">
                <option>請選擇行業類別</option>
                <option value="C_CNT">工商業總家數</option>
                <option value="C1_A_CNT">農、林、漁、牧業</option>
                <option value="C1_B_CNT">礦業及土石採取業</option>
                <option value="C1_C_CNT">製造業</option>
                <option value="C1_D_CNT">電力及燃氣供應業</option>
                <option value="C1_E_CNT">用水供應及污染整治業</option>
                <option value="C1_F_CNT">營造業</option>
                <option value="C1_G_CNT">批發及零售業</option>
                <option value="C1_H_CNT">運輸及倉儲業</option>
                <option value="C1_I_CNT">住宿及餐飲業</option>
                <option value="C1_J_CNT">資訊及通訊傳播業</option>
                <option value="C1_K_CNT">金融及保險業</option>
                <option value="C1_L_CNT">不動產業</option>
                <option value="C1_M_CNT">專業、科學及技術服務業</option>
                <option value="C1_N_CNT">支援服務業</option>
                <option value="C1_O_CNT">公共行政及國防；強制性社會安全</option>
                <option value="C1_P_CNT">教育服務業 </option>
                <option value="C1_Q_CNT">醫療保健及社會工作服務業</option>
                <option value="C1_R_CNT">藝術、娛樂及休閒服務業</option>
                <option value="C1_S_CNT">其他服務業</option>

            </select>
        </div>

        <div id="COUNTY-selector" style='margin-left:1%;'>
            <b for="COUNTY">縣市：</b>
            <select id="COUNTY" class="custom-select">
                <option value="">請選擇一個縣市</option>
            </select>
        </div>
    </div>

    <script>
        var map = L.map('map').setView([23.6978, 120.9605], 7);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        var timePeriodToProperty = {
            'C_CNT': 'C_CNT',
            'C1_A_CNT': 'C1_A_CNT',
            'C1_B_CNT': 'C1_B_CNT',
            'C1_C_CNT': 'C1_C_CNT',
            'C1_D_CNT': 'C1_D_CNT',
            'C1_E_CNT': 'C1_E_CNT',
            'C1_F_CNT': 'C1_F_CNT',
            'C1_G_CNT': 'C1_G_CNT',
            'C1_H_CNT': 'C1_H_CNT',
            'C1_I_CNT': 'C1_I_CNT',
            'C1_J_CNT': 'C1_J_CNT',
            'C1_K_CNT': 'C1_K_CNT',
            'C1_L_CNT': 'C1_L_CNT',
            'C1_M_CNT': 'C1_M_CNT',
            'C1_N_CNT': 'C1_N_CNT',
            'C1_O_CNT': 'C1_O_CNT',
            'C1_P_CNT': 'C1_P_CNT',
            'C1_Q_CNT': 'C1_Q_CNT',
            'C1_R_CNT': 'C1_R_CNT',
            'C1_S_CNT': 'C1_S_CNT'

        };
        fetch('business.json')
            .then(response => response.json())
            .then(data => {
                // Define the color scale for layers
                var colorScale = [
                    '#deebf7', '#c6dbef', '#9ecae1', '#6baed6',
                    '#4292c6', '#2171b5', '#08519c', '#08306b', '#000000'
                ];

                // Create a function to determine the color based on values
                function getColor(value) {
                    if (value >= 300000) return colorScale[9];
                    if (value >= 200000) return colorScale[8];
                    if (value >= 150000) return colorScale[7];
                    if (value >= 10000) return colorScale[6];
                    if (value >= 8000) return colorScale[5];
                    if (value >= 6000) return colorScale[4];
                    if (value >= 4000) return colorScale[3];
                    if (value >= 2000) return colorScale[2];
                    if (value >= 1000) return colorScale[1];
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
                        .bindPopup("County: " + feature.properties.COUNTY);
                });

                var COUNTYSelect = document.getElementById('COUNTY');
                var countyOptions = {};

                data.features.forEach(feature => {
                    var countyName = feature.properties.COUNTY;
                    countyOptions[countyName] = true;
                });

                for (var county in countyOptions) {
                    var option = document.createElement('option');
                    option.value = county;
                    option.textContent = county;
                    COUNTYSelect.appendChild(option);
                }

                COUNTYSelect.addEventListener('change', function () {
                    var selectedCOUNTY = this.value;
                    if (selectedCOUNTY) {
                        var selectedFeature = data.features.find(feature => feature.properties.COUNTY === selectedCOUNTY);
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
                            marker.bindPopup("縣市:" + selectedFeature.properties.COUNTY + "<br>" +
                                + value + "家")
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