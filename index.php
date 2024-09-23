<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Check if newpassword are set
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
if(isset($_POST['email'])){
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";

    // Call validate, pass form data as parameter and store the returned value
    $email = validate($_POST['email']);
    // Create the SQL query string
    $sql = "select * from customer where `CUSTOMER_Email`='$email'";
    // Execute the query
    $result = $conn->query($sql);
    // If number of rows returned is greater than 0 (that is, if the record is found), we'll print "success", otherwise "failure"
    if($result->num_rows > 0){
        require 'phpmailer/PHPMailer.php';
        require 'phpmailer/SMTP.php';
        require 'phpmailer/Exception.php';
        
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Port = "587";
        $mail->Username = "leelinda6234@gmail.com";
        $mail->Password = "kavqtenmrbiexehy";
        $mail->Subject = "Gas App Reset Password";
        $mail->setFrom('leelinda6234@gmail.com','Gas App Reset Password');
        $mail->isHTML(true);
        $random = rand(1000, 9999);
	    $mail->Body = "<h1>這是您的驗證碼: </h1>" . $random;
	    $mail->addAddress($email);
        if ( $mail->send() ) {
            echo "success".$random;
        }else{
            echo "mail failure " . $mail->ErrorInfo;
        }


        
    } else{
        // If no record is found, print "failure"
        echo "account failure";
    }
}
?>