<?php
if(isset($_POST['id'])){
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";
    // Call validate, pass form data as parameter and store the returned value
   
    $company = validate($_POST['company']);
    $id = validate($_POST['id']);

    $stmt2 = $conn->prepare("SELECT COMPANY_Id FROM company WHERE COMPANY_Name=?");
    $stmt2->bind_param("s", $company);
    $stmt2->execute();
    $result = $stmt2->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $company_id = $row['COMPANY_Id'];
        $stmt = $conn->prepare("UPDATE customer SET `COMPANY_Id`=? WHERE `CUSTOMER_Id`=?");
        $stmt->bind_param("si", $company_id, $id);
        if($stmt->execute()) {
            echo "success";
        } else {
            echo "failure: " . $stmt->error;
        }
    } else {
        echo "Company does not exist in the database";
    }
}
?>