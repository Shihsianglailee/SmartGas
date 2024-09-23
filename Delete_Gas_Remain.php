<?php
if(isset($_POST['Customer_ID'])){
    // Include the necessary files
    //require_once "conn.php";
    //require_once "validate.php";
    $conn = mysqli_connect("database-1.cxzg4akd6dhy.ap-northeast-1.rds.amazonaws.com", "admin", "Bk+w%H86", "gasstation");
     $conn -> set_charset("UTF8"); 
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
    $Customer_ID = validate($_POST['Customer_ID']);
    $Company_Id = validate($_POST['Company_Id']);
    $Gas_Delete = validate($_POST['Gas_Delete']);

    $sql = "UPDATE `customer_accumulation` SET `Gas_Volume` = `Gas_Volume` - '$Gas_Delete' WHERE `Customer_Id`='$Customer_ID' and `Company_Id`='$Company_Id'";

    if(!$conn->query($sql)) {
        echo "failure " . mysqli_insert_id($conn);
    } else {
        echo "success " . mysqli_insert_id($conn);
    }
}
?>
