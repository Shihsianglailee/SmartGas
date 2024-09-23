<?php
require_once "conn.php";
require_once "validate.php";

$post_data = json_decode(file_get_contents('php://input'), true);

if (isset($_POST['family_id'])&& isset($_POST['id'])) {
    
	$family_id = validate($_POST['family_id']);
	$id = validate($_POST['id']);
    // Prepare the SQL statement
    //$sql = "SELECT SENSOR_Weight FROM `iot` WHERE Customer_Id ='$id'";
   
   // $sql = "SELECT SENSOR_Weight FROM sensor_history INNER JOIN iot WHERE iot.Customer_Id IN (SELECT Customer_Id FROM `family_member` WHERE Family_Id = '$family_id')";
   $sql = "SELECT DISTINCT SENSOR_Weight FROM sensor_history INNER JOIN iot WHERE iot.Customer_Id IN (SELECT Customer_Id FROM `family_member` WHERE Family_Id ='$family_id')";

    $result = $conn->query($sql);

        if ($result->num_rows > 0) {
           $gasVolumeLeft = array();
			while ($row = $result->fetch_assoc()) {
				$gasVolumeLeft[] = $row['SENSOR_Weight'];
        }
        $data = array('gasVolumeLeft' => $gasVolumeLeft);
        echo json_encode($data);
    } else {
        echo "No data found for the specified Customer_Id.";
    }
} else {
    echo "One or more required variables are not set.";
}

$conn->close();
?>