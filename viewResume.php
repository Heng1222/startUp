<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <title>履歷</title>
    <!-- 響應式 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap5 css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" href="headerCSS.css" type="text/css">
    <link rel="stylesheet" href="public.css" type="text/css">

<body>
    <?php
    include('header.php');
    include('isLogin.php');
    include('linkDB.php');
    $userID=$_SESSION['user_ID'];
    $resumeID=$_GET['id'];
    $sql="SELECT * FROM resumee JOIN uuser ON resumee.user_ID=uuser.user_ID WHERE resumee_ID=$resumeID AND resumee.user_ID=$userID";
    $result=getResult($sql);
    if($result->num_rows==0){
        echo"<script language='javascript'>
        alert('異常檢視！');
        window.location.href='myResume.php';
        </script>";
        
    }
    else{
        $row=mysqli_fetch_assoc($result);
        echo "<div class='container bg-white w-75 mt-5 mb-3' style='height:auto;max-width:900px; min-width:800px'>
        <div class='row h-100'>
            <div class='col-4 bg-secondary d-flex flex-column pt-5 pb-5 justify-content-between'>
                <div class='textArea1 d-flex flex-column mt-3'>
                    <img src='".$row['user_photo']."' class='mb-5 align-self-center mt-2' alt='photo'
                        style='border-radius:50%;object-fit: cover;width:200px;height:200px;'>
                    <h2 class='fw-bold text-center mt-2 mb-4 text-white'>".$row['user_name']."</h2>
                </div>
                <div class='textArea2 text-light align-self-center w-100 ps-2 mb-3'>
                    <h4 class='fw-bold mb-4 text-left'>My CONTACT</h4>
                    <h6 class='fw-bold  text-left ps-2'>Email</h6>
                    <p class='text-break ps-4 pe-2'>".$row['user_account']."</p>
                    <h6 class='fw-bold  text-left ps-2'>Phone</h6>
                    <p class='text-break ps-4 pe-2'>".$row['user_phone']."</p>
                    <h6 class='fw-bold  text-left ps-2'>Birthday</h6>
                    <p class='text-break ps-4 pe-2'>".$row['user_birth']."</p>
                </div>
            </div>
            <div class='col-8'>
                <div class='content p-4'>
                    <h2 class='fw-bold text-right mt-5 mb-4 ps-2 text-black'>ABOUT MYSELF</h2>
                    <div class='pt-1 bg-dark w-100 mb-4'></div>
                    <p class='text-break ps-4 pe-2 fs-5 fw-bold text-muted' style='height:200px'>
                        ".$row['resumee_introduce']."</p>
                    <h2 class='fw-bold text-right mt-5 mb-4 ps-2 text-black'>EXPERIENCE</h2>
                    <div class='pt-1 bg-dark w-100 mb-4'></div>
                    <p class='text-break ps-4 pe-2 fs-5 fw-bold text-muted' style='height:200px'>".$row['resumee_experience']."</p>
                    <h2 class='fw-bold text-right mt-5 mb-4 ps-2 text-black'>SKILL</h2>
                    <div class='pt-1 bg-dark w-100 mb-4'></div>
                    <p class='text-break ps-4 pe-2 fs-5 fw-bold text-muted' style='height:200px'>".$row['resumee_skill']."</p>
                </div>
            </div>
        </div>
    </div>";
    }
    ?>
    <div class='outside w-100'>
        
    </div>
    <!-- bootstrap5 jsp -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>
</body>
<!-- TODO -->
