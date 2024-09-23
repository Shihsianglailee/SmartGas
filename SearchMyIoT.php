<?php

$servername = "database-1.cxzg4akd6dhy.ap-northeast-1.rds.amazonaws.com";
$username = "admin";
$password = "Bk+w%H86";
$database = "gasstation";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$json = json_decode(file_get_contents("php://input"), true);


$cusID = $json["cusID"];

$sql = "SELECT SENSOR_Id, Customer_Id FROM `iot` WHERE CUSTOMER_Id = '6';"; //$cusID


$result = $conn->query($sql);


if ($result->num_rows > 0) {// output data of each row
  while($row = $result->fetch_assoc()) {
      $rows[] = $row;
  }
} else {
    echo "0 results";
}



echo json_encode($rows, JSON_PRETTY_PRINT);
$conn->close();


?>
