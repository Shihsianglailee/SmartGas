<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// Check if newpassword are set
if(isset($_POST['id'])){

    require_once "conn.php";
    require_once "validate.php";
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
    // Create the SQL query string
    $sql = "SELECT * FROM gas WHERE `GAS_Id`='$id'";

    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = mysqli_fetch_assoc($result);
        $GAS_Weight_Empty = $row['GAS_Weight_Empty']; // 假設資料庫中有一個欄位叫做 GAS_Weight_Empty
        echo json_encode([
            "GAS_Weight_Empty" => $GAS_Weight_Empty,
            "GAS_Id" => $row['GAS_Id'], // 你可以根據需求添加更多字段
            // 添加其他需要的字段
        ]);
    } else {
        echo json_encode(["error" => "No record found"]);
    }

    $conn->close();
}
?>
