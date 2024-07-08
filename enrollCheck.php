<?php
if (isset($_POST['account'])) {
    // 帳號判斷是否存在此帳號
    $userAccount = $_POST['account'];
    include('linkDB.php');
    $sql = "SELECT count(user_ID) as 'count' FROM uuser WHERE user_account='$userAccount'";
    $result = getResult($sql);
    $row = mysqli_fetch_assoc($result);
    if ($row['count'] > 0) {
        echo "<script language='javascript'>
        alert('此帳號已存在');
        window.location.href='enroll.php';
        </script>";
    } else {
        // 載入其他資訊
        $userPassword = $_POST['password'];
        $userName = $_POST['name'];
        $userBirth = $_POST['birthday'];
        $userPhone = $_POST['phone'];
        $userBirth=date("Y-m-d",strtotime($userBirth));
        $userLocation = ($_POST['location']=="")?NULL:$_POST['location'];
        $userPhoto="userPhoto/".$_FILES["photo"]["name"];
        //檢查檔案資料夾是否存在
        folderBuild();
        //上傳檔案
        $target_dir = "./userPhoto/"; // 檔案儲存目錄
        $target_file = $target_dir . basename($_FILES["photo"]["name"]); // 儲存的檔案路徑
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // 加入DB
            $sql="INSERT INTO uuser(user_photo,user_account,user_pwd,user_name,user_birth,user_location,user_phone) VALUES('$userPhoto','$userAccount','$userPassword','$userName','$userBirth','$userLocation','$userPhone')";
	        getResult($sql);
            echo "<script language='javascript'>
            alert('註冊成功！');
            window.location.href='login.php';
            </script>";
	    } else {
            echo "<script language='javascript'>
            alert('圖片上傳失敗，請連絡相關人員');
            window.location.href='enroll.php';
            </script>";
	    }
    }
}
function folderBuild(){
    if(is_dir('./userPhoto')){
    }else{
        mkdir("./userPhoto");
    }     
}
?>