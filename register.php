<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if(isset($_POST['email']) && isset($_POST['password'])){
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";
   
    // Prepare and bind the input data
    $stmt = $conn->prepare("INSERT INTO worker (WORKER_Name, WORKER_Sex, WORKER_PhoneNum, WORKER_HouseTelpNo, WORKER_Password, WORKER_Email, WORKER_Address, WORKER_COMPANY_Id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $name = validate($_POST['name']);
    $sex = validate($_POST['sex']);
    $phone = validate($_POST['phone']);
    $houseTel = validate($_POST['houseTel']);
    $password = validate($_POST['password']);
    $email = validate($_POST['email']);
    $address = validate($_POST['address']);
    $company = validate($_POST['company']);
 
    $stmt2 = $conn->prepare("SELECT COMPANY_Id FROM company WHERE COMPANY_Name=?");
    $stmt2->bind_param("s", $company);
    $stmt2->execute();
    $result = $stmt2->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $company_id = $row['COMPANY_Id'];
        $stmt->bind_param("sssssssi", $name, $sex, $phone, $houseTel, $password, $email, $address, $company_id);
        if($stmt->execute()) {
            echo "success";
        } else {
            echo "failure";
        }
    } else {
        echo "Company does not exist in the database";
    }
}

?>