<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if(isset($_POST['id'])){
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";
    // Call validate, pass form data as parameter and store the returned value
    $email = validate($_POST['email']);
    $name = validate($_POST['name']);
    $phone = validate($_POST['phone']);
    $houseTel = validate($_POST['houseTel']);
    $address = validate($_POST['address']);
    $id = validate($_POST['id']);
    // Create the SQL query string. We'll use md5() function for data security. It calculates and returns the MD5 hash of a string
    $sql = "update worker set `WORKER_Name`='$name',`WORKER_Email`='$email',`WORKER_Address`='$address',`WORKER_HouseTelpNo`='$houseTel',`WORKER_PhoneNum`='$phone' where `WORKER_Id`='$id'";
    // Execute the query. Print "success" on a successful execution, otherwise "failure".
    if(!$conn->query($sql)){
        echo "failure";
    }else{
        echo "success";   
    }
}
?>