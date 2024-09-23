<?php
if(isset($_POST['email']) && isset($_POST['password'])){
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";
   
    // Prepare and bind the input data
    $stmt = $conn->prepare("INSERT INTO customer (CUSTOMER_Name, CUSTOMER_Sex, CUSTOMER_PhoneNo, CUSTOMER_Postal_Code, CUSTOMER_Address, CUSTOMER_HouseTelpNo, CUSTOMER_Password, CUSTOMER_Email, COMPANY_Id, CUSTOMER_Notes, CUSTOMER_Registration_Time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $name = validate($_POST['name']);
    $sex = validate($_POST['sex']);
    $phone = validate($_POST['phone']);
    $postCode = validate($_POST['postCode']);
    $houseTel = validate($_POST['houseTel']);
    $password = validate($_POST['password']);
    $email = validate($_POST['email']);
    $address = validate($_POST['address']);
    $company = validate($_POST['company']);
    $lift = validate($_POST['lift']);
    $time = validate($_POST['time']);
 
    $stmt->bind_param("sssssssssss", $name, $sex, $phone, $postCode, $address, $houseTel, $password, $email, $company, $lift, $time);
    
    if($stmt->execute()) {
        echo "success";
    } else {
        echo "failure";
    }
}
?>