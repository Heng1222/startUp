<?php //body有初始化須用緩衝才能正常跑isLogin.php
ob_start();
include("isLogin.php");
ob_end_flush();
?>
<html lang="zh-TW">
<head>
    <title>瀏覽</title>
    <!-- 響應式 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap5 css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="communicate.css?v=<?= time() ?>">
    <link rel="stylesheet" href="headerCSS.css" type="text/css">
    <link rel="stylesheet" href="public.css" type="text/css">
    <script>
        function callme(){
        alert('已經傳送資料給他囉！請靜待他的回覆~');
    }
    </script>
</head>

<body>
    <?php
    include('header.php');
    include('linkDB.php');
    ?>
    <?php
    // 是否喜歡
    @session_start();
    if (isset($_POST['postID'])) {
        $poID = $_POST['postID'];
        $userid = $_SESSION['user_ID']; //使用者id
        $TF = $_POST['TF'];
        if ($TF == 'true') { //已喜歡,移除
            removecollection($poID, $userid);
        } else { //沒喜歡，增加
            addcollection($poID, $userid);
        }
    }
    function addcollection($poID, $userid)
    {
        $sql = "INSERT INTO post_like(user_ID,communicate_ID) VALUES($userid,$poID)";
        getResult($sql);
    }

    function removecollection($poID, $userid)
    {
        $sql = "DELETE FROM post_like WHERE communicate_ID=$poID && User_id=$userid";
        getResult($sql);
    }

    ?>
    <?php
    // 留言
    if (isset($_POST['post'])) {
        // 時區設定
        @session_start();
        date_default_timezone_set('Asia/Taipei');
        $replyContent = $_POST['post'];
        $replyTime = date('Y-m-d H:i:s', time());
        $replyUser = $_SESSION['user_ID'];
        $replyPost = $_POST['post_id'];
        $sqlReply = "INSERT INTO post_comment(user_id,communicate_ID,comment_time,comment_post) VALUES($replyUser,$replyPost,'$replyTime','$replyContent')";
        getResult($sqlReply);
    }
    ?>
    <div class='wrap mt-5'>
        <div class=''>
            <div class='container-fluid' style='padding-top:3px;'>
                <div class='ms-2 me-2 row justify-content-center bg-white align-items-center mt-1 p-4 shadow'
                    style='; border-radius:4%'>
                    <?php
                    // 貼文
                    $postID = $_GET['id'];
                    // 觀看次數++
                    $sqlView = "UPDATE communicate SET com_view =com_view + 1 WHERE communicate_ID=$postID";
                    getResult($sqlView);
                    //讀取
                    $sql = "SELECT * FROM communicate c JOIN uuser u ON c.user_ID=u.user_ID WHERE communicate_ID=$postID";
                    $result = getResult($sql);
                    $row = mysqli_fetch_assoc($result);
                    $posterName = $row['user_name'];
                    $posterPhoto = $row['user_photo'];
                    $postTime = $row['com_time'];
                    $postView = $row['com_view'];
                    $postStatus = ($row['com_status'] == 1) ? "已解決" : "未解決";
                    $postContent = $row['com_post'];
                    $postTarget = $row['com_target'];
                    $postTopic = $row['com_title'];
                    //按讚
                    $sqlLike = "SELECT count(user_ID) as likes FROM post_like GROUP BY communicate_ID HAVING communicate_ID = $postID";
                    $result = getResult($sqlLike);
                    $row = mysqli_fetch_assoc($result);
                    $postLikes = @$row['likes'];
                    $postLikes=($postLikes==Null)?0:$postLikes;
                    echo "<div class='col-3' style=''>
                    <div class='imgArea w-100 pt-4 ps-3 pe-3' style='height:200px'>
                        <img src='" . $posterPhoto . "' class='w-100 h-100' style='object-fit:cover;border-radius: 5%;' alt=''>
                    </div>
                </div>
                <div class='col-9'>
                    <div class='infoArea pt-1 ps-2 w-100 h-100 d-flex flex-column'>

                        <h4 class='pt-2'>" . $postTopic . "</h4>
                        <div class='status d-flex justify-content-between'>
                            <!-- bg-danger 未解決 -->";
                    if ($postStatus == "已解決") {
                        echo "<label class='bg-success text-white p-1'
                                style='font-size:12px;border-radius:10%'>" . $postStatus . "</label>";
                    } else {
                        echo "<label class='bg-danger text-white p-1'
                                style='font-size:12px;border-radius:10%'>" . $postStatus . "</label>";
                    }
                    echo "<div class='hinfo'>
                                <label class='text-muted fw-bolder' style='font-size:12px;'>觀看人數:" . $postView . "</label>
                                <label class='text-muted fw-bolder' style='font-size:12px;'>按讚人數:" . $postLikes . "</label>
                            </div>
                        </div>
                        <hr class='mt-2 mb-2'>
                        <p class='mb-2' style='font-size:14px'>作者：" . $posterName . "<button class='btn btn-primary p-1 ms-3' style='font-size:12px' onclick='callme()'>聯絡我！</button></p>
                        <p class='mb-2' style='font-size:14px'>發表時間：" . $postTime . "</p>
                        <p class='mb-2' style='font-size:14px'>需求：" . $postTarget . "</p>
                    </div>
                </div>
                <div class='col-12 g-3'>
                    <hr class='mt-0' style='height:2px;'>
                    <div class='p-2 contentArea  shadow-sm' style='height:400px;max-height:400px;overflow: auto;'>
                        <p class='p-3 fw-bolder text-break lh-lg' style='font-size:18px'>" . $postContent . "
                        </p>
                    </div>
                </div>
                <div class='col-12 g-3'>
                    <div class='downset d-flex flex-row justify-content-between mt-3 me-3'>
                        <div class='report ps-4'>
                            <a href=''><label class='fw-bolder' style='font-size:15px;'>檢舉</label></a>
                        </div>
                        <div class='like/unlike d-flex'>
                                <div class='unlike ms-3 me-3'>
                                    <i id='" . $postID . "'class='bi bi-hand-thumbs-down' style='font-size:30px;'></i>
                                    <b class='fw-bolder' style='font-size:15px;'>不喜歡</b>
                                </div>";
                                $userID = $_SESSION['user_ID'];
                                $sqlIsLike="SELECT * FROM post_like WHERE communicate_ID=$postID && user_ID=$userID";
                                $result=getResult($sqlIsLike);
                                if($result->num_rows==0){
                                    echo "<div class='like ms-3 me-3'>
                                    <i id='" . $postID . "' class='bi bi-hand-thumbs-up likeicon' style='font-size:30px;'></i>
                                    <b class='fw-bolder' style='font-size:15px;'>喜歡</b>
                                </div>";
                                }else{
                                    echo "<div class='like ms-3 me-3'>
                                    <i id='" . $postID . "' class='bi bi-hand-thumbs-up-fill likeicon' style='font-size:30px;'></i>
                                    <b class='fw-bolder' style='font-size:15px;'>喜歡</b>
                                </div>";
                                }
                    echo "
                        </div>
                    </div>
                </div>";

                    ?>

                    <div class='col-12 g3 mt-5'>
                        <div class='w-100 text-white text-center' style='background-color:#a4ceeb;'>
                            <h3 class='p-2 fw-bold mb-0'>留言區</h3>
                        </div>
                        <div class='reply' style='background-color:#72b5ff17;'>
                            <?php
                            $sql2 = "SELECT user_name,user_photo,SUBSTRING(comment_time,1,19) AS comment_time,comment_post FROM post_comment c JOIN uuser u ON c.user_ID=u.user_ID WHERE communicate_ID=$postID ORDER BY comment_time ";
                            $result = getResult($sql2);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<div class='replyItem pt-2 pb-2 ps-3'>
                            <a href='' class='me-3 mt-1'
                                style='float: left;border-radius: 50%;width: 50px;height: 50px;overflow: hidden;'>
                                <img src='" . $row['user_photo'] . "' alt='photo' style='width: 100%;height: 50;object-fit: cover;'>
                            </a>
                            <div class='replyContent mt-1' style='overflow: hidden;'>
                                <a href=''><label class='fw-bolder text-primary'
                                        style='font-size:17px;'>" . $row['user_name'] . "</label></a>
                                <label class='fw-bolder align-middle ms-2'
                                    style='font-size:12px;color: hsl(0deg 1.9% 64%)'>" . $row['comment_time'] . "</label>
                                <p class='ps-3 text-break pe-5'>" . $row['comment_post'] . "
                                </p>
                                </div>
                            </div>
                            <hr class='mt-0 mb-0'>";
                            }
                            ?>
                            <!-- 新增回覆 -->
                            <div class='write  pt-2 ps-3'>
                                <a href="" class='me-3 mt-1'
                                    style='float: left;border-radius: 50%;width: 50px;height: 50px;overflow: hidden;'>
                                    <?php
                                    $userID = $_SESSION['user_ID'];
                                    $sqlU = "SELECT user_photo FROM uuser WHERE user_ID=$userID";
                                    $result = getResult($sqlU);
                                    $row = mysqli_fetch_assoc($result);
                                    $userPhoto = $row['user_photo'];
                                    echo "<img src='" . $userPhoto . "' alt='photo' style='width: 100%;height: 50;object-fit: cover;'>";
                                    ?>
                                </a>
                                <div class='replyContent mt-1' style='overflow: hidden;'>
                                    <form action="" method='post' class='me-3'>
                                        <?php echo "<input type='hidden' name='post_id' value='" . $postID . "'>"; ?>
                                        <textarea name='post' class='ms-1 mb-1 ps-1 text-break pe-5 w-100 mt-2 form-control'
                                            placeholder='給點回覆吧！'></textarea>
                                        <div class='d-flex flex-row-reverse w-100'><input type="submit"
                                                class='mt-1 btn btn-primary p-1 me-2' value='發佈'></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>
    <script type="text/javascript" language="javascript" src="AJAX.js"></script>
</body>

</html>
<!-- TODO -->
<!-- com_type -->
