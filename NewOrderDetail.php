<?php
if(isset($_POST['Order_ID'])){
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";
   
    // Prepare and bind the input data
    // $stmt = $conn->prepare("INSERT INTO gas_order (CUSTOMER_Id, COMPANY_Id, DELIVERY_Condition, DELIVERY_Address, DELIVERY_Phone, WORKER_Email, Gas_Quantity, Order_Time, Expect_time, Delivery_Method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $Order_ID = validate($_POST['Order_ID']);
    $Quantity = validate($_POST['Quantity']);
    $Type = validate($_POST['Type']);
    $Weight = validate($_POST['Weight']);
    $exchange = validate($_POST['Exchange']);
    $sql = "insert into `gas_order_detail`(`Order_ID`, `Order_Quantity`, `Order_type`, `Order_weight`,`exchange`) values ('$Order_ID','$Quantity','$Type','$Weight',$exchange)";
    if(!$conn->query($sql)) {
        echo "failure ";
    } else {
        echo "success ";
    }
}

?>