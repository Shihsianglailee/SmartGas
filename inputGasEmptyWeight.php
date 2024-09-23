<?php
// if (isset($_POST['id'])) {
//     // Include the necessary file

    require_once "conn.php";
    require_once "validate.php";

    // Call validate, pass form data as parameter and store the returned value
    $gasWeightEmpty = validate($_POST['gasWeightEmpty']);
    $sensor_Id = validate($_POST['sensorId']);

    // Insert new data into the database
    $insertQuery = "UPDATE `iot` SET `Gas_Id`= NULL,`Gas_Empty_Weight`='$gasWeightEmpty' WHERE `SENSOR_Id`='$sensor_Id'";
    if (!$conn->query($insertQuery)) {
        echo "failure";
    } else {
        echo "success";
    }
?>