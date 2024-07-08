<?php //body有初始化須用緩衝才能正常跑isLogin.php
ob_start();
include("isLogin.php");
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <title>地圖化應用</title>
    <!-- 響應式 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap5 css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" href="headerCSS.css" type="text/css">
    <link rel="stylesheet" href="public.css" type="text/css">
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <!-- country select -->
    <script src="https://demeter.5fpro.com/tw/zipcode-selector.js"></script>
    <!-- icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <script type="text/javascript"
        src="https://api.tgos.tw/TGOS_API/tgos?ver=2&AppID=Pg57X/voTFkqXMdShtYDFc0n4qkjZgQpxHeqyKES6URwyVC96t6lRA==&APIKey=cGEErDNy5yN/1fQ0vyTOZrghjE+jIU6udabHCD8SBPV5xa/qFmk8eZoqwfwW+hazt5QdFcwd+Tzh3DiuegQUGRj1zckRD5gyyN8GxPDdm5HfONshWwVY9DZ8vhpeCc/z6FjZEUuVO4H79IXsbdHIAXnhVIGt762CgGtZoQFlMHAvCZcCIlxYt+izDEFY0N1fRfg82T45gGXWTOf8dPOZZOn6sLNeJytOyMZw90b89KyS9yYLN6QyddqTyiRD/fwA1OymP2LzLSZWtUn/a9xAnsAyAnM0PKqwiXOQLFNj7ovFqSgerLxDkS3aBXQUcvIg+yRa88SMEmq15yl6pCI3OJQygWJtwhSAAGoZMCY/pBM="
        charset="utf-8"></script>
    <!--下載後請將yourID及yourkey取代為您申請所取得的APPID及APIKEY方能正確顯示服務-->
    <script type="text/javascript">
        var pOMap = null;
        var pMap = null;
        var locator = new TGOS.TGLocateService();  //宣告定位物件
        var markers = new Array();		//建立空陣列, 作為載入標記點物件的容器使用
        function InitWnd() {
            getHeight();
            pOMap = document.getElementById("TGMap");
            var mapOptions = {
                disableDefaultUI: true		//關閉所有地圖介面控制項
            };
            pMap = new TGOS.TGOnlineMap(pOMap, TGOS.TGCoordSys.EPSG3826, mapOptions);	//宣告TGOnlineMap地圖物件並設定坐標系統
            pMap.setZoom(3);
            pMap.setCenter(new TGOS.TGPoint(296136.2291398568, 2616799.2708601444));
            locate();
        }

        function locate() {
            var Loarr = document.querySelectorAll('#location');
            var LService = new TGOS.TGLocateService();			//宣告一個新的定位服務
            var addressArr = new Array();
            for (k = 0; k < Loarr.length; k++) {
                addressArr.push(Loarr[k].innerHTML);
            }
            for (var i = 0; i < addressArr.length; i++) {
                var request = {				//設定定位所需的參數, 使用address進行地址定位
                    address: addressArr[i],
                };
                console.log(addressArr[i]);

                LService.locateTWD97(request, function (result, status) {	//進行定位查詢, 並指定回傳資訊為TWD97坐標系統
                    if (status != 'OK') {	//確認該查詢地址是否可以查詢成功
                        //alert(status);		//若該地址無法進行查詢則顯示錯誤狀態碼
                        return;
                    }
                    else {
                        addrpoint = result[0].geometry.location;			//利用geometry.location取得地址點位(TGPoint)
                        Marker = new TGOS.TGMarker(pMap, addrpoint, result[0].formattedAddress);	//繪出地址定位點
                        //goLocate(addrpoint.x,addrpoint.y);
                        markers.push(Marker);
                        targetAddress = "goLocate(" + addrpoint.x + "," + addrpoint.y + ")";
                        section = ["零", "一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二", "十三"];
                        id = result[0].addressComponents.county + result[0].addressComponents.town + result[0].addressComponents.road + ((result[0].addressComponents.section == '') ? '' : section[result[0].addressComponents.section] + '段') + result[0].addressComponents.number;
                        targetdiv = document.getElementById(id);
                        console.log(id);
                        console.log(targetdiv);
                        targetdiv.setAttribute("onclick", targetAddress);
                    }
                });
            }
        }
        var redMarkers = new Array();//若有
        function cleanRedMarker() {
            if (redMarkers.length > 0) {		//假設地圖上已存在查詢後得到的標記點, 則先行移除
                for (var i = 0; i < redMarkers.length; i++) {
                    redMarkers[i].setMap(null);
                }
                redMarkers = [];
            }
        }
        function goLocate(x, y) {
            pMap.setZoom(10);							//將地圖縮放至最後一個層級
            cleanRedMarker();
            markerImg = new TGOS.TGImage("http://219.84.228.130:18880/map-marker-solid.png", new TGOS.TGSize(38, 33), new TGOS.TGPoint(0, 0), new TGOS.TGPoint(17, 31));
            center = new TGOS.TGPoint(x, y);
            redMarker = new TGOS.TGMarker(pMap, center, "", markerImg);
            redMarker.setZIndex(500);
            redMarkers.push(redMarker);
            console.log(center);
            pMap.setCenter(center);	//取得傳入的坐標, 並將地圖中心移至該坐標位置

        }

        var InfoWindowOptions = {
            maxWidth: 200, //訊息視窗的最大寬度
            // opacity:0.8,
            pixelOffset: new TGOS.TGSize(5, -20), //InfoWindow起始位置的偏移量, 使用TGSize設定, 向右X為正, 向上Y為負  
            zIndex: 1000,
        };

        var fill = null;
        function locateDistrict(districtInput) {  //加入行政區定位
            var locator = new TGOS.TGLocateService();
            if (fill) { fill.setMap(null) };
            locator.locateTWD97({
                district: districtInput
            }, function (e, status) {
                if (status != TGOS.TGLocatorStatus.OK) {
                    alert('查無行政區');
                    return;
                }
                pMap.fitBounds(e[0].geometry.viewport);
                pMap.setZoom(pMap.getZoom() - 1);
                //調整畫面符合行政區邊界
                var pgn = e[0].geometry.geometry;
                //讀取行政區空間資訊
                fill = new TGOS.TGFill(pMap, pgn, {
                    //將行政區空間資訊以面圖徵呈現
                    fillColor: '#00AAAA',
                    fillOpacity: 0.2,
                    strokeColor: '#009090',
                    strokeWeight: 5,
                    strokeOpacity: 1,
                    zIndex: 1,
                });
                console.log(fill.getZIndex());
            });
        }

        function clearcontent() {
            var showcontent = document.getElementById("showContent");
            showcontent.innerHTML = "";
        }
        function removeShowClass() {
            obj = document.getElementById("showContent").querySelectorAll(".show");
            for (i = 0; i < obj.length; i++) {
                obj[i].classList.remove("show");
            }
        }

        function getSelectResult() {
            var city = document.getElementById("city6").value;
            var dis = document.getElementById("dist6").value;
            var type = document.getElementById("industryType").value;
            var txtBox = document.getElementById("showContent");
            locateDistrict(city + dis);//行政區繪製
            clearcontent();
            cleanRedMarker();
            showNew(city, dis, type, txtBox);
        }
        function showNew(city, dis, type, txtBox) {
            var Query = new TGOS.TGAttriQuery();
            var strs = "<div class='row me-1'><div class='col-12'>";
            if (markers.length > 0) {		//假設地圖上已存在查詢後得到的標記點, 則先行移除
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(null);
                }
                markers = [];
            }
            var queryRequst = {		//設定屬性查詢參數
                county: city,
                town: dis,
                keyword: ''
            };
            var INDUSTRYdis = { "INDUSTRY": TGOS.TGMapId.INDUSTRY, "INDUSTRY_A": TGOS.TGMapId.INDUSTRY_A, "INDUSTRY_B": TGOS.TGMapId.INDUSTRY_B, "INDUSTRY_C": TGOS.TGMapId.INDUSTRY_C, "INDUSTRY_D": TGOS.TGMapId.INDUSTRY_D, "INDUSTRY_E": TGOS.TGMapId.INDUSTRY_E, "INDUSTRY_F": TGOS.TGMapId.INDUSTRY_F, "INDUSTRY_G": TGOS.TGMapId.INDUSTRY_G, "INDUSTRY_H": TGOS.TGMapId.INDUSTRY_H, "INDUSTRY_I": TGOS.TGMapId.INDUSTRY_I, "INDUSTRY_J": TGOS.TGMapId.INDUSTRY_J, "INDUSTRY_K": TGOS.TGMapId.INDUSTRY_K, "INDUSTRY_L": TGOS.TGMapId.INDUSTRY_L, "INDUSTRY_M": TGOS.TGMapId.INDUSTRY_M, "INDUSTRY_N": TGOS.TGMapId.INDUSTRY_N, "INDUSTRY_O": TGOS.TGMapId.INDUSTRY_O, "INDUSTRY_P": TGOS.TGMapId.INDUSTRY_P, "INDUSTRY_Q": TGOS.TGMapId.INDUSTRY_Q, "INDUSTRY_R": TGOS.TGMapId.INDUSTRY_R, "INDUSTRY_S": TGOS.TGMapId.INDUSTRY_S };
            Query.identify(TGOS.TGMapServiceId.INDUSTRY, INDUSTRYdis[type], queryRequst, TGOS.TGCoordSys.EPSG3826, function (result, status) {
                //使用方法identify進行屬性查詢, 輸入參數包含欲查詢的服務、欲查詢的圖層、查詢參數、坐標系統及查詢後的函式, result及status分別代表查詢結果及查詢狀態
                if (status == TGOS.TGQueryStatus.ZERO_RESULTS) {	//判斷查詢結果是否為查無結果
                    txtBox.innerHTML = "<div class='w-100 h-100 d-flex align-items-center justify-content-center'><p class='pt-3 ps-1 text-muted fw-bolder text-center' style='font-size: 20px;''>此區域目前沒有此類別店家！</p></div>";
                    return;
                } else {		//若查詢產生結果, 則執行以下函式
                    var attris = result.fieldAttr;	//取得圖徵屬性
                    console.log(result.position[1].x, result.position[1].y);
                    for (i = 0; i < attris.length; i++) {
                        //使用迴圈將符合查詢條件的結果全部取出
                        var str = "<div class='card shadow mt-2 ps-0 pe-0' onclick='goLocate(" + result.position[i].x + "," + result.position[i].y + ")'>";
                        str += "<div style='border:#0051ff2e solid;overflow:hidden;' class='btn pt-3 pb-3' onclick='setBorderClass(this)'>";
                        str += "<label style='font-size:18px;overflow:hidden;' class='fw-bold'>" + attris[i][1] + "</label><br/>";
                        str += "<label style='font-size:9px;overflow:hidden;' class='text-muted'>" + attris[i][4] + "</label>";
                        str += "</div></div>";

                        strs += str;	//將每次迴圈的字串結果加在一起

                        var tip = attris[i][1];	//取出查詢結果的各個圖徵名稱, 準備作為標記點的顯示文字
                        var marker = new TGOS.TGMarker(pMap, new TGOS.TGPoint(result.position[i].x, result.position[i].y), tip);	//將查詢結果作成標記點顯示在圖面上
                        markers.push(marker);	//將所有標記點加入陣列markers
                        // 建立滑鼠監聽和彈跳視窗
                        marker.setZIndex(300);
                        console.log(marker.getZIndex());
                        messageBox = new TGOS.TGInfoWindow("<label class='fw-bold text-center' style='font-size:15px;'>" + tip + "</label>", new TGOS.TGPoint(result.position[i].x, result.position[i].y), InfoWindowOptions);
                        console.log(messageBox.getZIndex());
                        TGOS.TGEvent.addListener(marker, "mouseover", function (marker, messageBox) {
                            return function () {
                                messageBox.open(pMap, marker);
                            }
                        }(marker, messageBox));//滑鼠監聽事件--開啟訊息視窗
                        TGOS.TGEvent.addListener(marker, "mouseout", function (messageBox) {
                            return function () {
                                messageBox.close();
                            }
                        }(messageBox));
                    }
                }
                strs = strs + "</div></div>";
                txtBox.innerHTML = strs;	//將查詢後的文字結果寫入到空白DIV內
            });
        }

        function getHeight() {
            console.log(document.documentElement.clientHeight);
            height = document.documentElement.clientHeight;
            height = (height > 1000) ? 1000 : height;
            outside = document.getElementById('outside');
            console.log(outside);
            outside.style = "height:"+height+"px;";
        }


        function setBorderClass(obj) {
            // remove others border first
            others = document.querySelectorAll(".border-secondary");
            for (i = 0; i < others.length; i++) {
                others[i].classList.remove("border-secondary");
                others[i].classList.remove("border");
                others[i].classList.remove("border-4");
            }
            // console.log(others);
            // set border
            obj.setAttribute("class", "btn pt-3 pb-3 border-4 border border-secondary");
        }
    </script>

<body onload='InitWnd()'>
    <?php
    include('header.php');
    ?>
    <div class='outside' id='outside' style='height:100%;'>
        <div class="row me-0 h-100">
            <div class="col-2 bg-white h-100" id='panel'>
                <a class="btn btn-primary w-100" data-bs-toggle="collapse" href="#lesson" role="button"
                    aria-expanded="true" aria-controls="lesson">
                    活動查詢
                </a>
                <div class="show" id="lesson">
                    <div class="card card-body p-3">
                        <form action="" method='post'>
                            <div class="row mb-3 g-2">
                                <div class='col-3 pe-0'>
                                    <span class="input-group-text border-0" id="search-addon">
                                        <i class="bi bi-search"></i>
                                    </span>
                                </div>
                                <div class='col-9 ps-0'>
                                    <input type="search" class="form-control rounded" placeholder="輸入關鍵字"
                                        name='keyword' />
                                </div>
                            </div>
                            <div class="row mb-3 g-3 align-items-center">
                                <div class="col-4">
                                    <h6 class='mb-0'>類型:</h6>
                                </div>
                                <div class='col-8'>
                                    <select class="form-select" id="type" name='type'>
                                        <option value="不限" selected>不限</option>
                                        <option value="課程">課程</option>
                                        <option value="活動">活動</option>
                                        <option value="競賽">競賽</option>
                                        <option value="線上">線上</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <h6 class='mb-0'>地點:</h6>
                                </div>
                                <div class="col-8">
                                    <select class="form-select" id="county-select" name='location'>
                                        <option value="不限" selected>全台</option>
                                        <option value="基隆市">基隆市</option>
                                        <option value="臺北市">臺北市</option>
                                        <option value="新北市">新北市</option>
                                        <option value="新竹市">新竹市</option>
                                        <option value="新竹縣">新竹縣</option>
                                        <option value="苗栗縣">苗栗縣</option>
                                        <option value="桃園市">桃園市</option>
                                        <option value="臺中市">臺中市</option>
                                        <option value="彰化縣">彰化縣</option>
                                        <option value="南投縣">南投縣</option>
                                        <option value="雲林縣">雲林縣</option>
                                        <option value="嘉義市">嘉義市</option>
                                        <option value="嘉義縣">嘉義縣</option>
                                        <option value="臺南市">臺南市</option>
                                        <option value="高雄市">高雄市</option>
                                        <option value="屏東縣">屏東縣</option>
                                        <option value="臺東縣">臺東縣</option>
                                        <option value="花蓮縣">花蓮縣</option>
                                        <option value="宜蘭縣">宜蘭縣</option>
                                        <option value="金門縣">金門縣</option>
                                        <option value="澎湖縣">澎湖縣</option>
                                        <option value="連江縣">連江縣</option>
                                    </select>
                                </div>
                            </div>
                            <div class='row g-2 mb-3'>
                                <div class='col'>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name='free' type="checkbox" id="inlineCheckbox1"
                                            value="free">
                                        <label class="form-check-label" style='font-size:14px'
                                            for="inlineCheckbox1">僅搜尋免費內容</label>
                                    </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col'>
                                    <input type="submit" class="btn btn-primary mt-2 w-100" value='查詢'
                                        onclick=clearcontent()>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <a class="btn btn-primary w-100 mt-2" data-bs-toggle="collapse" href="#search" role="button"
                    aria-expanded="false" aria-controls="search lesson">
                    競爭者查詢
                </a>
                <div class="collapse" id="search">
                    <div class="card card-body">
                        <select class="form-select" id="industryType" name='industryType'>
                            <option value="INDUSTRY">工商企業(全部)</option>
                            <option value="INDUSTRY_A">農、林、漁、牧業</option>
                            <option value="INDUSTRY_B">礦業及土石採取業</option>
                            <option value="INDUSTRY_C">製造業</option>
                            <option value="INDUSTRY_D">電力及燃氣供應業</option>
                            <option value="INDUSTRY_E">用水供應及污染整治業</option>
                            <option value="INDUSTRY_F">營造業</option>
                            <option value="INDUSTRY_G">批發及零售業</option>
                            <option value="INDUSTRY_H">運輸及倉儲業</option>
                            <option value="INDUSTRY_I">住宿及餐飲業</option>
                            <option value="INDUSTRY_J">資訊及通訊傳播業</option>
                            <option value="INDUSTRY_K">金融及保險業</option>
                            <option value="INDUSTRY_L">不動產業</option>
                            <option value="INDUSTRY_M">專業、科學及技術服務業</option>
                            <option value="INDUSTRY_N">支援服務業</option>
                            <option value="INDUSTRY_O">公共行政及國防；強制性社會安全</option>
                            <option value="INDUSTRY_P">教育服務業</option>
                            <option value="INDUSTRY_Q">醫療保健及社會工作服務業</option>
                            <option value="INDUSTRY_R">藝術、娛樂及休閒服務業</option>
                            <option value="INDUSTRY_S">其他服務業</option>
                        </select>
                        <input data-selected-city="新北市" class="js-demeter-tw-zipcode-selector collapse"
                            data-city="#city6" data-dist="#dist6" placeholder="請輸入郵遞區號" />
                        <select class='form-select' id="city6" placeholder="請選擇縣市"></select>
                        <select class='form-select' id="dist6" placeholder="請選擇鄉鎮區"></select>
                        <button type="submit" onclick='getSelectResult()' class="btn btn-primary mt-2">查詢</button>
                        <label id='result'></label>
                    </div>
                </div>
            </div>
            <div class="col-3 mh-100" id='showContent' style='overflow-y:scroll;background-color:#fffbfbb8'>
                <?php
                if (isset($_POST['type'])) {
                    // 按下查詢
                    // 外框容器
                    echo "<div class='row me-1'>";
                    echo "<div class='col-12'>";
                    // 讀檔生成card
                    $txt_file = fopen('activities.csv', 'r');
                    $num = 1;
                    fgets($txt_file); #標題欄讀掉
                    // 讀取選擇欄
                    $selectType = $_POST['type'];
                    $selectCounty = $_POST['location'];
                    $selectFree = isset($_POST['free']);
                    $selectKeyword = $_POST['keyword'];
                    while ($line = fgets($txt_file)) {
                        // 存取活動資料
                        $line = explode(",", $line);
                        $title = trim($line[0]);
                        $link = trim($line[1]);
                        $startTime = trim($line[2]);
                        $endTime = trim($line[3]);
                        $host = trim($line[4]);
                        $phone = trim($line[5]);
                        $Email = trim($line[6]);
                        $location = trim($line[7]);
                        $fee = trim($line[8]);
                        $target = trim($line[9]);
                        $county = trim($line[10]);
                        $actType = trim($line[11]);
                        // 篩選
                        if (($selectType == "不限" || $selectType == $actType) && ($selectCounty == "不限" || $selectCounty == $county) && (str_contains($title, $selectKeyword))) {
                            if ($selectFree && $fee != "免費")
                                continue; #免費篩選
                            // 輸出card
                            echo "<div id='" . $location . "' class='card shadow mt-1 ps-0 pe-0' style=''>";
                            echo "<a style='border:#0051ff2e solid;overflow:hidden;' data-bs-toggle='collapse' href='#collapse" . $num . "' aria-expanded='false' class='btn pt-3 pb-3' onclick='removeShowClass()')>" . $title . "                
                                </a>";
                            echo "<div id='collapse" . $num . "' class='collapse' style=' background-color:rgb(181 215 243 / 44%)'>
                                    <div class='card-body'>";
                            echo "<div class='row ps-1' style='font-size: 14px;'>
                                            <div class='w-25 ps-0 pe-0 mb-1' style='text-align-last:justify'>類型:</div>
                                            <div class='w-75 ps-0 mb-1'>" . $actType . "</div>
                                            <div class='w-25 ps-0 pe-0 mb-1' style='text-align-last:justify'>開始時間:</div>
                                            <div class='w-75 ps-0'>" . $startTime . "</div>
                                            <div class='w-25 ps-0 pe-0 mb-1' style='text-align-last:justify'>結束時間:</div>
                                            <div class='w-75 ps-0'>" . $endTime . "</div>
                                            <div class='w-25 ps-0 pe-0 mb-1' style='text-align-last:justify'>地點:</div>
                                            <div class='w-75 ps-0' id='location'>" . $location . "</div>
                                            <div class='w-25 ps-0 pe-0 mb-1' style='text-align-last:justify'>費用:</div>
                                            <div class='w-75 ps-0'>" . $fee . "</div>
                                            <div class='w-25 ps-0 pe-0 mb-1' style='text-align-last:justify'>主辦單位:</div>
                                            <div class='w-75 ps-0'>" . $host . "</div>
                                            <div class='w-25 ps-0 pe-0 mb-1' style='text-align-last:justify'>連絡電話:</div>
                                            <div class='w-75 ps-0'>" . $phone . "</div>
                                            <div class='w-25 ps-0 pe-0 mb-1' style='text-align-last:justify'>聯絡信箱:</div>
                                            <div class='w-75 ps-0'>" . $Email . "</div>
                                            <div class='w-25 ps-0 pe-0 mb-1' style='text-align-last:justify'>相關資訊:</div>
                                            <div class='w-75 ps-0'>" . "<a href='$link'>點我</a>" . "</div>
                                        </div>"; #內文
                            // echo "<label style='font-size: 14px;'>";
                            // echo"類型：".$actType."<br/>開始時間：".$startTime."<br/>結束時間：".$endTime."<br/>地點：".$location."<br/>費用：".$fee."<br/>主辦單位：".$host."<br/>聯絡電話：".$phone."<br/>聯絡Email：".$Email."<br/>相關資訊：<a href='$link'>點我</a>";#內文                  
                            // echo"</label>
                            echo "</div>
                                </div>";
                            echo "</div>";
                        }
                        $num++;
                    }
                    fclose($txt_file);
                    // 外框容器結束
                    //地址標記                  
                    // echo "<script>locate();</script>";
                    echo "</div>";
                    echo "</div>";
                } else {
                    // echo "<div class='h-100 text-center d-flex align-items-center justify-content-center'>";
                    // echo "<p class='text-muted fw-bolder' style='font-size: 20px;'><i class='bi bi-search'></i> STEP 1：<br/>從左側選擇欄選取呈現資料";
                    // echo "</p></div>";
                    echo "<div class='container ps-1 mt-3'>";
                    echo "<div class='row justify-content-center align-items-center g-2'>";
                    echo "<p class='text-muted fw-bolder' style='font-size: 18px;'><i class='bi bi-search'></i> STEP 1：<br/></p>";
                    echo "<p class='ps-3 text-muted fw-bolder' style='font-size: 15px;'>從左側選擇欄選擇活動查詢或是競爭者查詢。</p>";
                    echo "<p class='ps-3 text-muted fw-bolder' style='font-size: 15px;'>活動查詢：<br/>可依照地點、類型、關鍵字、以及收費模式進行篩選，預設為全部不限</p>";
                    echo "<p class='ps-3 text-muted fw-bolder' style='font-size: 15px;'>競爭者查詢：<br/>選擇您創業的產業類別並填入您想創業的縣市、區，系統將呈現該區的潛在競爭對手(和您同類別之店家)</p>";
                    echo "<p class='text-muted fw-bolder' style='font-size: 18px;'><i class='bi bi-search'></i> STEP 2：<br/></p>";
                    echo "<p class='ps-3 text-muted fw-bolder' style='font-size: 15px;'>依照自身需求選擇合適的篩選項目並送出。資料將呈現於此處，點擊查詢結果可在右方地圖中觀看其地理位置。</p>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>

            </div>
            <div class="col-7 bg-secondary ps-0 pe-0" id='map'>
                <div class='w-100 h-100' id="TGMap" style="border: 1px solid #C0C0C0;"></div>
            </div>
        </div>
    </div>
    <!-- bootstrap5 jsp -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>
</body>

<!-- TODO -->
<!-- CSV整理(尤其地址)-->
