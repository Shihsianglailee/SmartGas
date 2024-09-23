<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once "conn.php";
require_once "validate.php";

// 驗證並獲取POST請求中的客戶ID
$id = validate($_POST['id']);

// 根據客戶ID從 iot 表中查詢相關記錄
$result = $conn->query("SELECT * FROM `iot` where Customer_Id='$id'");

// 初始化一個空陣列來存放結果
$output = array();

// 當該指令執行有回傳
while ($row = $result->fetch_assoc()) 
{
    // 逐項將回傳的記錄放到陣列中
    $output[] = $row;
}

// 將資料陣列轉成 JSON 並顯示在網頁上，並要求不把中文編成 UNICODE
print(json_encode($output, JSON_UNESCAPED_UNICODE));

// 關閉資料庫連線
$result->close(); 
?>
