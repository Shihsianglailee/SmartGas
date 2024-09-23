<?php
if(isset($_POST['Customer_ID'])){
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";
   
    // Prepare and bind the input data
    $Customer_ID = validate($_POST['Customer_ID']);
    $Company_Id = validate($_POST['Company_Id']);
    $sql = "select * from customer_accumulation where `Customer_Id`='$Customer_ID' and `Company_Id`='$Company_Id'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $row = mysqli_fetch_assoc($result);
        $Gas_Volume = $row['Gas_Volume'];

        $sql2 = "SELECT * FROM `company` WHERE `COMPANY_Id` = '$Company_Id'";
        $result2 = $conn->query($sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $Company_Name = $row2['COMPANY_Name'];

        $Gas_data = array();
        $Gas_data['Gas_Volume'] = $Gas_Volume;
        $Gas_data['Company_Name'] = $Company_Name;
        echo json_encode($Gas_data);
    }
    else{
        echo json_encode(["response" => "failure"]);
    }
}
	
?>