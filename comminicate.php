<html lang="zh-TW">
    <head>
        <title>交流區</title>
        <!-- 響應式 -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- bootstrap5 css -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <link rel="stylesheet" href="comminicate.css?v=<?=time()?>">
        <link rel="stylesheet" href="headerCSS.css" type="text/css">
        <link rel="stylesheet" href="public.css" type="text/css">  

    </head>

    <body>
    <?php 
        include('header.php');
    ?>

        <div class="container" style="justify-content: center;">   
            <form action="https://www.google.com/search" method="GET">
                <div class="input-group">
                    <span class="input-group-text" ><i class="bi bi-search"></i></span>
                    <input type="text" type="search" name="q" placeholder="請輸入關鍵字" >
                    <select name="place">
                        <optgroup label="北部">
                            <option value="">臺北市</option>
                            <option value="">新北市</option>
                            <option value="">基隆市</option>
                            <option value="">桃園市</option>
                            <option value="">新竹市</option>
                            <option value="">新竹縣</option>
                            <option value="">苗栗縣</option>
                        </optgroup>
                        <optgroup label="中部">
                            <option value="">臺中市</option>
                            <option value="">彰化縣</option>
                            <option value="">基隆市</option>
                            <option value="">南投縣</option>
                            <option value="">雲林縣</option>
                        </optgroup>
                        <optgroup label="南部">
                            <option value="">嘉義市</option>
                            <option value="">嘉義縣</option>
                            <option value="">臺南市</option>
                            <option value="">高雄市</option>
                            <option value="">屏東縣</option>
                        </optgroup>
                        <optgroup label="東部">
                            <option value="">宜蘭縣</option>
                            <option value="">花蓮縣</option>
                            <option value="">臺東縣</option>
                        </optgroup>
                        <optgroup label="離島">
                            <option value="">澎湖縣</option>
                            <option value="">金門縣</option>
                            <option value="">連江縣</option>
                        </optgroup>
                    </select>
                    <select name="type">
                        <option>找人才</option>
                        <option>我是人才</option>
                        <option>其他</option>
                    </select>

                    <input type="submit" id="submit" value="搜尋">
                </div>
            </form>
        </div>

        <div class="wrap">
            <div class="container-fluid" style="background-color: white; border-top-left-radius: 50px; border-top-right-radius: 50px; padding-top:3px;">
                <section class="block_system">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="recommend-tab" data-bs-toggle="tab" data-bs-target="#recommend" type="button" role="tab" aria-controls="home" aria-selected="true">推薦</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="newest-tab" data-bs-toggle="tab" data-bs-target="#newest" type="button" role="tab" aria-controls="new" aria-selected="false">最新</button>
                        </li>
                    
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="solved-tab" data-bs-toggle="tab" data-bs-target="#solved" type="button" role="tab" aria-controls="solve" aria-selected="false">已解決</button>
                        </li>
                    </ul>
                </section>
            </div>    

            <div class="right">
                <div class="hot">
                    <h2 style="margin-left: 120px; font-size: 25px; ">熱門活動</h2>
                    <ul class="zone" >
                    </ul>
                </div>
                <div class="hot">
                    <h2 style="margin-left: 120px; font-size: 25px; ">熱門標籤</h2>
                    <ul class="zone" >
                    </ul>
                </div>
                <div class="hot">
                    <h2 style="margin-left: 120px; font-size: 25px; ">熱門問題</h2>
                    <ul class="zone" >
                    </ul>
                </div>
            </div>

        </div>
    <!-- bootstrap5 jsp -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    </body>
</html>