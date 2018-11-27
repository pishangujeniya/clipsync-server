<?php
include 'config.php';
$servername = $config['DB_HOST'];
$username = $config['DB_USERNAME'];
$password = $config['DB_PASSWORD'];
$dbname = $config['DB_DATABASE'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$output_array = array();  
$output_array["success"] = "false";


if(!empty($_POST['userName']) && !empty($_POST['userEmail']) && !empty($_POST['userPassword'])){



$uname = $_POST['userName'];
$uemail = $_POST['userEmail'];
$upass = $_POST['userPassword'];
// Check connection
if ($conn->connect_error) {
    die("Connection failed  " . $conn->connect_error);
}

// if (empty($_POST['userName']) || empty($POST['userPassword']) || empty($_POST['userEmail'])){
//     echo "Khali Requesto Nai Padvani... Honnnn";
// }else{
        $sql = "INSERT INTO users (name, password, email)
        VALUES ('".$uname."', '".$upass."', '".$uemail."')";

        if ($conn->query($sql) === TRUE) {

            $getuid = "SELECT uid from users WHERE email = '".$uemail."'";
            
            if ($res = $conn->query($getuid)) {
                if($res->num_rows > 0){
                    $row = $res->fetch_array();
                   
                    $ruid = $row['uid'];

                            $output_array["success"] = "true";
                            $output_array["uid"] = $ruid;
                            $output_array["username"] = $uname;
                            $output_array["email"] = $uemail;
                        
                }else{
                    $output_array["success"] = "false";
                }
            } else {
                $output_array["success"] = "false";
                // $output_array["error"]  = "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $output_array["success"] = "false";
            // $output_array["error"] = "SQL: " . $sql . "Err" . $conn->error;
        }
// }

}
$conn->close();
echo json_encode($output_array,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
?>