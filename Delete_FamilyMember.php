<?php
if (isset($_POST['id'])) {
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";

    // Call validate, pass form data as parameter and store the returned value
    $id = validate($_POST['id']);
    
    $sql = "DELETE FROM `family_member` WHERE Customer_Id='$id'";
    if (!$conn->query($sql)) {
        echo "failure";
    } else {
        echo "success";
    }

}
?>