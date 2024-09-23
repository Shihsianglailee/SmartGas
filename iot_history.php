<?php
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


    $id = validate($_POST['id']);
    $result = $conn->query("SELECT * FROM sensor_history WHERE SENSOR_Id = '$id' AND SENSOR_Time >= DATE_SUB(NOW(), INTERVAL 30 DAY) ORDER BY SENSOR_Time DESC LIMIT 10");
    $output = array();

    //假如在iot找的到該sensor_id的gas_empty_weight的話 要減掉
    //這裡只有一個sensor_id
    

    while ($row = $result->fetch_assoc()) // 當該指令執行有回傳
    {
        $result_1 = $conn->query("SELECT * FROM iot WHERE SENSOR_Id = '$id'");

        while($row_1 = $result_1->fetch_assoc()){
            if($row_1['Gas_Empty_Weight'] !== null){
                $Gas_Empty_Weight = $row_1['Gas_Empty_Weight'];
                if(round(($row['SENSOR_Weight']/1000 - $Gas_Empty_Weight),1)>0){
                    $row['SENSOR_Weight'] = round(($row['SENSOR_Weight']/1000 - $Gas_Empty_Weight),1);
                }
                else{
                    $row['SENSOR_Weight'] = 0;
                }

    
                $Gas_Original_Weight = $row_1['Gas_Original_Weight'];
                if($Gas_Original_Weight === null){
                    $Gas_remain = (($row['SENSOR_Weight']/1000) - $Gas_Empty_Weight);
                    if($Gas_remain<0){
                        $Gas_remain = 0;
                    }
                }
                else{
                    // 不知道為何SENSOR_Weight照道理來講要除以1000 但是單位已經是公斤
                    $Gas_remain = ($row['SENSOR_Weight'])/(($Gas_Original_Weight/1000) - $Gas_Empty_Weight)/10;
                    if($Gas_remain<0){
                        $Gas_remain = 0;
                    }
                }
                $row['Gas_remain'] = $Gas_remain;
            }
         }
        $output[] = $row; // 就逐項將回傳的東西放到陣列中
    }

    // 將資料陣列轉成 Json 並顯示在網頁上，並要求不把中文編成 UNICODE
    print(json_encode($output, JSON_UNESCAPED_UNICODE));
    $result -> close(); // 關閉資料庫連線

?>