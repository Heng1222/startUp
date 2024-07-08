<?php
$link = mysqli_connect('localhost','root','p3LHASjnexQ:','opendata');
if(!mysqli_select_db($link,'opendata')){	
    echo"<script language='javascript'>
    alert('連接資料庫失敗！');
    </script>";
}

function getResult($sql){
    $ans=mysqli_query($GLOBALS["link"], $sql);
    return $ans;
}
?>
