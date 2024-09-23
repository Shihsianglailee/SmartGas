<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: Content-Type');
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once "conn.php";
    require_once "validate.php";
	
	$sql = "select*from country";
	 if(!$conn->query($sql)){
        echo "Error in connecting to Database";
    }
	else{
        $result =$conn->query($sql);
		if($result ->num_rows > 0){
		$return_arr['country']=array();
		while($row = $result -> fetch_array()){
			array_push($return_arr['country'], array(
				'country_id' => $row['country_id'],
				'country_name' => $row['country_name']
			));
		}
		echo json_encode($return_arr);		
    }
}
?>