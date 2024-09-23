<?php
// if (isset($_POST['id'])) {
//     // Include the necessary files
   
    //require_once "conn.php";
    //require_once "validate.php";
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

    $gasId = validate($_POST['gasId']);
    $gasWeightEmpty = validate($_POST['gasWeightEmpty']);
    $sensor_Id = validate($_POST['sensorId']);
    $worker_Id = validate($_POST['worker_Id']);

    $selectWorkerCompanyQuery = "SELECT `WORKER_Company_Id` FROM `worker` WHERE `WORKER_Id` = '$worker_Id'";
    $result = $conn->query($selectWorkerCompanyQuery);

    if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc(); 
    $workerCompany_Id = $row['WORKER_Company_Id'];
    // Insert new data into the database
    $insertQuery = "INSERT INTO gas (`GAS_Id`, `GAS_Weight_Empty`, `GAS_Company_Id`) VALUES ('$gasId', '$gasWeightEmpty','$workerCompany_Id')";
    if (!$conn->query($insertQuery)) {
        echo "failure";
    } else {
        $updateIOT = "UPDATE `iot` SET `Gas_Id`='$gasId',`Gas_Empty_Weight`='$gasWeightEmpty' WHERE `SENSOR_Id`='$sensor_Id'";
        if(!$conn->query($updateIOT)){
            echo "failure";
        }else{
            echo "success";
        }
        echo "failure";
    }
    }
?>
