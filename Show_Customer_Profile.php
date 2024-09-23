<?php
// Check if newpassword are set
if(isset($_POST['id'])){
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";
    // Call validate, pass form data as parameter and store the returned value
    $id = validate($_POST['id']);
    // Create the SQL query string
    $sql = "select * from customer where `CUSTOMER_Id`='$id'";
    // Execute the query
    $result = $conn->query($sql);
    // If number of rows returned is greater than 0 (that is, if the record is found), we'll print "success", otherwise "failure"
    if($result->num_rows > 0){
        $row = mysqli_fetch_assoc($result);
        $CUSTOMER_Name = $row['CUSTOMER_Name'];
        $CUSTOMER_Tel = $row['CUSTOMER_HouseTelpNo'];
        $CUSTOMER_Phone = $row['CUSTOMER_PhoneNo'];
        $CUSTOMER_Address = $row['CUSTOMER_Address'];
        $CUSTOMER_Email = $row['CUSTOMER_Email'];
        $customer_data = array();
        $customer_data['CUSTOMER_Name'] = $CUSTOMER_Name;
        $customer_data['CUSTOMER_Tel'] = $CUSTOMER_Tel;
        $customer_data['CUSTOMER_Phone'] = $CUSTOMER_Phone;
        $customer_data['CUSTOMER_Address'] = $CUSTOMER_Address;
        $customer_data['CUSTOMER_Email'] = $CUSTOMER_Email;
        $customer_data['response'] = 'success';
        echo json_encode($customer_data);

        //echo "success";
    } else{
        // If no record is found, print "failure"
        echo json_encode(["response" => "failure"]);
        //echo "failure";
    }
}
?>