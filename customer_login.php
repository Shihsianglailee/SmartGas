<?php
if (isset($_POST['email']) && isset($_POST['password'])) {
    require_once "conn.php";
    require_once "validate.php";

    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    $sql = "SELECT * FROM customer WHERE `CUSTOMER_Email` = ? AND `CUSTOMER_Password` = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo "success";
        } else {
            echo "failure";
        }
    } else {
        echo "failure";
    }
    $stmt->close();
    $conn->close();
}
?>
