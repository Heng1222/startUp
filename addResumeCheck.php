<?php
if(isset($_POST['introduction'])){
    @session_start();
    $userID=$_SESSION['user_ID'];
    $userIntro=nl2br($_POST['introduction']);
    $userExp=nl2br($_POST['experience']);
    $userSkill=nl2br($_POST['skills']);
    $userEdu=$_POST['education'];
    $resumeName=$_POST['name'];
    $resumeDate=$_POST['date'];

    include('linkDB.php');
    $sql="INSERT INTO resumee(resumee_experience,resumee_skill,resumee_introduce,resumee_education,resumee_name,resumee_date,user_ID) VALUES('$userExp','$userSkill','$userIntro','$userEdu','$resumeName','$resumeDate','$userID')";
    if(getResult($sql)){
    echo "<script language='javascript'>
    alert('新增成功！');
    window.location.href='myResume.php';
    </script>";
    }else{
        echo "<script language='javascript'>
        alert('新增失敗，請聯繫管理員！');
        window.location.href='addResume.php';
        </script>";
    }

}
?>