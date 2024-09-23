<?php
if(isset($_POST['id'])){
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";
    // Call validate, pass form data as parameter and store the returned value
    $id = validate($_POST['id']);
    $OriginalID = validate($_POST['OriginalID']);
    $NewID = validate($_POST['NewID']);
    $sql = "insert into gas_exchange values ('','$id','$OriginalID','$NewID')";
    // Execute the query. Print "success" on a successful execution, otherwise "failure".
    if(!$conn->query($sql)){
        echo "failure";
    }else{
        echo "success";   
    }
}
?>