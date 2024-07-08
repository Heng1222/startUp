<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <title>首頁</title>
    <!-- 響應式 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap5 css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" href="headerCSS.css" type="text/css">
    <link rel="stylesheet" href="public.css" type="text/css">  
    <link rel="stylesheet" href="index.css" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
        crossorigin="anonymous">
<body style="background-color:#FFFFFF;">
<?php
error_reporting(E_ALL); ini_set('display_errors', '1');
include('header.php');
$csv = fopen("index_data.csv", "r");
// $count = 1;
$courseArray = array(); 
$lectureArray = array(); 
$competitionArray = array(); 
$planArray = array(); 
// $data = fgetcsv($csv, 1000, ",");
// echo $data[0];
// echo iconv(mb_detect_encoding($data[0], mb_detect_order(), true), "UTF-8", $data[0]);
while (($data = fgetcsv($csv, 1000, ",")) !== FALSE) {
    if (count($data) >= 6) { // 確保陣列具有至少 6 個元素
        $i = 0;
        foreach ($data as $value){
            $value = iconv(mb_detect_encoding($value, mb_detect_order(), true), "UTF-8", $value);
            $data[$i] = $value;
            $i ++;
        }
        switch ($data[5]) {
            case '課程':
                array_push($courseArray, $data);
                break;
            case '講座':
                array_push($lectureArray, $data);
                break;
            case '競賽':
                array_push($competitionArray, $data);
                break;
            case '計畫':
                array_push($planArray, $data);
                break;
        }
    }
}
?>
<div class="container-fluid" style="background-color:#CDE6FF;padding-top:10%;padding-bottom:10%">
    <section class="block_system">
        <h2><span><i>騷年！你渴望創業嘛！？</i></span></h2>
        <p>讓我們成為你的<span>助力</span>，成就你的<span>夢想</span></p>
    </section>
</div>
<div class="container-fluid" style="padding-top:3%;padding-bottom:10%">
    <section class="block_system">      
        <h1 style="padding-bottom:3%">最新公告</h1>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="course-tab" data-bs-toggle="tab" data-bs-target="#course" type="button" role="tab" aria-controls="course" aria-selected="true">課程</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="lecture-tab" data-bs-toggle="tab" data-bs-target="#lecture" type="button" role="tab" aria-controls="lecture" aria-selected="false">講座</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="competition-tab" data-bs-toggle="tab" data-bs-target="#competition" type="button" role="tab" aria-controls="competition" aria-selected="false">競賽</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="plan-tab" data-bs-toggle="tab" data-bs-target="#plan" type="button" role="tab" aria-controls="plan" aria-selected="false">計畫</button>
            </li>
            <li class="nav-item ms-auto" role="presentation">
                <button type="button" class="btn btn-outline-primary">查看更多</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="course" role="tabpanel" aria-labelledby="course-tab" style="padding:5%">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php
                        foreach($courseArray as $data){
                            echo "<div class='col'>";
                            echo "<div class='card h-100'>";
                            echo "<a href=".$data[4]." target='_blank' class='stretched-link'></a>";
                            echo "<img src=".$data[3]." class='card-img-top' height='150px' style='object-fit: cover;object-position:50% 15%;' alt=".$data[4].">";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title' style='display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow:hidden;text-overflow: ellipsis;'>".$data[0]."</h5>";
                            echo "<p class='card-text' style='display: -webkit-box;-webkit-line-clamp: 5;-webkit-box-orient: vertical;overflow:hidden;text-overflow: ellipsis;'>".$data[1]."</p>";
                            echo "<div style='vertical-align:text-bottom;'>";
                            $tag = explode(" ",$data[2]);
                            foreach($tag as $value){
                                echo "<a href='...' style='text-decoration: none;'>".$value."</a> ";
                            }
                            echo "</div></div></div></div>";
                        }
                    ?>
                </div>
            </div>
            <div class="tab-pane fade" id="lecture" role="tabpanel" aria-labelledby="lecture-tab" style="padding:5%">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php
                        foreach($lectureArray as $data){
                            echo "<div class='col'>";
                            echo "<div class='card h-100'>";
                            echo "<a href=".$data[4]." target='_blank' class='stretched-link'></a>";
                            echo "<img src=".$data[3]." class='card-img-top' height='150px' style='object-fit: cover;object-position:0% 15%;' alt=".$data[4].">";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title' style='display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow:hidden;text-overflow: ellipsis;'>".$data[0]."</h5>";
                            echo "<p class='card-text' style='display: -webkit-box;-webkit-line-clamp: 5;-webkit-box-orient: vertical;overflow:hidden;text-overflow: ellipsis;'>".$data[1]."</p>";
                            echo "<div style='vertical-align:text-bottom;'>";
                            $tag = explode(" ",$data[2]);
                            foreach($tag as $value){
                                echo "<a href='...' style='text-decoration: none;'>".$value."</a> ";
                            }
                            echo "</div></div></div></div>";
                        }
                    ?>
                </div>
            </div>
            <div class="tab-pane fade" id="competition" role="tabpanel" aria-labelledby="competition-tab" style="padding:5%">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php
                        foreach($competitionArray as $data){
                            echo "<div class='col'>";
                            echo "<div class='card h-100'>";
                            echo "<a href=".$data[4]." target='_blank' class='stretched-link'></a>";
                            echo "<img src=".$data[3]." class='card-img-top' height='150px' style='object-fit: cover;object-position:0% 15%;' alt=".$data[4].">";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title' style='display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow:hidden;text-overflow: ellipsis;'>".$data[0]."</h5>";
                            echo "<p class='card-text' style='display: -webkit-box;-webkit-line-clamp: 5;-webkit-box-orient: vertical;overflow:hidden;text-overflow: ellipsis;'>".$data[1]."</p>";
                            echo "<div style='vertical-align:text-bottom;'>";
                            $tag = explode(" ",$data[2]);
                            foreach($tag as $value){
                                echo "<a href='...' style='text-decoration: none;'>".$value."</a> ";
                            }
                            echo "</div></div></div></div>";
                        }
                    ?>
                </div>
            </div>
            <div class="tab-pane fade" id="plan" role="tabpanel" aria-labelledby="plan-tab" style="padding:5%">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php
                        foreach($planArray as $data){
                            echo "<div class='col'>";
                            echo "<div class='card h-100'>";
                            echo "<a href=".$data[4]." target='_blank' class='stretched-link'></a>";
                            echo "<img src=".$data[3]." class='card-img-top' height='150px' style='object-fit: cover;object-position:0% 15%;' alt=".$data[4].">";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title' style='display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow:hidden;text-overflow: ellipsis;'>".$data[0]."</h5>";
                            echo "<p class='card-text' style='display: -webkit-box;-webkit-line-clamp: 5;-webkit-box-orient: vertical;overflow:hidden;text-overflow: ellipsis;'>".$data[1]."</p>";
                            echo "<div style='vertical-align:text-bottom;'>";
                            $tag = explode(" ",$data[2]);
                            foreach($tag as $value){
                                echo "<a href='...' style='text-decoration: none;'>".$value."</a> ";
                            }
                            echo "</div></div></div></div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- bootstrap5 jsp -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
</body>
