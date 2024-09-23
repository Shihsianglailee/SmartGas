<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include the necessary files
//require_once "conn.php";
//require_once "validate.php";

$conn = mysqli_connect("database-1.cxzg4akd6dhy.ap-northeast-1.rds.amazonaws.com", "admin", "Bk+w%H86", "gasstation");
function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

$sensorId = validate($_POST['id']);

//最新一筆 跟 舊的一筆
$query = "SELECT `SENSOR_Weight` 
          FROM `sensor_history` 
          WHERE `SENSOR_Id` = '$sensorId' 
          ORDER BY `SENSOR_Time` DESC 
          LIMIT 2";

$result = $conn->query($query);

if ($result->num_rows == 2) {
    $row1 = $result->fetch_assoc();
    $row2 = $result->fetch_assoc();

    $latest_weight = $row1['SENSOR_Weight'];
    $previous_weight = $row2['SENSOR_Weight'];

    if ($latest_weight > $previous_weight) {
        $sql = "update iot set `Gas_Original_Weight`= (SELECT `SENSOR_Weight` FROM `sensor_history` WHERE SENSOR_Id = '$sensorId' order by SENSOR_Time desc LIMIT 1) where `SENSOR_Id`='$sensorId'";
        if (!$conn->query($sql)) {
            echo "failure";
        } else {
            echo "success";
        }
    } else {
        echo "smaller";
    }
}

?> 