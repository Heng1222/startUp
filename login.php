<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <title>登入</title>
    <!-- 響應式 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap5 css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" href="headerCSS.css" type="text/css">
    <link rel="stylesheet" href="public.css" type="text/css">   
<body>
<?php 
include('header.php');
if(isset($_GET['log'])){
    echo"<script language='javascript'>
    alert('請先登入');
    </script>";
}
include('linkDB.php');
?>
<?php
if(isset($_POST['account'])&&isset($_POST['password'])){
    $userAccount=$_POST['account'];
    $userPassword=$_POST['password'];
    $sql="SELECT user_ID,user_name,user_photo FROM uuser WHERE user_account='$userAccount' AND user_pwd='$userPassword'";
    @$result = getResult($sql);
    if($result->num_rows==1){
       @session_start();
       $row=mysqli_fetch_assoc($result);
       $_SESSION['login']='yes';
       $_SESSION['user_ID']=$row['user_ID'];
       $_SESSION['user_name']=$row['user_name'];
       $_SESSION['user_photo']=$row['user_photo'];
       header('Location:index.php');
    }else{
        echo"<script language='javascript'>
        alert('帳號或密碼錯誤！');
        </script>"; 
    }
}

?>
<div class="d-flex justify-content-center">
<form class='shadow mb-5 bg-body rounded m-5 bg-white row pb-3' style='overflow: hidden;width:30%;' action='' method='post'>
    <div class='col-12 d-flex justify-content-center align-self-center' style='height:15%;background-color:#0075c987;'><label class='h4 d-flex justify-content-center align-self-center mh-100 m-1 fw-bold'>登入</label></div>
    <label class='h5 col-3 d-flex justify-content-end align-self-center g-5'>帳號:</label>
    <div class=' col-9 g-5'><input type="text" name='account' class="form-control mb-2" placeholder="電子郵件信箱"></div>
    <label class='h5 col-3 d-flex justify-content-end align-self-center g-5'>密碼:</label>
    <div class=' col-9 g-5'><input type="password" name='password' class="form-control mb-2 g-5" placeholder="請輸入密碼"></div>
    <div class='col-6 mt-4 mb-2'><a class='d-flex justify-content-center' href="">忘記密碼</a></div>
    <div class='col-6 mt-4 mb-2'><a class='d-flex justify-content-center' href="enroll.php">註冊帳號</a></div>
    <label class='col-3 g-3'></label>
    <button type="submit" class="btn btn-primary mb-4 col-2 g-4">登入</button>
    <label class='col-2'></label>
    <button type="reset" class="btn btn-primary mb-4 col-2 g-4">取消</button>
</form>
</div>
<!-- bootstrap5 jsp -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
</body>


<!-- TODO -->
<!-- 忘記密碼-->