<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_POST['id'])) {
    // Include the necessary files

    require_once "conn.php";
    require_once "validate.php";

    // Call validate, pass form data as parameter and store the returned value
    $gasId = validate($_POST['gasId']);
    $gasWeightEmpty = validate($_POST['gasWeightEmpty']);
    $Worker_Id = validate($_POST['Worker_Id']);

    $selectWorkerCompanyQuery = "SELECT `WORKER_Company_Id` FROM `worker` WHERE `WORKER_Id` = '$Worker_Id'";
    $result = $conn->query($selectWorkerCompanyQuery);

    if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $workerCompany_Id = $row['WORKER_Company_Id'];

    // Insert new data into the gas table with the retrieved WORKER_Company_Id
    $insertQuery = "INSERT INTO `gas` (`GAS_Id`, `GAS_Weight_Empty`, `GAS_Company_Id`) 
                    VALUES ('$gasId', '$gasWeightEmpty','$workerCompany_Id')";

    if ($conn->query($insertQuery)) {
        echo "success";
    } else {
        echo "failure";
    }
    }
}
?>
