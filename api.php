<?php
$servername = "database-1.cxzg4akd6dhy.ap-northeast-1.rds.amazonaws.com";
$username = "admin";
$password = "Bk+w%H86";
$dbname = "API_DB";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// 檢查連接是否成功
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
} else {
  echo "Connection success";
}

// 設定編碼為 UTF-8
mysqli_set_charset($conn, "utf8");

// 查詢資料庫
$sql = "SELECT name, age, gender FROM TEST";
$result = mysqli_query($conn, $sql);

// 將結果轉換為 JSON 格式
$rows = array();
while($row = mysqli_fetch_assoc($result)) {
  $rows[] = $row;
}
echo json_encode($rows);

// 關閉連接
mysqli_close($conn);

?>