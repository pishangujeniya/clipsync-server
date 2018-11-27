<?php
include 'config.php';
$servername = $config['DB_HOST'];
$username = $config['DB_USERNAME'];
$password = $config['DB_PASSWORD'];
$dbname = $config['DB_DATABASE'];

$uid = $_POST['UID'];


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$output_array = array(); 
         $sql = "SELECT * FROM `clips` WHERE `UID` = ".$uid." ORDER BY CLIPID DESC";

        if ($res = $conn->query($sql)) {
            if($res->num_rows > 0){

                $row_id = 0;

                while($row = $res->fetch_assoc()){

                    $rclipid = $row['CLIPID'];
                    $rcliptitle = $row['CLIP_TITLE'];
                    $rclipdata = $row['CLIP_DATA'];
    
                    $output_array["success"] = "true";
                   
                    $clip_array = array();
    
                    $clip_array["clip_id"] = $rclipid;
                    $clip_array["clip_title"] = $rcliptitle;
                    $clip_array["clip_data"] = $rclipdata;

                    array_push($output_array,$clip_array);
                    // $output_array[".$row_id."] = $clip_array;
                    $row_id =  $row_id + 1;
                }
            }else{
                $output_array["success"] = "false";
            }
        } else {
            $output_array["error"]  = "Error: " . $sql . "<br>" . $conn->error;
        }
		
// print_r ($output_array);
echo json_encode($output_array,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
$conn->close();
?>


