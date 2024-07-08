<html lang="zh-TW">

    <head>
        <title>交流區</title>
        <!-- 響應式 -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- bootstrap5 css -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <link rel="stylesheet" href="communicate.css?v=<?=time()?>">
        <link rel="stylesheet" href="headerCSS.css" type="text/css">
        <link rel="stylesheet" href="public.css" type="text/css">  

    </head>

    <body>
    <?php 
        include('header.php');
        include('linkDB.php');
    ?>

    <div class="container" style="justify-content: center;">   
        <form action="communicate.php" method="GET">
            <div class="input-group">
                <span class="input-group-text" ><i class="bi bi-search"></i></span>
                <input type="text" name="search_keyword" placeholder="請輸入關鍵字" >
                <select name="search_place">
                    <option value="all">不限</option>
                    <optgroup label="北部">
                        <option value="Keelung">基隆市</option>
                        <option value="NewTaipei">新北市</option>
                        <option value="Taipei">臺北市</option>
                        <option value="Taoyuan">桃園市</option>
                        <option value="HsinchuCounty">新竹縣</option>
                        <option value="HsinchuCity">新竹市</option>
                        <option value="MiaoliCity">苗栗市</option>
                        <option value="MiaoliCounty">苗栗縣</option>
                    </optgroup>
                    <optgroup label="中部">
                        <option value="TaichungCity">臺中市</option>
                        <option value="ChanghuaCounty">彰化縣</option>
                        <option value="ChanghuaCity">彰化市</option>
                        <option value="NantouCity">南投市</option>
                        <option value="NantouCounty">南投縣</option>
                        <option value="YunlinCounty">雲林縣</option>
                    </optgroup>
                    <optgroup label="南部">
                        <option value="ChiayiCity">嘉義市</option>
                        <option value="ChiayiCounty">嘉義縣</option>
                        <option value="TainanCity">臺南市</option>
                        <option value="KaohsiungCity">高雄市</option>
                        <option value="PingtungCounty">屏東縣</option>
                        <option value="PingtungCity">屏東市</option>
                    </optgroup>
                    <optgroup label="東部">
                        <option value="YilanCounty">宜蘭縣</option>
                        <option value="YilanCity">宜蘭市</option>
                        <option value="HualienCounty">花蓮縣</option>
                        <option value="HualienCity">花蓮市</option>
                        <option value="TaitungCity">臺東市</option>
                        <option value="TaitungCounty">臺東縣</option>
                    </optgroup>
                    <optgroup label="離島">
                        <option value="PenghuCounty">澎湖縣</option>
                        <option value="KinmenCounty">金門縣</option>
                        <option value="LienchiangCounty">連江縣</option>
                    </optgroup>
                </select>
                <select name="type_ID">
                    <option value="all">不限</option>
                    <option value="1">找投資</option>
                    <option value="2">找人才</option>
                    <option value="3">經驗分享</option>
                    <option value="4">人力資源</option>
                    <option value="5">資金資源</option>
                </select>

                <input type="submit" id="submit" value="搜尋">
            </div>
        </form>
    </div>
                
        <div class="wrap">
            <div class = "left">
                <div class="container-fluid">      
                    <?php
                    //有搜尋關鍵字或選擇地點或選擇type
                        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search_keyword"]) || isset($_GET["search_place"]) || isset($_GET["com_type"])) {
                            $search_keyword = mysqli_real_escape_string($link, $_GET['search_keyword']);
                            $search_place = mysqli_real_escape_string($link, $_GET['search_place']);
                            $search_com_type = mysqli_real_escape_string($link, $_GET['type_ID']);

                            $query = "SELECT c.*, 
                                        ct.type_name,
                                        u.*,
                                        GROUP_CONCAT(l.lable_name) AS lable_names,
                                        pl.likeCount,
                                        pc.commentCount
                                        FROM communicate c
                                        LEFT JOIN uuser u ON c.user_ID = u.user_ID
                                        LEFT JOIN com_type ct ON c.type_ID = ct.type_ID
                                        LEFT JOIN com_lable cl ON c.communicate_ID = cl.communicate_ID
                                        LEFT JOIN lable l ON l.lable_ID = cl.lable_ID
                                        LEFT JOIN (
                                        SELECT communicate_ID, COUNT(user_ID) AS likeCount
                                        FROM post_like
                                        GROUP BY communicate_ID
                                        ) pl ON c.communicate_ID = pl.communicate_ID
                                        LEFT JOIN (
                                        SELECT communicate_ID, COUNT(user_ID) AS commentCount
                                        FROM post_comment
                                        GROUP BY communicate_ID
                                        ) pc ON c.communicate_ID = pc.communicate_ID
                                        WHERE (c.com_title LIKE '%$search_keyword%' OR c.com_post LIKE '%$search_keyword%' OR c.com_target LIKE '%$search_keyword%')
                                      ";

                            if ($search_place !== 'all') {
                                $query .= " AND com_place = '$search_place'";
                            }
                            if ($search_com_type !== 'all') {
                                $query .= " AND type_ID = '$search_com_type'";
                            }
                            $query .= " GROUP BY c.communicate_ID
                                        ORDER BY c.com_time DESC";
                            $result = mysqli_query($link, $query);
                            echo "<h1>搜尋結果</h1>";
                            // 搜尋結果
                            while ($row = mysqli_fetch_assoc($result)) {
                                $user_name = $row['user_name'];
                                $user_photo = $row['user_photo'];
                                $communicate_ID = $row['communicate_ID'];
                                $viewCount = $row['com_view'];
                                $com_title = $row['com_title'];
                                $com_post = $row['com_post'];
                                $com_target = $row['com_target'];
                                $com_place = $row['com_place'];
                                $com_time = $row['com_time'];
                                $lable_names = $row['lable_names'];
                                $com_type = $row['type_ID'];
                                $type_name = $row['type_name'];

                                if(isset($row['likeCount'])){
                                    $post_like = $row['likeCount'];
                                }else{
                                    $post_like = 0;
                                }

                                if(isset($row['commentCount'])){
                                    $post_comment = $row['commentCount'];
                                }else{
                                    $post_comment = 0;
                                }
                                
                                echo "<div class ='post-container' style='width:95% ; margin-left: 25px;'><a href = 'viewPost.php?id=".$row['communicate_ID']."' style='text-decoration: none; color: black;'>";
                                    
                                    if($com_type == 1){
                                        echo "<img src= '1.png' class=img_type> </img>";
                                    }else if($com_type == 2){
                                        echo "<img src= '2.png' class=img_type></img>";
                                    }else if($com_type == 3){ 
                                        echo "<img src= '3.png' class=img_type></img>";
                                    }else if($com_type == 4){
                                        echo "<img src= '4.png' class=img_type></img>";
                                    }else if($com_type == 5){
                                        echo "<img src= '5.png' class=img_type></img>";
                                    }                                            
                                    echo "<img src='".$user_photo."' class=img></IMG>"; echo" "; echo "$user_name";
                                    echo "<h3 style='margin-left: 50px'>$com_title</h3>";
                                    echo "<p style='margin-left: 50px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; max-width: 70%; height:50px;'>";
                                        if (mb_strlen($com_post) > 200) {
                                            echo mb_substr($com_post, 0, 200) . "...";
                                        } else {
                                            echo $com_post;
                                        }
                                    echo "</p>";

                                    if (!empty($lable_names)) {
                                        $lable_names_array = explode(',', $lable_names);
                                        $unique_lable_names = array_unique($lable_names_array);
                                        echo "<div style='display: flex; flex-wrap: wrap;'>";
                                        foreach ($unique_lable_names as $lable) {
                                            echo "<p style='background-color: #c7e9ff; width: fit-content; border-radius: 5px; margin-right: 5px'>#$lable</p>";
                                            echo " ";
                                        }
                                        echo "</div>";
                                    }else{
                                        echo "<p></p>";
                                    }

                                    if($type_name!="經驗分享"){
                                        echo "<div class='area'><p>$com_target</p></div>";
                                    }
                                    if ($com_target === '找人才') {
                                        echo "<p>地點: $com_place</p>";
                                    }

                                    $hasLiked = false;
                                    if (isset($_SESSION['user_ID'])) {
                                        $user_ID = $_SESSION['user_ID'];
                                        $checkLikeQuery = "SELECT * FROM post_like WHERE communicate_ID = $communicate_ID AND user_ID = $user_ID";
                                        $checkLikeResult = mysqli_query($link, $checkLikeQuery);
                                        if (mysqli_num_rows($checkLikeResult) > 0) {
                                            $hasLiked = true;
                                        }
                                    }
                                    if ($hasLiked) {
                                        echo "<span class = nice><i class='bi bi-hand-thumbs-up-fill'></i> $post_like</span>";
                                    } else {
                                        echo "<span class = nice><i class='bi bi-hand-thumbs-up'></i> $post_like</span>";
                                    }
                                    echo "<span class = nice><i class='bi bi-chat-right-text'></i> $post_comment</span>";
                                    echo "<span class = nice><i class='bi bi-eye'></i> $viewCount</span>";
                                echo "</div></a>";
                            }
                            
                        }
                        else{
                            echo "<section class='block_system'>";
                            echo "<ul class='nav nav-tabs' id='myTab' role='tablist'>";
                                echo "<li class='nav-item' role='presentation'>";
                                    echo "<button class='nav-link active' id='recommend-tab' data-bs-toggle='tab' data-bs-target='#recommend' type='button' role='tab' aria-controls='recommend' aria-selected='true'>推薦</button>";
                                echo "</li>";
                                echo "<li class='nav-item' role='presentation'>";
                                    echo "<button class='nav-link' id='newest-tab' data-bs-toggle='tab' data-bs-target='#newest' type='button' role='tab' aria-controls='newest' aria-selected='false'>最新</button>";
                                echo "</li>";
                                echo "<li class='nav-item' role='presentation'>";
                                    echo "<button class='nav-link' id='solved-tab' data-bs-toggle='tab' data-bs-target='#solved' type='button' role='tab' aria-controls='solved' aria-selected='false'>已解決</button>";
                                echo "</li>";
                            echo "</ul>";

                                echo "<div class='tab-content' id='myTabContent'>";
                                    echo "<div class='tab-pane fade show active' id='recommend' role='tabpanel' aria-labelledby='recommend-tab' >";
                                        
                                        $recommend = "SELECT c.*, 
                                                        ct.type_name,
                                                        u.*,
                                                        GROUP_CONCAT(l.lable_name) AS lable_names,
                                                        pl.likeCount,
                                                        pc.commentCount
                                                        FROM communicate c
                                                        LEFT JOIN uuser u ON c.user_ID = u.user_ID
                                                        LEFT JOIN com_type ct ON c.type_ID = ct.type_ID
                                                        LEFT JOIN com_lable cl ON c.communicate_ID = cl.communicate_ID
                                                        LEFT JOIN lable l ON l.lable_ID = cl.lable_ID
                                                        LEFT JOIN (
                                                        SELECT communicate_ID, COUNT(user_ID) AS likeCount
                                                        FROM post_like
                                                        GROUP BY communicate_ID
                                                        ) pl ON c.communicate_ID = pl.communicate_ID
                                                        LEFT JOIN (
                                                        SELECT communicate_ID, COUNT(user_ID) AS commentCount
                                                        FROM post_comment
                                                        GROUP BY communicate_ID
                                                        ) pc ON c.communicate_ID = pc.communicate_ID
                                                        GROUP BY c.communicate_ID, c.com_time, c.com_status, c.com_title, c.com_post, c.com_target, c.com_view, c.com_place, c.user_ID, c.type_ID, ct.type_name, u.user_name, u.user_photo
                                                        ORDER BY c.com_view DESC";

                                        $com_recommend = mysqli_query($link, $recommend);
                                        while ($row = mysqli_fetch_assoc($com_recommend)) {
                                            $user_name = $row['user_name'];
                                            $user_photo = $row['user_photo'];
                                            $communicate_ID = $row['communicate_ID'];
                                            $viewCount = $row['com_view'];
                                            $com_title = $row['com_title'];
                                            $com_post = $row['com_post'];
                                            $com_target = $row['com_target'];
                                            $com_place = $row['com_place'];
                                            $com_time = $row['com_time'];
                                            $lable_names = $row['lable_names'];
                                            $com_type = $row['type_ID'];
                                            $type_name = $row['type_name'];

                                            if(isset($row['likeCount'])){
                                                $post_like = $row['likeCount'];
                                            }else{
                                                $post_like = 0;
                                            }
            
                                            if(isset($row['commentCount'])){
                                                $post_comment = $row['commentCount'];
                                            }else{
                                                $post_comment = 0;
                                            }

                                            echo "<div class ='post-container'><a href = 'viewPost.php?id=".$row['communicate_ID']."' style='text-decoration: none; color: black;'>";
                                                
                                                if($com_type == 1){
                                                    echo "<img src= '1.png' class=img_type> </img>";
                                                }else if($com_type == 2){
                                                    echo "<img src= '2.png' class=img_type></img>";
                                                }else if($com_type == 3){ 
                                                    echo "<img src= '3.png' class=img_type></img>";
                                                }else if($com_type == 4){
                                                    echo "<img src= '4.png' class=img_type></img>";
                                                }else if($com_type == 5){
                                                    echo "<img src= '5.png' class=img_type></img>";
                                                }                                            
                                                echo "<img src='".$user_photo."' class=img></IMG>"; echo" "; echo "$user_name";
                                                echo "<h3 style='margin-left: 50px'>$com_title</h3>";
                                                echo "<p style='margin-left: 50px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; max-width: 70%; height:50px;'>";
                                                    if (mb_strlen($com_post) > 200) {
                                                        echo mb_substr($com_post, 0, 200) . "...";
                                                    } else {
                                                        echo $com_post;
                                                    }
                                                echo "</p>";

                                                if (!empty($lable_names)) {
                                                    $lable_names_array = explode(',', $lable_names);
                                                    $unique_lable_names = array_unique($lable_names_array);
                                                    echo "<div style='display: flex; flex-wrap: wrap;'>";
                                                    foreach ($unique_lable_names as $lable) {
                                                        echo "<p style='background-color: #c7e9ff; width: fit-content; border-radius: 5px; margin-right: 5px'>#$lable</p>";
                                                        echo " ";
                                                    }
                                                    echo "</div>";
                                                }else{
                                                    echo "<p></p>";
                                                }

                                                if($type_name!="經驗分享"){
                                                    echo "<div class='area'><p>$com_target</p></div>";
                                                }
                                                if ($com_target === '找人才') {
                                                    echo "<p>地點: $com_place</p>";
                                                }

                                                $hasLiked = false;
                                                if (isset($_SESSION['user_ID'])) {
                                                    $user_ID = $_SESSION['user_ID'];
                                                    $checkLikeQuery = "SELECT * FROM post_like WHERE communicate_ID = $communicate_ID AND user_ID = $user_ID";
                                                    $checkLikeResult = mysqli_query($link, $checkLikeQuery);
                                                    if (mysqli_num_rows($checkLikeResult) > 0) {
                                                        $hasLiked = true;
                                                    }
                                                }
                                                if ($hasLiked) {
                                                    echo "<span class = nice><i class='bi bi-hand-thumbs-up-fill'></i> $post_like</span>";
                                                } else {
                                                    echo "<span class = nice><i class='bi bi-hand-thumbs-up'></i> $post_like</span>";
                                                }
                                                echo "<span class = nice><i class='bi bi-chat-right-text'></i> $post_comment</span>";
                                                echo "<span class = nice><i class='bi bi-eye'></i> $viewCount</span>";
                                            echo "</div></a>";
                                        }
                                        
                                    echo "</div>";

                                    echo "<div class='tab-pane fade' id='newest' role='tabpanel' aria-labelledby='newest-tab'>";
                                        
                                            $newest = "SELECT c.*, 
                                                        ct.type_name,
                                                        u.*,
                                                        GROUP_CONCAT(l.lable_name) AS lable_names,
                                                        pl.likeCount,
                                                        pc.commentCount
                                                        FROM communicate c
                                                        LEFT JOIN uuser u ON c.user_ID = u.user_ID
                                                        LEFT JOIN com_type ct ON c.type_ID = ct.type_ID
                                                        LEFT JOIN com_lable cl ON c.communicate_ID = cl.communicate_ID
                                                        LEFT JOIN lable l ON l.lable_ID = cl.lable_ID
                                                        LEFT JOIN (
                                                        SELECT communicate_ID, COUNT(user_ID) AS likeCount
                                                        FROM post_like
                                                        GROUP BY communicate_ID
                                                        ) pl ON c.communicate_ID = pl.communicate_ID
                                                        LEFT JOIN (
                                                        SELECT communicate_ID, COUNT(user_ID) AS commentCount
                                                        FROM post_comment
                                                        GROUP BY communicate_ID
                                                        ) pc ON c.communicate_ID = pc.communicate_ID
                                                        GROUP BY c.communicate_ID, c.com_time, c.com_status, c.com_title, c.com_post, c.com_target, c.com_view, c.com_place, c.user_ID, c.type_ID, ct.type_name, u.user_name, u.user_photo
                                                       ORDER BY c.com_time DESC"; // 按照貼文時間降序排列

                                            $com_newest = mysqli_query($link, $newest);
                                            while ($row = mysqli_fetch_assoc($com_newest)) {
                                                $user_name = $row['user_name'];
                                                $user_photo = $row['user_photo'];
                                                $communicate_ID = $row['communicate_ID'];
                                                $viewCount = $row['com_view'];
                                                $com_title = $row['com_title'];
                                                $com_post = $row['com_post'];
                                                $com_target = $row['com_target'];
                                                $com_place = $row['com_place'];
                                                $com_time = $row['com_time'];
                                                $lable_names = $row['lable_names'];
                                                $com_type = $row['type_ID'];
                                                $type_name = $row['type_name'];
                                                
                                                if(isset($row['likeCount'])){
                                                    $post_like = $row['likeCount'];
                                                }else{
                                                    $post_like = 0;
                                                }
                
                                                if(isset($row['commentCount'])){
                                                    $post_comment = $row['commentCount'];
                                                }else{
                                                    $post_comment = 0;
                                                }
                                                
                                                echo "<div class ='post-container'><a href = 'viewPost.php?id=".$row['communicate_ID']."' style='text-decoration: none; color: black;'>";
                                                    
                                                    if($com_type == 1){
                                                        echo "<img src= '1.png' class=img_type> </img>";
                                                    }else if($com_type == 2){
                                                        echo "<img src= '2.png' class=img_type></img>";
                                                    }else if($com_type == 3){ 
                                                        echo "<img src= '3.png' class=img_type></img>";
                                                    }else if($com_type == 4){
                                                        echo "<img src= '4.png' class=img_type></img>";
                                                    }else if($com_type == 5){
                                                        echo "<img src= '5.png' class=img_type></img>";
                                                    }                                            
                                                    echo "<img src='".$user_photo."' class=img></IMG>"; echo" "; echo "$user_name";
                                                    echo "<h3 style='margin-left: 50px'>$com_title</h3>";
                                                    echo "<p style='margin-left: 50px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; max-width: 70%; height:50px;'>";
                                                        if (mb_strlen($com_post) > 200) {
                                                            echo mb_substr($com_post, 0, 200) . "...";
                                                        } else {
                                                            echo $com_post;
                                                        }
                                                    echo "</p>";
    

                                                    if (!empty($lable_names)) {
                                                        $lable_names_array = explode(',', $lable_names);
                                                        $unique_lable_names = array_unique($lable_names_array);
                                                        echo "<div style='display: flex; flex-wrap: wrap;'>";
                                                        foreach ($unique_lable_names as $lable) {
                                                            echo "<p style='background-color: #c7e9ff; width: fit-content; border-radius: 5px; margin-right: 5px'>#$lable</p>";
                                                            echo " ";
                                                        }
                                                        echo "</div>";
                                                    }else{
                                                        echo "<p></p>";
                                                    }
    

                                                    if($type_name!="經驗分享"){
                                                        echo "<div class='area'><p>$com_target</p></div>";
                                                    }
                                                    if ($com_target === '找人才') {
                                                        echo "<p>地點: $com_place</p>";
                                                    }
    
                                                    $hasLiked = false;
                                                    if (isset($_SESSION['user_ID'])) {
                                                        $user_ID = $_SESSION['user_ID'];
                                                        $checkLikeQuery = "SELECT * FROM post_like WHERE communicate_ID = $communicate_ID AND user_ID = $user_ID";
                                                        $checkLikeResult = mysqli_query($link, $checkLikeQuery);
                                                        if (mysqli_num_rows($checkLikeResult) > 0) {
                                                            $hasLiked = true;
                                                        }
                                                    }
                                                    if ($hasLiked) {
                                                        echo "<span class = nice><i class='bi bi-hand-thumbs-up-fill'></i> $post_like</span>";
                                                    } else {
                                                        echo "<span class = nice><i class='bi bi-hand-thumbs-up'></i> $post_like</span>";
                                                    }
                                                    echo "<span class = nice><i class='bi bi-chat-right-text'></i> $post_comment</span>";
                                                    echo "<span class = nice><i class='bi bi-eye'></i> $viewCount</span>";
                                                echo "</div></a>";
                                            }
                                        
                                    echo "</div>";

                                    echo "<div class='tab-pane fade' id='solved' role='tabpanel' aria-labelledby='solved-tab'>";
                                        
                                            $solved = "SELECT c.*, 
                                                        ct.type_name,
                                                        u.*,
                                                        GROUP_CONCAT(l.lable_name) AS lable_names,
                                                        pl.likeCount,
                                                        pc.commentCount
                                                        FROM communicate c
                                                        LEFT JOIN uuser u ON c.user_ID = u.user_ID
                                                        LEFT JOIN com_type ct ON c.type_ID = ct.type_ID
                                                        LEFT JOIN com_lable cl ON c.communicate_ID = cl.communicate_ID
                                                        LEFT JOIN lable l ON l.lable_ID = cl.lable_ID
                                                        LEFT JOIN (
                                                        SELECT communicate_ID, COUNT(user_ID) AS likeCount
                                                        FROM post_like
                                                        GROUP BY communicate_ID
                                                        ) pl ON c.communicate_ID = pl.communicate_ID
                                                        LEFT JOIN (
                                                        SELECT communicate_ID, COUNT(user_ID) AS commentCount
                                                        FROM post_comment
                                                        GROUP BY communicate_ID
                                                        ) pc ON c.communicate_ID = pc.communicate_ID
                                                        WHERE c.com_status = 1
                                                        GROUP BY c.communicate_ID, c.com_time, c.com_status, c.com_title, c.com_post, c.com_target, c.com_view, c.com_place, c.user_ID, c.type_ID, ct.type_name, u.user_name, u.user_photo
                                                        ORDER BY c.com_time DESC"; // 按照貼文時間降序排列已完成的貼文
                                                       
                                            $com_solved = mysqli_query($link, $solved);
                                            while ($row = mysqli_fetch_assoc($com_solved)) {
                                                $user_name = $row['user_name'];
                                                $user_photo = $row['user_photo'];
                                                $communicate_ID = $row['communicate_ID'];
                                                $viewCount = $row['com_view'];
                                                $com_title = $row['com_title'];
                                                $com_post = $row['com_post'];
                                                $com_target = $row['com_target'];
                                                $com_place = $row['com_place'];
                                                $com_time = $row['com_time'];
                                                $lable_names = $row['lable_names'];
                                                $com_type = $row['type_ID'];
                                                $type_name = $row['type_name'];

                                                if(isset($row['likeCount'])){
                                                    $post_like = $row['likeCount'];
                                                }else{
                                                    $post_like = 0;
                                                }
                
                                                if(isset($row['commentCount'])){
                                                    $post_comment = $row['commentCount'];
                                                }else{
                                                    $post_comment = 0;
                                                }
                                                
                                                echo "<div class ='post-container'><a href = 'viewPost.php?id=".$row['communicate_ID']."' style='text-decoration: none; color: black;'>";
                                                    
                                                    if($com_type == 1){
                                                        echo "<img src= '1.png' class=img_type> </img>";
                                                    }else if($com_type == 2){
                                                        echo "<img src= '2.png' class=img_type></img>";
                                                    }else if($com_type == 3){ 
                                                        echo "<img src= '3.png' class=img_type></img>";
                                                    }else if($com_type == 4){
                                                        echo "<img src= '4.png' class=img_type></img>";
                                                    }else if($com_type == 5){
                                                        echo "<img src= '5.png' class=img_type></img>";
                                                    }                                            
                                                    echo "<img src='".$user_photo."' class=img></IMG>"; echo" "; echo "$user_name";
                                                    echo "<h3 style='margin-left: 50px'>$com_title</h3>";
                                                    echo "<p style='margin-left: 50px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; max-width: 70%; height:50px;'>";
                                                        if (mb_strlen($com_post) > 200) {
                                                            echo mb_substr($com_post, 0, 200) . "...";
                                                        } else {
                                                            echo $com_post;
                                                        }
                                                    echo "</p>";
    

                                                    if (!empty($lable_names)) {
                                                        $lable_names_array = explode(',', $lable_names);
                                                        $unique_lable_names = array_unique($lable_names_array);
                                                        echo "<div style='display: flex; flex-wrap: wrap;'>";
                                                        foreach ($unique_lable_names as $lable) {
                                                            echo "<p style='background-color: #c7e9ff; width: fit-content; border-radius: 5px; margin-right: 5px'>#$lable</p>";
                                                            echo " ";
                                                        }
                                                        echo "</div>";
                                                    }else{
                                                        echo "<p></p>";
                                                    }
    
                                                    if($type_name!="經驗分享"){
                                                        echo "<div class='area'><p>$com_target</p></div>";
                                                    }
                                                    if ($com_target === '找人才') {
                                                        echo "<p>地點: $com_place</p>";
                                                    }
    
                                                    $hasLiked = false;
                                                    if (isset($_SESSION['user_ID'])) {
                                                        $user_ID = $_SESSION['user_ID'];
                                                        $checkLikeQuery = "SELECT * FROM post_like WHERE communicate_ID = $communicate_ID AND user_ID = $user_ID";
                                                        $checkLikeResult = mysqli_query($link, $checkLikeQuery);
                                                        if (mysqli_num_rows($checkLikeResult) > 0) {
                                                            $hasLiked = true;
                                                        }
                                                    }
                                                    if ($hasLiked) {
                                                        echo "<span class = nice><i class='bi bi-hand-thumbs-up-fill'></i> $post_like</span>";
                                                    } else {
                                                        echo "<span class = nice><i class='bi bi-hand-thumbs-up'></i> $post_like</span>";
                                                    }
                                                    echo "<span class = nice><i class='bi bi-chat-right-text'></i> $post_comment</span>";
                                                    echo "<span class = nice><i class='bi bi-eye'></i> $viewCount</span>";
                                                echo "</div></a>";
                                            }
                                        
                                    echo "</div>";
                                echo "</section>";
                            }
                    ?>
                </div>
            </div>

            <div class="right">
                <div class="hot">
                    <h2 style="text-align :center; font-size: 25px; ">熱門活動</h2>
                    <ul class="zone" >
                        <li class ='post'>
                            <a href='https://www.careernet.org.tw/n/Class-14486.html' style="text-decoration: none; font-size: 16px;">中小企業訂單違約法律責任</a>
                        </li>                   
                        <li class ='post'>
                            <a href='https://bhuntr.com/tw/external-link?url=https%3A%2F%2Fparg.co%2FbRbf' style="text-decoration: none; font-size: 16px;">2023 新創千里馬創業競賽</a>
                        </li>
                        <li class ='post'>
                            <a href='https://ustart.yda.gov.tw/?Lang=zh-tw' style="text-decoration: none; font-size: 16px;">112年度U-start創新創業計畫</a>
                        </li>
                        <li class ='post'>
                            <a href='https://sbtr.org.tw/frontend/index.aspx' style="text-decoration: none; font-size: 16px;">SBTR推動中小企業城鄉創生轉型輔導計畫</a>
                        </li>
                        <li class ='post'>
                            <a href='https://stli.iii.org.tw/news-event.aspx?no=16&d=1222' style="text-decoration: none; font-size: 16px;">經濟部中小企業處經銷布局策略課程</a>
                        </li>
                    </ul>
                </div>
                <div class="hot">
                    <h2 style="text-align :center; font-size: 25px; ">熱門標籤</h2>
                    <ul class="zone" >
                        <?php
                            $lableQuery = "SELECT lable_name FROM lable";
                            $hotLables = mysqli_query($link, $lableQuery);
                            while ($row = mysqli_fetch_assoc($hotLables)) {
                                $lableName = $row['lable_name'];
                                echo "<li class ='post'>";
                                echo "$lableName";
                                echo "</li>";
                            }
                        ?>
                    </ul>
                </div>
                <div class="hot">
                    <h2 style="text-align :center; font-size: 25px; ">熱門問題</h2>
                    <ul class="zone" >
                        <?php
                            $questions = "SELECT c.com_title, c.com_view
                            FROM communicate c ORDER BY c.com_view DESC LIMIT 5";
                            $hot_questions = mysqli_query($link, $questions);
                            while ($row = mysqli_fetch_assoc($hot_questions)) {
                                $com_title = $row['com_title'];
                                $com_view = $row['com_view'];
                                echo "<li class ='post'>";
                                echo "$com_title";
                                echo "</li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>

    <!-- bootstrap5 jsp -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    </body>
</html>
