<?php
    require_once "conn.php";
    require_once "validate.php";
    //
    $id = validate($_POST['id']);
    $result = $conn->query("SELECT * FROM `family` where Customer_Id = '$id'");
    $result2 = $conn->query("SELECT * FROM family WHERE Customer_Id = (SELECT Customer_Id FROM family WHERE Dep_Cus_Id = $id)");

    //if row size = 0 的話
    //要記得null
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $customerId = $row['Customer_Id'];
            $CUSTOMER_Name = "";
            $sql0 = "SELECT CUSTOMER_Name FROM customer WHERE CUSTOMER_Id='$customerId'";
            $result0 = $conn->query($sql0);
            if ($result0->num_rows > 0) {
                while ($row0 = $result0->fetch_assoc()) {
                    $CUSTOMER_Name = $row0['CUSTOMER_Name'];
                }
            } else {
                echo "No Customer in the database";
                exit;
            }
            $row["Customer_Id_Name"] = $CUSTOMER_Name;
            $output[] = $row;
        }
        print(json_encode($output, JSON_UNESCAPED_UNICODE));
        $result->close(); // 關閉資料庫連線
    } elseif($result2->num_rows > 0){
        while($row = $result2->fetch_assoc()){
            $customerId = $row['Customer_Id'];
            $CUSTOMER_Name = "";
            $sql0 = "SELECT CUSTOMER_Name FROM customer WHERE CUSTOMER_Id='$customerId'";
            $result0 = $conn->query($sql0);
            if ($result0->num_rows > 0) {
                while ($row0 = $result0->fetch_assoc()) {
                    $CUSTOMER_Name = $row0['CUSTOMER_Name'];
                }
            } else {
                echo "No Customer in the database";
                exit;
            }
            $row["Customer_Id_Name"] = $CUSTOMER_Name;
            $output[] = $row;
        }
        print(json_encode($output, JSON_UNESCAPED_UNICODE));
        $result->close(); // 關閉資料庫連線
    }
    else {
        echo "failure";
        exit;
    }
    

?>