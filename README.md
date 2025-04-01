# ITmockTest
## 資訊檢定模擬系統
此專題使用PHP、SQL語法及HTML/CSS完成前後端實作，並以phpMyAdmin架設資料庫。開發團隊以三人小組進行，主題為校內系統。通過資訊基本能力檢定屬於本校畢業門檻，校方提供pdf和doc檔案型式的題庫供學生們自行閱讀與練習，題庫包含五大科目的考題。為了能方便且有效率了解自己在準備檢定的不足，同時模擬實際測驗情形，本團隊選擇資訊檢定模擬系統作為開發主題。此網頁分為使用者端與管理者端，使用者不但能模擬實際測驗情況，也能夠選擇特定科目進行測驗，針對該方向進行補強。除了測驗外，還提供成績單、即時排行榜和各科測驗狀況供使用者查閱。管理者能夠新增、刪除與編輯題庫中的題目，也能針對使用者進行管理。

## 前端架構
1. 使用者介面 (UI)：HTML 與 CSS： 由專案中的 .php 檔案負責生成網頁結構，並透過 des.css 定義樣式，確保一致且美觀的使用者介面。
2. 前端的互動功能：JavaScript，利用 jQuery 庫，來增強前端的互動性和動態行為。
- 即時搜尋或篩選功能： 透過監聽輸入框的變化，動態篩選並顯示符合條件的使用者列表。​
- 確認操作： 在執行刪除或編輯操作前，彈出確認對話框，避免誤操作。​
- 動態內容更新： 使用 AJAX 技術，在不重新載入整個頁面的情況下，更新部分內容，提高使用者體驗。
3. 頁面組成：
- 首頁 (index.php)：系統入口，會直接跳轉至homepage.php。
- 主頁 (homepage.php)：主頁面，提供各種功能的導航，若在未登入前點擊開始測驗，會先跳出登入/註冊表單 (modal/login.php)。​
- 關於頁面 (about.php)：介紹系統的用途、相關開發背景及題目來源。​
- 選擇科目頁面 (choose.php)：讓使用者選擇正式測驗(五大科目各10題)或特定科目進行練習。​
- 測驗頁面 (testing.php)：呈現測驗題目，讓使用者作答。
- 成績確認計算頁面 (checking.php​)：3秒後跳至結算畫面。(補充：會判斷是正式測驗或練習模式，若是formal，會從checking.php跳轉至 user/transcript.php(測試結果成績單) 可點選"查看考後檢討”跳轉至review.php；若是practice，則會直接跳轉至review.php)
- 詳細答題狀況檢視頁面 (review.php)：使用者的測驗結果，顯示題目、使用者選項、正確選項及解答說明。​
- 排行榜頁面 (leaderboard.php)：展示使用者之間的測驗排名。​
- 統計圖表頁面 (statistical_charts.php)：以圖表形式呈現各科目的測驗統計數據，例如答錯率最高的題目。
## 後端架構
1. 伺服器端邏輯：
- PHP：作為主要的伺服器端語言，負責處理使用者請求、執行相關邏輯並與資料庫互動。​
- utility_functions.php：包含常用的函數，例如連接資料庫，供其他 PHP 檔案調用，提高程式碼的重用性和維護性。以下舉例部分函數：
  - db_link()：內含 PHP 函數 mysqli_connect("主機名稱","帳號","密碼",資料庫名稱")，用來與 MySQL 資料庫連接
  - top_menu()：網頁頂端列表樣式，除了所有使用者皆能使用的功能外，根據不同角色提供額外不同功能 (題庫管理系統、會員管理系統)

2. 資料庫管理：
- MySQL 與 phpMyAdmin：系統使用 MySQL 作為資料庫，透過 phpMyAdmin 進行管理。資料庫包含以下資料表：
  - 使用者資料表：使用者ID、帳號、密碼、姓名、身分、申請時間、上次上線時間、前一次答題狀況記錄
  - 資訊素養與倫理、網際網路概論、資訊網路安全、Office、計算機概論五大科目分別建置一張資料表：題目ID、題目內容、選項A、選項B、選項C、選項D、正確解答、說明、各提出現總次數、正確答題次數
3. 功能模組：
- 使用者管理 (member_management/)： 管理者可以在此目錄下的頁面新增、刪除和編輯使用者資訊。​
  - list.php 使用者管理頁面，顯示使用者資訊(基本資訊、申請時間、角色身分)，管理者可透過設定變更使用者身分
  - setting.php 針對使用者角色的修改及刪除兩種動作的處理，會與資料庫進行相對應的互動
- 題庫管理 (question_management/)： 題庫維護相關頁面及處理，包括新增、刪除和修改題目。​
  - setting.php：針對題目的新增、修改、刪除三種動作的處理邏輯，會與資料庫進行相對應的互動
  - show.php：題庫管理頁面，顯示題庫資訊(題庫內現有總題目數、題庫內最大題號、缺少題數)、題目、選項、正解、答對率，可於該頁面新增題目或對某一題目進行編輯或刪除(題目旁會有編輯和刪除按鈕)
- 模態視窗 (modal/)： 登入、登出、註冊、更改密碼和更換大頭貼的HTML區塊配置或表單樣式等相關模組。
## Web Server
本專案透過 Apache HTTP Server 作為網頁伺服器。
