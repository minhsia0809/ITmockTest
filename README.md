# ITmockTest
## 資訊檢定模擬系統
此專題使用PHP、SQL語法及HTML/CSS完成前後端實作，並以phpMyAdmin架設資料庫。開發團隊以三人小組進行，主題為校內系統。通過資訊基本能力檢定屬於本校畢業門檻，校方提供pdf和doc檔案型式的題庫供學生們自行閱讀與練習，題庫包含五大科目的考題。為了能方便且有效率了解自己在準備檢定的不足，同時模擬實際測驗情形，本團隊選擇資訊檢定模擬系統作為開發主題。此網頁分為使用者端與管理者端，使用者不但能模擬實際測驗情況，也能夠選擇特定科目進行測驗，針對該方向進行補強。除了測驗外，還提供成績單、即時排行榜和各科測驗狀況供使用者查閱。管理者能夠新增、刪除與編輯題庫中的題目，也能針對使用者進行管理。
## 前端架構
1. 使用者介面 (UI)：HTML 與 CSS： 由專案中的 .php 檔案負責生成網頁結構，並透過 des.css 定義樣式，確保一致且美觀的使用者介面。
2. 頁面組成：
- 首頁 (index.php)： 提供系統的入口，包含登入、登出及註冊功能。​
- 主頁 (homepage.php)： 登入後的主頁面，提供各種功能的導航。​
- 關於頁面 (about.php)： 介紹系統的用途和開發背景。​
- 選擇科目頁面 (choose.php)： 讓使用者選擇勝測驗或特定科目進行測驗。​
- 測驗頁面 (testing.php)： 呈現測驗題目，讓使用者作答。​
- 成績檢視頁面 (review.php)： 顯示使用者的測驗結果和答案解析。​
- 排行榜頁面 (leaderboard.php)： 展示使用者的測驗排名。​
- 統計圖表頁面 (statistical_charts.php)： 以圖表形式呈現各科目的測驗統計數據。
## 後端架構
1. 伺服器端邏輯：
- PHP： 作為主要的伺服器端語言，負責處理使用者請求、執行相關邏輯並與資料庫互動。​
- utility_functions.php： 包含常用的函數，供其他 PHP 檔案調用，提高程式碼的重用性和維護性。
2. 資料庫管理：
- MySQL 與 phpMyAdmin： 系統使用 MySQL 作為資料庫，透過 phpMyAdmin 進行管理。資料庫包含以下資料表：
  - 使用者資料表：使用者ID、使用者帳號、密碼、姓名、上次上線時間、身分等基本資訊
  - 五大科目分別建置一張資料表(待確認)：題目ID、題號、選項A、選項B、選項C、選項D、正確解答、說明
  - 使用者成績紀錄資料表(待確認)
3. 功能模組：
- 使用者管理 (member_management/)： 管理者可以在此目錄下的頁面新增、刪除和編輯使用者資訊。​
- 題庫管理 (question_management/)： 管理者能夠在此目錄下的頁面對題庫進行維護，包括新增、刪除和修改題目。​
- 模態視窗 (modal/)： 可能包含用於顯示提示或對話框的模組，提高使用者互動體驗。
## Web Server
本專案透過Apache HTTP Server作為網頁伺服器。
