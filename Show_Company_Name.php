
<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// Check if newpassword are set
if(isset($_POST['id'])){
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";
    
    $id = validate($_POST['id']);
    
    $sql = "SELECT * FROM company WHERE COMPANY_Id = (SELECT COMPANY_Id FROM gas_order WHERE ORDER_Id = '$id');";
    
    $result = $conn->query($sql);
   
    if($result->num_rows > 0){
        $row = mysqli_fetch_assoc($result);
        $Company_Name = $row['COMPANY_Name'];
        $customer_data = array();
        $customer_data['Company_Name'] = $Company_Name;

        $sql2 = "SELECT * FROM gas_order WHERE ORDER_Id = '$id'";
        $result2 = $conn->query($sql2);
        $row = mysqli_fetch_assoc($result2);
        $Customer_Id = $row['CUSTOMER_Id'];
        $Company_Id = $row['COMPANY_Id'];
        $customer_data['Customer_Id'] = $Customer_Id;
        $customer_data['COMPANY_Id'] = $Company_Id;

        $customer_data['response'] = 'success';
        echo json_encode($customer_data);
    } else{
        echo json_encode(["response" => "failure"]);
    }
}
?>
