<?php
if (isset($_POST['sql'])) {
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";

    // Call validate, pass form data as parameter and store the returned value
    $sql = validate($_POST['sql']);

    // Execute the query and check the affected rows
    if ($conn->query($sql)) {
        if ($conn->affected_rows > 0) {
            echo "success";
        } else {
            echo "failure";
        }
    } else {
        echo "failure";
    }
}

?>