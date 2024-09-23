<?php
    require_once "conn.php";
    require_once "validate.php";
    // SQL 指令
    $id = validate($_POST['id']);
    $result = $conn->query("SELECT * FROM `customer_gas` where `Customer_Id`='$id'");
    while ($row = $result->fetch_assoc()) // 當該指令執行有回傳
    {
        $output[] = $row; // 就逐項將回傳的東西放到陣列中
    }

    // 將資料陣列轉成 Json 並顯示在網頁上，並要求不把中文編成 UNICODE
    print(json_encode($output, JSON_UNESCAPED_UNICODE));
    $result -> close(); // 關閉資料庫連線

?>