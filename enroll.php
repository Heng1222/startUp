<!DOCTYPE html>
<html lang="zh-TW">

<head>
  <title>註冊會員</title>
  <!-- 響應式 -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- bootstrap5 css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
  <link rel="stylesheet" href="headerCSS.css" type="text/css">
  <link rel="stylesheet" href="public.css" type="text/css">
  <!-- icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

<body>
  <?php
  include('header.php');
  ?>
  <div class="container-fluid">
    <div class="container bg-light w-75 mb-5 mt-5">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class='text-center'><img src="logo2.jpg" alt="logo2" class="img-fluid mb-4 mt-3"
              style="max-width: 150px;"></div>
          <h1 class="text-center mb-4">註冊會員</h1>
          <form action='enrollCheck.php' method='post' enctype='multipart/form-data'>
            <div class="mb-3">
              <label for="username" class="form-label">帳號</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person-plus"></i></span>
                <input type="text" class="form-control" id="username" name='account' placeholder="請輸入帳號(電子郵件)" required>
              </div>
              <small class="form-text text-danger">必填欄位</small>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">密碼</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control" id="password" name='password' placeholder="請輸入密碼" required>
              </div>
              <small class="form-text text-danger">必填欄位</small>
            </div>
            <div class="mb-3">
              <label for="nickname" class="form-label">姓名</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" class="form-control" id="nickname" name='name' placeholder="請輸入姓名" required>
              </div>
              <small class="form-text text-danger">必填欄位</small>
            </div>
            <div class="mb-3">
              <label for="birthday" class="form-label">生日</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar2-date"></i></span>
                <input type="date" class="form-control" id="birthday" name='birthday' required>
              </div>
              <small class="form-text text-danger">必填欄位</small>
            </div>
            <div class="mb-3">
              <label for="phone" class="form-label">電話</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                <input type="text" class="form-control" id="phone" name='phone' placeholder="請輸入手機號碼(+886)" required>
              </div>
              <small class="form-text text-danger">必填欄位</small>
            </div>
            <div class="mb-3">
              <label for="birthday" class="form-label">頭像</label>
              <div class="input-group mb-2">
                <input type="file" class="ps-3 form-control-file" name='photo' id="exampleFormControlFile1">
              </div>
              <small class="form-text text-danger">必填欄位</small>
            </div>
            <div class="mb-3">
              <label for="birthday" class="form-label">居住縣市</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                <select class="form-select" id="county-select" name='location'>
                  <option value="">請選擇</option>
                  <option value="基隆市">基隆市</option>
                  <option value="臺北市">臺北市</option>
                  <option value="新北市">新北市</option>
                  <option value="新竹市">新竹市</option>
                  <option value="新竹縣">新竹縣</option>
                  <option value="苗栗縣">苗栗縣</option>
                  <option value="桃園市">桃園市</option>
                  <option value="臺中市">臺中市</option>
                  <option value="彰化縣">彰化縣</option>
                  <option value="南投縣">南投縣</option>
                  <option value="雲林縣">雲林縣</option>
                  <option value="嘉義市">嘉義市</option>
                  <option value="嘉義縣">嘉義縣</option>
                  <option value="臺南市">臺南市</option>
                  <option value="高雄市">高雄市</option>
                  <option value="屏東縣">屏東縣</option>
                  <option value="臺東縣">臺東縣</option>
                  <option value="花蓮縣">花蓮縣</option>
                  <option value="宜蘭縣">宜蘭縣</option>
                  <option value="金門縣">金門縣</option>
                  <option value="澎湖縣">澎湖縣</option>
                  <option value="連江縣">連江縣</option>
                </select>
              </div>
            </div>
            <div class="form-check mb-5 mt-5">
              <input class="form-check-input" type="checkbox" id="disabledFieldsetCheck" required>
              <label class="form-check-label" for="disabledFieldsetCheck" style='font-size:15px'>
              同意接受 <a href='' disabled>服務條款</a> 而且已閱讀 <a href="">隱私權保護政策</a>
              </label>
            </div>
            <button type="submit" class="btn btn-primary mb-4">註冊</button>
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
