<?php
header('Access-Control-Allow-Origin: *');
// Check if newpassword are set
if(isset($_POST['NewPassword'])){
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";
    // Call validate, pass form data as parameter and store the returned value
    $newPassword = validate($_POST['NewPassword']);
    $email = validate($_POST['email']);
    // Create the SQL query string
    $sql = "select * from worker where `WORKER_Email`='$email'";
    // Execute the query
    $result = $conn->query($sql);
    // If number of rows returned is greater than 0 (that is, if the record is found), we'll print "success", otherwise "failure"
    if($result->num_rows > 0){
        $resetPasswordsql = "update worker set WORKER_Password='$newPassword' where `WORKER_Email`='$email'";
        if(!$conn->query($resetPasswordsql)){
            echo "failure";
        }else{
            echo "success";   
        }
    } else{
        // If no record is found, print "failure"
        echo "the phone didn't sign up yet!!!";
    }
}
?>