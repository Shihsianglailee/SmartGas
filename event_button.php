<?php
    require_once "conn.php";
    require_once "validate.php";

    // Set the character encoding
    header('Content-Type: application/json; charset=utf-8');

    // Validate the input ID
    $id = validate($_POST['id']);

    // Query the database
    $result = $conn->query("SELECT * FROM `announcement` WHERE Company_Id = '$id'");

	$conn->query("SET NAMES 'utf8'");

    $announcement = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $Announcement_Name = mb_convert_encoding($row['Announcement_Name'], 'UTF-8', 'auto');
            $Announcement_Type = mb_convert_encoding($row['Announcement_Type'], 'UTF-8', 'auto');
            $Announcement_Description = mb_convert_encoding($row['Announcement_Description'], 'UTF-8', 'auto');

            // Create an associative array for each announcement
            $ann = array(
                'Announcement_Name' => $Announcement_Name,
                'Announcement_Type' => $Announcement_Type,
                'Announcement_Description' => $Announcement_Description
            );

            $announcement[] = $ann;
        }

        // Encode the array as JSON and output
        echo json_encode($announcement, JSON_UNESCAPED_UNICODE);

        $result->close();
    } else {
        echo "failure";
        exit;
    }
?>