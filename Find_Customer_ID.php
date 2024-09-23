<?php
// Check if email is set
if (isset($_POST['email'])) {
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";

    $email = validate($_POST['email']);

    $sql = "SELECT * FROM customer WHERE CUSTOMER_Email = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $email);

    // Execute the statement
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $CUSTOMER_Id = $row['CUSTOMER_Id'];
            $COMPANY_Id = $row['COMPANY_Id'];
            $CUSTOMER_Name = $row['CUSTOMER_Name'];

            $customer_data = [
                'CUSTOMER_Id' => $CUSTOMER_Id,
                'COMPANY_Id' => $COMPANY_Id,
                'CUSTOMER_Name' => $CUSTOMER_Name,
                'response' => 'success'
            ];

            echo json_encode($customer_data);
        } else {
            echo json_encode(["response" => "failure"]);
        }
    } else {
        echo json_encode(["response" => "failure"]);
    }

    $stmt->close();
    $conn->close();
}
?>
