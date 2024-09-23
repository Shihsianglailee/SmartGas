<?php
if (isset($_POST['id'])) {
    $conn = mysqli_connect("database-1.cxzg4akd6dhy.ap-northeast-1.rds.amazonaws.com", "admin", "Bk+w%H86", "gasstation");
    $conn->set_charset("UTF8");

    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $id = validate($_POST['id']);
    $sensor_id = validate($_POST['sensor_id']);
    $gas_weight_empty = validate($_POST['gasEmptyWeight']);
    $gas_original_weight = validate($_POST['gasSpecWeight']);
    $gas_original_weight = ($gas_original_weight + $gas_weight_empty) * 1000;

    $sql = "INSERT INTO iot (`SENSOR_Id`, `Customer_Id`, `Gas_Empty_Weight`, `Gas_Original_Weight`) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdd", $sensor_id, $id, $gas_weight_empty, $gas_original_weight);

    if ($stmt->execute()) {
        $stmt->close(); // Close the first statement

        // Prepare and execute the update statement
        $sql_1 = "UPDATE iot SET `Gas_Empty_Weight` = ?, `Gas_Original_Weight` = ?, `Customer_Id` = ? WHERE `SENSOR_Id` = ?";
        $stmt_1 = $conn->prepare($sql_1);
        $stmt_1->bind_param("ddss", $gas_weight_empty, $gas_original_weight, $id, $sensor_id);

        if ($stmt_1->execute()) {
            echo "success";
        } else {
            echo "failure";
        }

        $stmt_1->close(); // Close the second statement
    } else {
        echo "failure";
    }

    $conn->close(); // Close the connection
}
?>