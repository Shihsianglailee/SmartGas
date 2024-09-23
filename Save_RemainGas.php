
<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if (isset($_POST['id'])) {
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";

    // Call validate, pass form data as parameter and store the returned value
    $Customer_Id = validate($_POST['id']);
    $Company_Id = validate($_POST['company']);
    $gas = validate($_POST['gas']);

    $sql = "SELECT * FROM customer_accumulation WHERE Customer_Id='$Customer_Id' AND Company_Id='$Company_Id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Update
        $row = mysqli_fetch_assoc($result);
        $Accum_Id = $row['Accum_Id'];
        $Gas_Volume = $row['Gas_Volume'];
        $gas = intval($gas);
        $Gas_Volume = intval($Gas_Volume);

        $totalGas = $Gas_Volume + $gas;
        $sql1 = "UPDATE customer_accumulation SET `Gas_Volume`='$totalGas' WHERE `Accum_Id`='$Accum_Id'";
        if (!$conn->query($sql1)) {
            echo "failure";
        } else {
            echo "success";
        }
    } else {
        // Insert
        $sql2 = "INSERT INTO customer_accumulation (`Gas_Volume`, `Customer_Id`, `Company_Id`) VALUES ('$gas', '$Customer_Id', '$Company_Id')";
        if (!$conn->query($sql2)) {
            echo "failure";
        } else {
            echo "success";
        }
    }
}
?>