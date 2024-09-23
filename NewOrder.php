<?php
if(isset($_POST['Customer_ID'])){
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";
   
    // Prepare and bind the input data
    // $stmt = $conn->prepare("INSERT INTO gas_order (CUSTOMER_Id, COMPANY_Id, DELIVERY_Condition, DELIVERY_Address, DELIVERY_Phone, WORKER_Email, Gas_Quantity, Order_Time, Expect_time, Delivery_Method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $Customer_ID = validate($_POST['Customer_ID']);
    $Company_Id = validate($_POST['Company_Id']);
    $delivery_condition = validate($_POST['delivery_condition']);
    $delivery_address = validate($_POST['delivery_address']);
    $delivery_phone = validate($_POST['delivery_phone']);
    $Gas_Quantity = validate($_POST['Gas_Quantity']);
    $order_time = validate($_POST['order_time']);
    $expect_time = validate($_POST['expect_time']);
    $delivery_method = validate($_POST['delivery_method']);
    $sql = "insert into `gas_order`(`ORDER_Id`, `CUSTOMER_Id`, `COMPANY_Id`, `DELIVERY_Time`, `DELIVERY_Condition`, `DELIVERY_Address`, `DELIVERY_Phone`, `Gas_Quantity`, `Order_Time`, `Expect_time`, `Delivery_Method`) values ('','$Customer_ID','$Company_Id','','$delivery_condition','$delivery_address','$delivery_phone','$Gas_Quantity','$order_time','$expect_time','$delivery_method')";
    if(!$conn->query($sql)) {
        echo "failure " . mysqli_insert_id($conn);
    } else {
        echo "success " . mysqli_insert_id($conn);
    }
}

?>