# 2023資料創新應用競賽  騷年！你渴望創業嗎！？

**頁面說明**

+ crawler.py:

爬蟲Python程式檔，在page1變數放入網址(預設:https://sme.moeasmea.gov.tw/startup/modules/calendar/?start_date=2023-07-20&end_date=2023-12-31&page=1)

產生activites.csv檔案

+ activites.csv:

map.php搜尋活動、課程、競賽的資料來源，資料欄位:

`活動名稱 連結 開始時間	結束時間	主辦單位	連絡電話	聯絡Email 地點 費用 參加對象 縣市 類型`

+ twzipcode.js:

map.php同業別搜尋的選項資料，內有全台各縣市及其區的名冊

+ headerCSS.css:

header的CSS檔

+ header.php:

頁首

+ enroll.php:

註冊頁

+ enrollCheck.php:

註冊頁後台處理

+ login.php:

登入頁

+ logout.php

登出頁

+ addResume.php:

新增履歷頁

+ addResumeCheck.php

新增履歷頁後台處理

+ map.php:

地圖化資源頁

+ myResume.php

我的履歷頁(可以看到自己創立哪些履歷，可以點擊查看該履歷以及刪除)

+ viewResume.php

履歷查看頁

+ isLogin.php

登入狀態檢查，直接在需要檢查的頁面include

+ linkDB.php

連結資料庫的php程式碼
