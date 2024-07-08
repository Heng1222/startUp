<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <title>test page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" href="headerCSS.css" type="text/css">
    <link rel="stylesheet" href="public.css" type="text/css">

<body>
    <?php
    include('header.php');
    include('linkDB.php');
    ?>

    <h2 class='fw-bold mb-4 ms-2 mt-4'>新增貼文</h2>

    <form class='ps-4'method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        發文者ID：<input type="text" name="user_ID"><br>
        貼文狀態(默認未解決)：<input type="checkbox" name="com_status" value="1">已解決<br><br>
        貼文內容：<textarea name="com_post" rows="4" cols="50"></textarea><br>
        需求：<input type="text" name="com_target"><br>
        地點：<input type="text" name="com_place"><br>
        標題：<input type="text" name="com_title"><br>
        貼文類型(1找投資、2找人才、3經驗分享、4人力資源、5資金資源)：<input type="text" name="com_type"><br>
        <input type="submit" value="送出">
    </form>
    <!-- bootstrap5 jsp -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>
</body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $com_time = date('Y-m-d H:i:s', time());
    $com_status = isset($_POST['com_status']) ? 1 : 0;
    $com_post = $_POST['com_post'];
    $com_target = $_POST['com_target'];
    $com_place = $_POST['com_place'];
    $com_title = $_POST['com_title'];
    $userID = $_POST['user_ID'];
    $com_type = $_POST['com_type'];

    $sql = "INSERT INTO communicate (com_time, com_status, com_post, com_target,com_view, com_place,user_ID, com_title, type_ID) 
            VALUES ('$com_time', $com_status, '$com_post', '$com_target', 0, '$com_place','$userID','$com_title', '$com_type')";

    if (getResult($sql)) {
        echo "<script language='javascript'>
    alert('發文完成');
    window.location.href='communicate.php';
    </script>";
    
    } else {
        echo "<script language='javascript'>
        alert('ERROR');
        window.location.href='communicate.php';
        </script>";
    }
}
?>
