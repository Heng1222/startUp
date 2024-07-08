<?php //body有初始化須用緩衝才能正常跑isLogin.php
ob_start();
include("isLogin.php");
ob_end_flush();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>騷年調查系統</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" href="headerCSS.css" type="text/css">
    <link rel="stylesheet" href="public.css" type="text/css">
    <style>
        /* Add the styles from style.css here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header, form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
        }

        /* Add the left slide animation */
        .slide-in {
            animation: slideIn 0.5s;
        }

        .slide-out {
            animation: slideOut 0.5s;
        }

        @keyframes slideIn {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(0%);
            }
        }

        @keyframes slideOut {
            0% {
                transform: translateX(0%);
            }
            100% {
                transform: translateX(-100%);
            }
        }

        /* Add CSS for the submit button */
        input[type="submit"] {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #008CBA;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #005b80;
        }

        /* Additional options styles */
        .additional-options {
            margin-top: 10px;
        }

        /* Apply CSS on selection */
        select {
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            padding: 5px;
            width: 100%;
            margin-bottom: 10px;
        }

        select:focus {
            outline: none;
            border-color: #008CBA;
        }

        /* Result page style */
        .result-page {
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            max-width: 600px;
            margin: 20px auto;
            animation: slideIn 0.5s;
        }

        .question-text {
        font-weight: bold;
        color: #333;
        display: block;
        margin-bottom: 5px;
    }

    textarea {
        background-color: #f2f2f2;
        border: 1px solid #ddd;
        padding: 5px;
        width: 100%;
        height: 100px;
        resize: vertical;
        margin-bottom: 10px;
        font-family: Arial, sans-serif; /* Set the font-family for the textarea */
    }

    /* Apply CSS to the options of Questions 6 to 10 */
    .option-text {
        font-style: italic;
        color: #777;
    }

    .button {
    background-color: #005b80;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    display: inline-block;
    margin: 10px;
}



    </style>
</head>
<body>
    <?php 
        include('header.php');
    ?>
    
    <?php
    // 問題和選項陣列
    $questions = array(
        "question1" => "請問您的創業產業別是甚麼呢？",
        "question2" => "好的，請問您的餐館想要開設在甚麼縣市？",
        "question3" => "請問您的目標客群類別？",
        "question4" => "請敘述您的產品或服務特色？",
        "question5" => "請問您的產品低消？",
        "question6" => "是否需要精進自身技能(需要創業課程資源)?",
        "question7" => "是否選定設廠位置(MOI資料地圖)",
        "question8" => "目前是否缺乏資金?(交流區找資金)",
        "question9" => "您的企業是否缺乏專業人才?(交流區找人才)",
        "question10" => "是否認為自身企業的商業模式有不足(需要諮詢、交流區交流經驗)"
    );

    $options = array(
        "question1" => array("", "餐飲業", "零售業", "服務業"),
        "question2" => array("", "臺北市","新北市","桃園市","臺中市","臺南市","高雄市","基隆市","新竹市","嘉義市","新竹縣","苗栗縣","彰化縣","南投縣","雲林縣","嘉義縣","屏東縣","宜蘭縣","花蓮縣","臺東縣","澎湖縣","金門縣","連江縣"),
        "question3" => array("", "學生","上班族","家庭主婦","其他"),
        "question5" => array("", "低於200元","200元~500元","500元以上"),
        "question6" => array("是", "否"),
        "question7" => array("是", "否"),
        "question8" => array("是", "否"),
        "question9" => array("是", "否"),
        "question10" => array("是", "否")
    );

    $answers_part2 = array(
        "question6" => "否",
        "question7" => "否",
        "question8" => "否",
        "question9" => "否",
        "question10" => "否",
    );

    // Process part 1
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_part1"])) {
        // Handle part 1 answers
        $answers_part1 = array();
        for ($i = 1; $i <= 5; $i++) {
            $answer = isset($_POST["answer$i"]) ? $_POST["answer$i"] : "";
            $answers_part1["question$i"] = $answer;
        }

        // Show part 2
        echo '<div id="part2" class="slide-in">';
        echo "<header>";
        echo "<h1>騷年調查系統 - 資訊需求</h1>";
        echo "</header>";
        echo '<form method="post">';
        for ($i = 6; $i <= 10; $i++) {
            echo "<h2>問題 $i</h2>";
            echo "<p>" . $questions["question$i"] . "</p>";

            // Use radio buttons for options instead of <select>
            foreach ($options["question$i"] as $option) {
                echo '<input type="radio" required name="answer' . $i . '" value="' . $option . '">' . $option . '</input><br>';
        }
    }
        echo '<input type="submit" name="submit_part2" value="提交答案">';
        echo '</form>';
        echo '</div>';

    }
    // Process part 2
    else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_part2"])) {
        // Handle part 2 answers
        $answers_part2 = array();
        for ($i = 6; $i <= 10; $i++) {
            $answer = isset($_POST["answer$i"]) ? $_POST["answer$i"] : "";
            $answers_part2["question$i"] = $answer;
        }

        // Hide Part 2 and show the result page
        echo '<div id="result-page" class="result-page">';
        echo "<header>";
        echo "<h1>騷年調查系統結果</h1>";
        echo "</header>";
        echo "<h2>其他在高雄市三民區、其他餐飲類別，平均消費為200~500元的店家有___間，（以地圖顯示店家位置與資訊）<h2>";
        if($answers_part2["question6"] === "是" or $answers_part2["question7"] === "是" or $answers_part2["question8"] === "是" or $answers_part2["question9"] === "是" or $answers_part2["question10"] === "是"){
            echo '系統按照你的需要列出了資源分區:<br>';
            if ($answers_part2["question6"] === "是") {
                echo '<a href="link-to-創業課程資源-page" class="button">創業課程資源</a><br>';
            }
            if ($answers_part2["question7"] === "是") {
                echo '<a href="link-to-MOI資料地圖-page" class="button">MOI資料地圖</a><br>';
            }
            if ($answers_part2["question8"] === "是") {
                echo '<a href="link-to-交流區找資金-page" class="button">交流區找資金</a><br>';
            }
            if ($answers_part2["question9"] === "是") {
                echo '<a href="link-to-交流區找人才-page" class="button">交流區找人才</a><br>';
            }
            if ($answers_part2["question10"] === "是") {
                echo '<a href="link-to-交流區交流經驗-page" class="button">交流區交流經驗</a><br>';
            }
        }
        echo "<h2>商模圖:<br><h2>";
        echo '</div>';
    }
    // Display part 1 by default
else {
    echo '<div id="part1">';
    echo "<header>";
    echo "<h1>騷年調查系統 - 背景資料</h1>";
    echo "</header>";
    echo '<form method="post">';
    for ($i = 1; $i <= 5; $i++) {
        echo "<h2>問題 $i</h2>";
        echo "<p class='question-text'>" . $questions["question$i"] . "</p>";
        
        // Check if it's question 4 (the one we want to change to open-ended)
        if ($i === 4) {
            echo '<textarea name="answer' . $i . '" rows="4" cols="50" required></textarea><br>';
        } else {
            echo '<select name="answer' . $i . '" onchange="showAdditionalOptions(this, ' . $i . ');"required>';
            foreach ($options["question$i"] as $option) {
                echo '<option class="option-text" value="' . $option . '">' . $option . '</option>';
            }
            echo '</select><br>';
        }
        
        // Additional options div for question 1 (show only when '餐飲業' is selected)
        if ($i === 1) {
            echo '<div id="additional-options-q' . $i . '" class="additional-options" style="display: none;">';
            echo '<select name="additional_options_q1">';
            echo '<option value="餐館業">餐館業</option>';
            echo '<option value="飲料店業">飲料店業</option>';
            echo '<option value="餐飲攤販業">餐飲攤販業</option>';
            echo '<option value="其他餐飲業">其他餐飲業</option>';
            echo '</select><br>';
            echo '</div>';
        }
    }
    echo '<input type="submit" name="submit_part1" value="下一頁">';
    echo '</form>';
    echo '</div>';
}
    
    ?>

<script>
    // JavaScript to handle page transitions and show/hide additional options
    const part1 = document.getElementById('part1');
    const part2 = document.getElementById('part2');
    const resultPage = document.getElementById('result-page');

    function showAdditionalOptions(selectElement, questionNumber) {
        const additionalOptionsDiv = document.getElementById(`additional-options-q${questionNumber}`);
        if (selectElement.value === "餐飲業") {
            additionalOptionsDiv.style.display = 'block';
        } else {
            additionalOptionsDiv.style.display = 'none';
        }
    }

    // Display part 2 when moving from part 1
    if (part1 && part2) {
        const form = part1.querySelector('form');
        if (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent form submission
                part1.classList.remove('slide-in');
                part1.classList.add('slide-out');
                part2.style.display = 'block'; // Show part 2
                part2.classList.remove('slide-out');
                part2.classList.add('slide-in');
            });
        }
    }

    // Display the result page when moving from part 2
    if (part2 && resultPage) {
        const form = part2.querySelector('form');
        if (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent form submission
                part2.classList.remove('slide-in');
                part2.classList.add('slide-out');
                resultPage.style.display = 'block'; // Show the result page
            });
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>
</body>
</html>
