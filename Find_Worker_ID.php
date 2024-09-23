<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");




// Check if email is set
if (isset($_POST['email'])) {
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";

    // Call validate, pass form data as parameter and store the returned value
    $email = validate($_POST['email']);

    // Create a prepared statement
    $sql = "SELECT WORKER_Id FROM worker WHERE WORKER_Email = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameter to the prepared statement
    $stmt->bind_param("s", $email);

    // Execute the statement
    if ($stmt->execute()) {
        // Store the result
        $stmt->store_result();

        // If number of rows returned is greater than 0 (that is, if the record is found), retrieve and return the data as JSON
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($Worker_Id);
            $stmt->fetch();

            

            $worker_data = [
                'Worker_Id' => $Worker_Id,
                'response' => 'success'
            ];

            echo json_encode($worker_data);
        } else {
            // If no record is found, return a JSON response indicating failure
            echo json_encode(["response" => "failure"]);
        }
    } else {
        // Handle the case where the statement execution fails
        echo json_encode(["response" => "failure"]);
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
}


?>
