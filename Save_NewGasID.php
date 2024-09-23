<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include the necessary files
//require_once "conn.php";
//require_once "validate.php";

$conn = mysqli_connect("database-1.cxzg4akd6dhy.ap-northeast-1.rds.amazonaws.com", "admin", "Bk+w%H86", "gasstation");
function validate($data) {
    // Strip unnecessary characters for example extra space, tab, newline from the user input
    $data = trim($data);
    // Remove backslashes    
    $data = stripslashes($data);
    // Convert special characters to HTML entities, thus preventing attackers from exploiting the code
    $data = htmlspecialchars($data);
    // Return validated data
    return $data;
  }


// Call validate, pass form data as parameter and store the returned value
$order_Id = validate($_POST['id']);
$time = validate($_POST['time']);

//最新一筆 跟 舊的一筆
$sql_check = "";

$sql = "update gas_order set `DELIVERY_Time`='$time',`DELIVERY_Condition`='1' where `ORDER_Id`='$order_Id'";

$result = "";

if (!$conn->query($sql)) {
    echo "failure";
} else {
    echo "success";
}
?>