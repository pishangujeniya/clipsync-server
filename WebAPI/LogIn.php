<?php
include 'config.php';
$servername = $config['DB_HOST'];
$username = $config['DB_USERNAME'];
$password = $config['DB_PASSWORD'];
$dbname = $config['DB_DATABASE'];

$uname = $_POST['userName'];
$uemail = $_POST['userName'];
$upass = $_POST['userPassword'];
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$output_array = array(); 
// if (empty($_POST['userName']) || empty($POST['userPassword']) || empty($_POST['userEmail'])){
//     echo "Khali Requesto Nai Padvani... Honnnn";
// }else{
        $sql = "SELECT uid,name,email from users WHERE password = '".$upass."'";

        if ($res = $conn->query($sql)) {
            if($res->num_rows > 0){
                $row = $res->fetch_array();
                // $row = mysqli_fetch_row($res);
                $rname = $row['name'];
                $remail = $row['email'];
                $ruid = $row['uid'];

                    if($rname == $uname || $remail == $uemail){
                        $output_array["success"] = "true";
                        $output_array["uid"] = $ruid;
                        $output_array["username"] = $rname;
                        $output_array["email"] = $remail;
                    }else{
                        $output_array["success"] = "false";
						$output_array["description"] = "Username Password doesn't match";
                    }
            }else{
                $output_array["success"] = "false";
            }
        } else {
            $output_array["error"]  = "Error: " . $sql . "<br>" . $conn->error;
        }
// }

echo json_encode($output_array,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
$conn->close();
?>