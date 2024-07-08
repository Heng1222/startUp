<?php //body有初始化須用緩衝才能正常跑isLogin.php
ob_start();
include("isLogin.php");
ob_end_flush();
?>
<!DOCTYPE html>
<html>
<head>
    <title>MOI Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" href="headerCSS.css" type="text/css">
    <link rel="stylesheet" href="public.css" type="text/css">
    <style>
        /* Add your custom styles for moi.php content here */
        body {
            margin: 0;
            padding: 0;
        }
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        #moi-content {
            flex: 1;
            display: flex;
            overflow: hidden; /* 隐藏溢出内容 */
        }
        #sidebar {
            background-color: #f0f0f0;
            width: 220px;
            padding: 15px;
            box-sizing: border-box;
            overflow: auto;
            height: 100%;
        }
        #content {
            flex: 1;
            /* padding: 20px; */
            box-sizing: border-box;
        }

        iframe {
            border: none;
            width: 100%;
            height: 100%;
            display: none;
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-bottom: 10px;
        }

        /* Hover effect for buttons */
        button:hover {
            background-color: #2980b9;
        }

        /* Style for h1 */
        h1 {
            color: #333;
            font-size: 20px;
            margin-bottom: 25px;
            margin-top: 10px;
            text-align: center;
            font-weight:bold;
        }
    </style>
</head>
<body>
    <?php
    include('header.php');
    ?>

    <!-- Content specific to moi.php -->
    <div id="moi-content">
        <div id="sidebar">
            <h1>MOI資料查詢系統</h1>
            <button style='width:100%' onclick="showPopulationMap()">電信信令人口統計資料</button>
            <button style='width:100%' onclick="showTouristMap()">主要觀光遊憩區遊客人數統計</button>
            <button style='width:100%' onclick="showIndicatorsMap()">行政區人口指標</button>
            <button style='width:100%' onclick="showStatisticsMap()">行政區人口統計</button>
            <button style='width:100%' onclick="showPeopleMap()">行政區人口消長統計</button>
            <button style='width:100%' onclick="showLabourMap()">行政區勞動力統計</button>
            <button style='width:100%' onclick="showBusinessMap()">行政區工商家數</button>
        </div>
        <div id="content">
            <iframe id="populationMap" src="population.php"></iframe>
            <iframe id="touristMap" src="tourist.php"></iframe>
            <iframe id="indicatorsMap" src="indicators.php"></iframe>
            <iframe id="statisticsMap" src="statistics.php"></iframe>
            <iframe id="peopleMap" src="people.php"></iframe>
            <iframe id="labourMap" src="labour.php"></iframe>
            <iframe id="businessMap" src="business.php"></iframe>
        </div>
    </div>
    <script>
        // Functions to show different maps
        function showPopulationMap() {
           document.getElementById('populationMap').style.display = 'block';
    document.getElementById('touristMap').style.display = 'none';
    document.getElementById('indicatorsMap').style.display = 'none';
    document.getElementById('statisticsMap').style.display = 'none';
    document.getElementById('peopleMap').style.display = 'none';
    document.getElementById('labourMap').style.display = 'none';
    document.getElementById('businessMap').style.display = 'none';
        }

       function showTouristMap() {
    document.getElementById('populationMap').style.display = 'none';
    document.getElementById('touristMap').style.display = 'block';
    document.getElementById('indicatorsMap').style.display = 'none';
    document.getElementById('statisticsMap').style.display = 'none';
    document.getElementById('peopleMap').style.display = 'none';
    document.getElementById('labourMap').style.display = 'none';
    document.getElementById('businessMap').style.display = 'none';
}

// Function to show the indicators map
function showIndicatorsMap() {
    document.getElementById('populationMap').style.display = 'none';
    document.getElementById('touristMap').style.display = 'none';
    document.getElementById('indicatorsMap').style.display = 'block';
    document.getElementById('statisticsMap').style.display = 'none';
    document.getElementById('peopleMap').style.display = 'none';
    document.getElementById('labourMap').style.display = 'none';
    document.getElementById('businessMap').style.display = 'none';
}

function showStatisticsMap() {
    document.getElementById('populationMap').style.display = 'none';
    document.getElementById('touristMap').style.display = 'none';
    document.getElementById('indicatorsMap').style.display = 'none';
    document.getElementById('statisticsMap').style.display = 'block';
    document.getElementById('peopleMap').style.display = 'none';
    document.getElementById('labourMap').style.display = 'none';
    document.getElementById('businessMap').style.display = 'none';
}

function showPeopleMap() {
    document.getElementById('populationMap').style.display = 'none';
    document.getElementById('touristMap').style.display = 'none';
    document.getElementById('indicatorsMap').style.display = 'none';
    document.getElementById('statisticsMap').style.display = 'none';
    document.getElementById('peopleMap').style.display = 'block';
    document.getElementById('labourMap').style.display = 'none';
    document.getElementById('businessMap').style.display = 'none';
}

function showLabourMap() {
    document.getElementById('populationMap').style.display = 'none';
    document.getElementById('touristMap').style.display = 'none';
    document.getElementById('indicatorsMap').style.display = 'none';
    document.getElementById('statisticsMap').style.display = 'none';
    document.getElementById('peopleMap').style.display = 'none';
    document.getElementById('labourMap').style.display = 'block';
    document.getElementById('businessMap').style.display = 'none';
}

function showBusinessMap() {
    document.getElementById('populationMap').style.display = 'none';
    document.getElementById('touristMap').style.display = 'none';
    document.getElementById('indicatorsMap').style.display = 'none';
    document.getElementById('statisticsMap').style.display = 'none';
    document.getElementById('peopleMap').style.display = 'none';
    document.getElementById('labourMap').style.display = 'none';
    document.getElementById('businessMap').style.display = 'block';
}
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>
</body>
</html>
