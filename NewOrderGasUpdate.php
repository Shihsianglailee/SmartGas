<?php
$servername = "database-1.cxzg4akd6dhy.ap-northeast-1.rds.amazonaws.com";
$username = "admin";
$password = "Bk+w%H86";
$dbname = "gasstation";

//$servername = "localhost";
//$username = "root";
//$password = "";
//$dbname = "gas";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$json = json_decode(file_get_contents("php://input"), true);



$Customer_ID = $json['cusID'];
$companyID = $json['companyID'];
$delivery_condition = $json['delivery_condition'];
$Gas_Quantity_Sum = $json['Gas_Quantity_Sum'];
$Gas_Quantity = $json['Gas_Quantity'];
$order_time = $json['order_time'];
$expect_date = $json['expect_time'];
$expect_time_index = $json['expect_time_index'];
$delivery_method = $json['delivery_method'];

$accumulation = $json['accumulation'];

$companyID = $json["companyID"];


$weights = array(5, 16, 20, 5, 16, 20);

$expect_time_index = intval($expect_time_index);

//0: 8:00-10:00
//1: 10:00-12:00
//2: 12:00-14:00
//3: 14:00-16:00
//4: 16:00-18:00
//5: 18:00-20:00
if ($expect_time_index == 0){
    $expectTime = "08:00:00";
}elseif($expect_time_index == 1){
    $expectTime = "10:00:00";
}elseif($expect_time_index == 2){
    $expectTime = "12:00:00";
}elseif($expect_time_index == 3){
    $expectTime = "14:00:00";
}elseif($expect_time_index == 4){
    $expectTime = "16:00:00";
}elseif($expect_time_index == 5){
    $expectTime = "18:00:00";
}

$expect_datetime = $expect_date . $expectTime;

//Delivery Time 設 null
$sql = "insert into `gas_order`(`CUSTOMER_Id`, `COMPANY_Id`, `DELIVERY_Condition`, `DELIVERY_Address`, `DELIVERY_Phone`, `Gas_Quantity`, `Order_Time`, `Expect_time`, `Delivery_Method`) values ('$Customer_ID','$companyID','$delivery_condition',(SELECT CUSTOMER_Address FROM `customer` WHERE CUSTOMER_Id = '$Customer_ID'),(SELECT CUSTOMER_PhoneNo FROM `customer` WHERE CUSTOMER_Id = '$Customer_ID'),'$Gas_Quantity_Sum','$order_time','$expect_datetime','$delivery_method');";

//$result = $conn->query($sql);
//echo $result;

//看有沒有在gas_order新增成功

if(intval($Gas_Quantity_Sum) >0){
    if(!$conn->query($sql)){
        echo "gas_order insertion fail\n";
        
    }else{
        echo "gas_order insertion success\n";
    }
}else{
    exit("quantity is zero");
}



sleep(1);
$lastordersql = "SELECT ORDER_Id FROM `gas_order` WHERE CUSTOMER_Id = '$Customer_ID' ORDER BY Order_Time DESC LIMIT 1;";
$order = $conn->query($lastordersql);

//抓取在上面在 gas_order 的 ID
if(!$conn->query($lastordersql)){
    echo "fetch gas_order ID fail";
}else{
    //echo "success";
    while($row = $order->fetch_assoc()) {
      //echo "last order id: " . $row["ORDER_Id"];
        $lastorderID = $row["ORDER_Id"];
    }
    echo "fetch gas_order ID success, orderID: ";
    echo $lastorderID;
}

$arrlength = count($Gas_Quantity);


for($x = 0; $x < $arrlength; $x++) {
    
    if($Gas_Quantity[$x] != 0) {
        
        if($x<3){
            echo "複合材料";
            echo $Gas_Quantity[$x];
            
            
            if($accumulation[$x] > 0){
                $sql = "INSERT INTO `gas_order_detail` (`Order_ID`, `Order_Quantity`, `Order_type`, `Order_weight`, `exchange`) VALUES ('$lastorderID', '$Gas_Quantity[$x]', 'composite', '$weights[$x]', '1');";
                //$conn->query($sql);
                
                
            }else{
                $sql = "INSERT INTO `gas_order_detail` (`Order_ID`, `Order_Quantity`, `Order_type`, `Order_weight`) VALUES ('$lastorderID', '$Gas_Quantity[$x]', 'composite', '$weights[$x]');";
                //$conn->query($sql);
              
            }
            
            if(!$conn->query($sql)){
                echo "fail";
            }else{
                echo "success";
            }
            
            
        }else{
            echo "傳統鋼瓶";
            echo $Gas_Quantity[$x];
            
            
                if($accumulation[$x] > 0){
                    $sql = "INSERT INTO `gas_order_detail` (`Order_ID`, `Order_Quantity`, `Order_type`, `Order_weight`, `exchange`) VALUES ('$lastorderID', '$Gas_Quantity[$x]', 'tradition', '$weights[$x]', '1');";
                    //$conn->query($sql);
                    
                    
                }else{
                    $sql = "INSERT INTO `gas_order_detail` (`Order_ID`, `Order_Quantity`, `Order_type`, `Order_weight`) VALUES ('$lastorderID', '$Gas_Quantity[$x]', 'tradition', '$weights[$x]');";
                    //$conn->query($sql);
                    
                }
            
                if(!$conn->query($sql)){
                    echo "fail";
                }else{
                    echo "success";
                }
            
            }
    }
}



//update gas accumulation section

$volumesql = "SELECT Accum_Id, Gas_Volume FROM `customer_accumulation` WHERE Customer_Id = '$cusID' AND Company_Id = '$companyID';";

// 看看使用者有沒有累計紀錄


if(!$conn->query($volumesql)){
    
    exit("fetch accumulationID fail");
    
}else{
    echo "fetch accumulationID success\n";

    
    if($conn->affected_rows > 0){ // 使用者有紀錄
        while($row = $result1->fetch_assoc()) {
            
            $volume = intval($row["Gas_Volume"]);
            echo $volume;
        }
        
        sleep(1);

        $sumAccumWeights = 0;
        
        
        // 計算此筆訂單共需扣掉多少殘氣
        for($x = 0; $x < $arrlength; $x++) {
            
            if(intval($accumulation[$x]) * intval($weights[$x]) != 0){
                $sumAccumWeights = $sumAccumWeights + intval($accumulation[$x]) * intval($weights[$x]) * intval($Gas_Quantity[$x]);
            }
        }
        
        $updatedvolume = $volume - $sumAccumWeights;
        
        $sql = "UPDATE `customer_accumulation` SET Gas_Volume = $updatedvolume WHERE Customer_Id = '$cusID' AND Company_Id = '$companyID';";


        if(!$conn->query($sql)){
            echo "update gas accumulation fail";
        }else{
            echo "update gas accumulation success";
        }
    }else{
        // 沒紀錄代表他沒有殘氣
    }
    
    
}

//echo json_encode($rows, JSON_PRETTY_PRINT);
$conn->close();
?>
