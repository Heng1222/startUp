<div class="header">
    <style>
        .dropdown-menu {
            max-width: unset;
            /* 或者設定你需要的 max-width 值 */
            position: unset;
            /* 或者設定其他合適的 position 值 */
            inset: 0px 0px 0px 0px;
            /* 移除這行 */
            margin: unset;
            /* 或者設定其他合適的 margin 值 */
            transform: unset;
            /* 或者移除這行 */
        }
    </style>
    <!-- ***** Logo Start ***** -->
    <div class='hd'>
        <div class='1'>
            <a href="index.php">
                <div class='logoArea'><img class="logo" src="logo.jpg" alt="this is logo">
                    <b class='logoString'>騷年！</b>
                </div>
            </a>
        </div>
        <!-- ***** Logo End ***** -->
        <!-- ***** Menu Start ***** -->
        <div class='2'>
            <ul>
                <li><a href="index.php" class="active">首頁</a></li>
                <!-- <li><a href="questionaire.php">創業方向推薦</a></li> -->
                <li>
                    <div class='dropdown' style='height:50px;'>
                        <a class='' href='#' id='dropdownMenuLink' data-bs-toggle='dropdown'
                            aria-expanded='false' style='height:100%;display:inline-block;'>創業方向推薦</a>
                        <ul class='dropdown-menu text-center dropdown-menu-start' style='max-width: 1px;'
                            aria-labelledby='dropdownMenuButton1'>
                            <li class='w-100 ms-0 me-0'><a class='w-100 dropdown-item' href='questionaire.php'>創業診斷</a>
                            </li>
                            <li class='w-100 ms-0 me-0'><a class='w-100 dropdown-item' href='moi.php'>MOI地圖</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li><a href=" map.php">地圖化資源
                    </a>
                </li>
                <li><a href="communicate.php">交流區</a></li>
                <?php
                @session_start();
                if (isset($_SESSION['login'])) { //是否有登入
                    echo "<li><div class='dropdown'>";
                    echo "<a class='' href='#' id='dropdownMenuLink' data-bs-toggle='dropdown' aria-expanded='false'>
            <div class='myphoto'><label>Hi," . $_SESSION['user_name'] . "</label><img src='" . $_SESSION['user_photo'] . "' alt='myPhoto'></div></a>";
                    echo " <ul class='dropdown-menu text-center dropdown-menu-right' style='max-width: 1px;' aria-labelledby='dropdownMenuButton1'>
            <li class='w-100 ms-0 me-0'><a class='w-100 dropdown-item' href='addResume.php'>創建履歷表</a></li>
            <li class='w-100 ms-0 me-0'><a class='w-100 dropdown-item' href='myResume.php'>我的履歷表</a></li>
            <li class='w-100 ms-0 me-0'><a class='w-100 dropdown-item' href='logout.php'>登出</a></li>
            </ul></div></li>";

                } else {
                    echo "<li><a href='login.php'>登入</a></li>";
                }
                ?>

            </ul>
        </div>
    </div>
    <!-- ***** Menu End ***** -->
</div>


<!-- TODO -->