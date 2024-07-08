<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <title>我的履歷表</title>
    <!-- 響應式 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap5 css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" href="headerCSS.css" type="text/css">
    <link rel="stylesheet" href="public.css" type="text/css">
    <script>  //Delete Resume alert
        function deleteCheck() {
            var answer = window.confirm("確定要刪除這個履歷嗎？");
            if (answer) {
                return true;
            }
            else {
                return false;
            }
        }
    </script>

<body>
    <?php
    include('header.php');
    include('isLogin.php');
    include('linkDB.php');
    ?>
    <?php //刪除履歷
    if (isset($_POST['delete'])) {
        $resumeID = $_POST['delete'];
        $Dsql = "DELETE FROM resumee WHERE resumee_ID=$resumeID";
        getResult($Dsql);
    }
    ?>
    <div class='outside' style='height:500px'>
        <h2 class='text-center mt-5 mb-5 fw-bold'>我的履歷表</h2>
        <div class='container'>
            <div class='row'>
                <?php
                @session_start();
                $userID = $_SESSION['user_ID'];
                $sql = "SELECT resumee_ID,resumee_name,resumee_date FROM resumee WHERE user_ID=$userID";
                $result = getResult($sql);
                if ($result->num_rows == 0) {
                    echo "<h1 class='text-center mt-5 fw-bold' style='color:#0e0e0e52;'>目前還沒有履歷唷</h1>";
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='col-4'>
        <form action='' method='post' onSubmit='return deleteCheck(this);'>
        <div class='content p-3'>
            <div class='card shadow p-2'>
                <a href='viewResume.php?id=" . $row['resumee_ID'] . "' class='link-dark text-decoration-none'>
                    <div class='info'>
                        <img class='card-img-top shadow-sm' src='resume.jpg' alt='Resume'>
                        <div class='card-body pb-1'>
                            <h5 class='fw-bold'>".$row['resumee_name']."</h5>
                            <p class='' style='font-size:14px'>建立時間:".$row['resumee_date']."</p>
                        </div>
                    </div>
                </a>
                <div class='delete d-flex justify-content-end'>
                    <input type='hidden' name='delete' value='" . $row['resumee_ID'] . "'>
                    <input type='submit' class='btn btn-primary text-end text-right' value='刪除'>
                </div>
            </div>
        </div>
        </form>
        </div>";
                    }
                }

                ?>
            </div>
        </div>
    </div>
    <!-- bootstrap5 jsp -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>
</body>



<!-- TODO -->
<!-- 圖片更改-->