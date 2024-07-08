<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <title>建立履歷</title>
    <!-- 響應式 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap5 css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" href="headerCSS.css" type="text/css">
    <link rel="stylesheet" href="public.css" type="text/css">
    <!-- icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script>
        function getName() {
            var guest = window.prompt('請輸入新建履歷的名稱！', '');
            if (guest == null || "") {
                alert("請輸入有效名稱！");
                window.location.href='myResume.php';
            } else {
                tar=document.getElementById('resumeName');
                tar.value = guest;
            }

        }
    </script>
<body>
    <?php
    include('header.php');
    include('linkDB.php');
    ?>
    <div class="container-fluid">
        <div class="container w-75 mb-5 mt-5">
            <div class="row justify-content-center  bg-light ">
                <div class="col-md-10">
                    <div class='text-center'><img src="logo.jpg" alt="平台 logo" class="img-fluid mb-4 mt-3"
                            style="max-width: 150px;"></div>
                    <h1 class="text-center mb-4">建立履歷</h1>
                    <p class='mt-5 pe-3' style='overflow-wrap: break-word;'>建立履歷表讓您快速展示您的才能並且讓面試人員更快了解你的背景！填寫下方相關欄位資料後，即可快速生成屬於自己的履歷表。不用美編、不用排版，我們通通幫你做好了！只需要完成表格即可生成履歷。依照不同需求建立專屬的履歷，更能展現不同企業想看到的獨特面貌。</p>
                    <!-- check -->
                    <?php
                    @session_start();
                    $userid = $_SESSION['user_ID'];
                    $sql = "SELECT user_name,user_birth FROM uuser where user_ID=$userid";
                    $result = getResult($sql);
                    $row = mysqli_fetch_assoc($result);
                    $userName = $row['user_name'];
                    $userBirth = $row['user_birth'];
                    
                    echo "<div class='mb-3'>
                    <labelclass='form-label'>姓名</label>
                        <div class='input-group'>
                            <span class='input-group-text'><i class='bi bi-person'></i></span>
                            <input type='text' class='form-control' placeholder='" . $userName . "'' disabled>
                        </div>
                </div>";
                    echo "<div class='mb-3'>
                <label class='form-label'>生日</label>
                <div class='input-group'>
                    <span class='input-group-text'><i class='bi bi-calendar-day-fill'></i></span>
                    <input type='text' class='form-control' placeholder='" . $userBirth . "' disabled>
                </div>
            </div>";
                    ?>
                    <!-- check over -->
                    <p class='mt-5 pe-3' style='overflow-wrap: break-word;'>
                        請先確認上述資料是否正確，若不正確請先至個人資訊頁更改，確認無誤後請填寫下方資料欄，系統會自動將您填的資料生成為履歷表</p>
                    <form class='mt-3' action='addResumeCheck.php' method='post'>
                        <input type="hidden" id='resumeName' name='name' value='null'>
                        <script>getName()</script>
                        <?php
                        echo "<input type='hidden' id='date' name='date' value='".date("Y-m-d",time())."'>";
                        ?>
                        <div class="mb-3">
                            <label for="experience" class="form-label">自我介紹</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                <textarea class="form-control" name='introduction' id="experience"
                                    placeholder="今年29歲，去年離開XX...." required style="height: 100px;"></textarea>
                            </div>
                            <small class="form-text text-danger">必填欄位</small>
                        </div>
                        <div class="mb-3">
                            <label for="experience" class="form-label">經歷</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-people"></i></span>
                                <textarea class="form-control" name='experience' id="experience"
                                    placeholder="例：2020~2022 XX公司軟體開發工程師..." required style="height: 100px;"></textarea>
                            </div>
                            <small class="form-text text-danger">必填欄位</small>
                        </div>
                        <div class="mb-3">
                            <label for="skills" class="form-label">專長</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-hammer"></i></span>
                                <textarea class="form-control" name='skills' id="skills" placeholder="例：機器學習、UI介面設計..."
                                    required style="height: 100px;"></textarea>
                            </div>
                            <small class="form-text text-danger">必填欄位</small>
                        </div>
                        <div class="mb-3">
                            <label for="experience" class="form-label">教育程度</label>
                            <div class="custom-control custom-radio ps-2">
                                <input type="radio" id="customRadio1" name="education" value='博士'
                                    class="custom-control-input">
                                <label class="custom-control-label" for="customRadio1">博士畢業</label>
                            </div>
                            <div class="custom-control custom-radio ps-2">
                                <input type="radio" id="customRadio2" name="education" value='碩士'
                                    class="custom-control-input">
                                <label class="custom-control-label" for="customRadio2">碩士畢業</label>
                            </div>
                            <div class="custom-control custom-radio ps-2">
                                <input type="radio" id="customRadio3" name="education" value='學士'
                                    class="custom-control-input">
                                <label class="custom-control-label" for="customRadio3">學士畢業</label>
                            </div>
                            <div class="custom-control custom-radio ps-2">
                                <input type="radio" id="customRadio4" name="education" value='高中職'
                                    class="custom-control-input">
                                <label class="custom-control-label" for="customRadio4">高中職畢業</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mb-4">提交</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- bootstrap5 jsp -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>
</body>
<!-- TODO -->
