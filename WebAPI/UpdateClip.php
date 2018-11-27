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
$clip_title = $_POST['CLIP_TITLE'];
$clip_data = $_POST['CLIP_DATA'];
// $clip_data = mysql_escape_string($clip_data);
$clip_data = addslashes($clip_data);
// $clip_data = mysql_real_escape_string($clip_data);

$sql = "UPDATE `clips` SET `CLIP_TITLE`='".$clip_title."',`CLIP_DATA`='".$clip_data."' WHERE `UID`='".$uid."' AND `CLIPID`='".$clip_id."'";
if ($conn->query($sql) === TRUE) {
    $output_array["success"] = "true";
} else {
    $output_array["error"] = "Error: " . $sql . "<br>" . $conn->error;
}

echo json_encode($output_array,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
//PHP END
$conn->close();
?>