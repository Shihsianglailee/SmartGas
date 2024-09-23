<?php
header('Access-Control-Allow-Origin: *');
if (isset($_POST['email']) && isset($_POST['password'])) {
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";

    // Call validate, pass form data as parameter and store the returned value
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    // Create a prepared statement
    $sql = "SELECT * FROM worker WHERE WORKER_Email = ? AND WORKER_Password = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameters to the prepared statement
    $stmt->bind_param("ss", $email, $password);

    // Execute the statement
    if ($stmt->execute()) {
        // Store the result
        $result = $stmt->get_result();

        // If number of rows returned is greater than 0 (that is, if the record is found), print "success"
        if ($result->num_rows > 0) {
            echo "success";
        } else {
            // If no record is found, print "failure"
            echo "failure";
        }
    } else {
        // Handle the case where the statement execution fails
        echo "failure";
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
}
?>