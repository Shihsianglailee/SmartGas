<?php
// if (isset($_POST['id'])) {
//     // Include the necessary files
    

    require_once "conn.php";
    require_once "validate.php";

    // Call validate, pass form data as parameter and store the returned value

    $gasId = validate($_POST['gasId']);
    $gasWeightEmpty = validate($_POST['gasWeightEmpty']);
    $sensor_Id = validate($_POST['sensorId']);

    // Insert new data into the database
    $updateQuery = "UPDATE `iot` SET `Gas_Id`='$gasId',`Gas_Empty_Weight`='$gasWeightEmpty' WHERE `SENSOR_Id`='$sensor_Id'";
    if (!$conn->query($updateQuery)) {
        echo "failure";
    } else {
        echo "success";
    }
?>