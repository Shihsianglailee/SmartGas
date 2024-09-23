<?php
// Check if newpassword are set
if(isset($_POST['id'])){
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";
    // Call validate, pass form data as parameter and store the returned value
    $id = validate($_POST['id']);
    // Create the SQL query string
    $sql = "select * from gas_order where `CUSTOMER_Id`='$id' order by Order_Time desc";
    // Execute the query
    $result = $conn->query($sql);
    // If number of rows returned is greater than 0 (that is, if the record is found), we'll print "success", otherwise "failure"
    if($result->num_rows > 0){
        $row = mysqli_fetch_assoc($result);
        $ORDER_Id = $row['ORDER_Id'];
        $Delivery_Method = $row['Delivery_Method'];
        $Expect_time = $row['Expect_time'];
        $Gas_Quantity = $row['Gas_Quantity'];
        $order_data = array();
        $order_data['ORDER_Id'] = $ORDER_Id;
        $order_data['Delivery_Method'] = $Delivery_Method;
        $order_data['Expect_time'] = $Expect_time;
        $order_data['Gas_Quantity'] = $Gas_Quantity;
        $order_data['response'] = 'success';
        echo json_encode($order_data);

        //echo "success";
    } else{
        // If no record is found, print "failure"
        echo json_encode(["response" => "failure"]);
        //echo "failure";
    }
}
?>