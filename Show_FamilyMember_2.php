<?php
    require_once "conn.php";
    require_once "validate.php";
    $id = validate($_POST['id']);
    $result = $conn->query("SELECT * FROM `family_member` WHERE Customer_Id = '$id'");

    $member = array();
    
    if ($result->num_rows > 0) {
        $familyMembers = array(); // Initialize an array to store the family members
        
        while ($row = $result->fetch_assoc()) {
            $Family_Id = $row['Family_Id'];
            
            $sql0 = "SELECT * FROM family_member WHERE Family_Id='$Family_Id'";
            $result0 = $conn->query($sql0);
            
            if ($result0->num_rows > 0) {
                while($row0 = $result0->fetch_assoc()){
                    $Customer_Id = $row0['Customer_Id'];
                
                    $result_name = $conn->query("SELECT CUSTOMER_Name FROM customer WHERE CUSTOMER_Id = '$Customer_Id'");
                
                    if ($result_name->num_rows > 0) {
                        $row1 = $result_name->fetch_assoc();
                        $Customer_Name = $row1['CUSTOMER_Name'];
                    
                        $member['Customer_Id'] = $Customer_Id;
                        $member['Customer_Name'] = $Customer_Name;
                        $familyMembers[] = $member;
                }
                }
            }
        }
        print(json_encode($familyMembers, JSON_UNESCAPED_UNICODE));
        
        $result0->close();
        $result_name->close();
        $result->close();
    } else {
        echo "failure";
        exit;
    }
    
    

?>