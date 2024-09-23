<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$conn = mysqli_connect("database-1.cxzg4akd6dhy.ap-northeast-1.rds.amazonaws.com", "admin", "Bk+w%H86", "gasstation");
$conn -> set_charset("UTF8"); 

function validate($data) {
    // Strip unnecessary characters for example extra space, tab, newline from the user input
    $data = trim($data);
    // Remove backslashes    
    $data = stripslashes($data);
    // Convert special characters to HTML entities, thus preventing attackers from exploiting the code
    $data = htmlspecialchars($data);
    // Return validated data
    return $data;
}

$id = validate($_POST['id']);
$result = $conn->query("SELECT * FROM `iot` WHERE Customer_Id = '$id'");
$data = array();
$IOT_data = array();

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $SENSOR_Id = $row['SENSOR_Id'];
        $Gas_Empty_Weight = $row['Gas_Empty_Weight'];
        $result1 = $conn->query("SELECT * FROM `sensor_history` WHERE SENSOR_Id = '$SENSOR_Id' ORDER BY SENSOR_Time DESC LIMIT 1");
        if($result1->num_rows > 0){
            $row1 = mysqli_fetch_assoc($result1);

            $SENSOR_Weight = $row1['SENSOR_Weight'];
            $SENSOR_Battery = $row1['SENSOR_Battery'];
            $SENSOR_Time = $row1['SENSOR_Time'];
            
            // Check if the SENSOR_Time is within the last 30 minutes
            $current_time = new DateTime();
            $sensor_time = new DateTime($SENSOR_Time);
            $interval = $current_time->diff($sensor_time);
            $is_within_30_minutes = ($interval->i <= 30 && $interval->h == 0); // Check if the difference is within 30 minutes

            $data['SENSOR_Id'] = $SENSOR_Id;
            $data['is_within_30_minutes'] = $is_within_30_minutes;
            if(round(($SENSOR_Weight / 1000 - $Gas_Empty_Weight), 1)>0){
                $data['SENSOR_Weight'] = round(($SENSOR_Weight / 1000 - $Gas_Empty_Weight), 1);
            }
            else{
                $data['SENSOR_Weight'] = 0;
            }
            if($SENSOR_Battery!==null && $SENSOR_Battery >= 3500){
                $data['SENSOR_Battery'] = "正常";
            }
            else if($SENSOR_Battery!==null && $SENSOR_Battery < 3500){
                $data['SENSOR_Battery'] = "需更換電池";
            }
            else{
                $data['SENSOR_Battery'] = "無資料";
            }
            $data['SENSOR_Time'] = $SENSOR_Time;
            $data['response'] = 'success';
            $IOT_data[] = $data;
        }
        else{
            $SENSOR_Weight = '0';
            $SENSOR_Battery = "無資料";
            $data['SENSOR_Id'] = $SENSOR_Id;
            $data['SENSOR_Weight'] = $SENSOR_Weight;
            $data['SENSOR_Battery'] = $SENSOR_Battery;
            $data['response'] = 'success';
            $IOT_data[] = $data;
        }
    }

    echo json_encode($IOT_data);
    
    $result->close();
} elseif($result->num_rows == 0){
    echo json_encode(["response" => "0"]);
}
else{
    echo json_encode(["response" => "failure"]);
}

?>
