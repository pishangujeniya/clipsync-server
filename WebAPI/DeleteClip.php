<?php
include 'config.php';
 $servername = $config['DB_HOST'];
 $username = $config['DB_USERNAME'];
 $password = $config['DB_PASSWORD'];
 $dbname = $config['DB_DATABASE'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$output_array = array();

$uid = $_POST['UID'];
$clip_id = $_POST['CLIP_ID'];

$sql = "DELETE FROM `clips` WHERE CLIPID = ".$clip_id." AND UID = ".$uid."";

if ($conn->query($sql) === TRUE) {
    $output_array["success"] = "true";
} else {
    $output_array["error"] = "Error: " . $sql . "<br>" . $conn->error;
}

echo json_encode($output_array,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
//PHP END
$conn->close();
?>