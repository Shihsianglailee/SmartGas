<?php
    require_once "conn.php";
    require_once "validate.php";
    // SQL 指令
    //SELECT * FROM `gas_order` inner join `gas_order_detail` in gas_order.ORDER_Id = gas_order_detail.ORDER_Id 
	if (isset($_POST['id']) && isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $id = validate($_POST['id']);
	$start_date = validate($_POST['start_date']);
    $end_date = validate($_POST['end_date']);
   	
    $result = $conn->query("SELECT * FROM `gas_order` inner join `gas_order_detail` on gas_order.ORDER_Id = gas_order_detail.ORDER_Id where gas_order.CUSTOMER_Id='$id' AND gas_order.Order_Time BETWEEN '$start_date' AND '$end_date' and gas_order.DELIVERY_Condition='1'");
    while ($row = $result->fetch_assoc()) // 當該指令執行有回傳
    {
        $output[] = $row; // 就逐項將回傳的東西放到陣列中
    }

    // 將資料陣列轉成 Json 並顯示在網頁上，並要求不把中文編成 UNICODE
    print(json_encode($output, JSON_UNESCAPED_UNICODE));
    $result -> close(); // 關閉資料庫連線
	
	} else {
    echo "One or more required variables are not set.";
}

?>