<?php
require_once "conn.php";
require_once "validate.php";

$post_data = json_decode(file_get_contents('php://input'), true);

if (isset($_POST['family_id'])&& isset($_POST['id'])) {
	
	$family_id = validate($_POST['family_id']);
	$id = validate($_POST['id']);

    // Prepare the SQL statement
    $sql = "SELECT Customer_Id FROM `family_member` WHERE Family_Id = '$family_id'";
   
    $result = $conn->query($sql);

        if ($result->num_rows > 0) {
           $cus_id = array();
			while ($row = $result->fetch_assoc()) {
				$cus_id[] = $row['Customer_Id'];
        }
        $data = array('cus_id' => $cus_id);
        echo json_encode($data);
    } else {
        echo "No data found for the specified Customer_Id.";
    }
} else {
    echo "One or more required variables are not set.";
}

$conn->close();
?>