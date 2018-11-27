<?php
include 'config.php';
// ini_set('display_errors', 1);
$servername = $config['DB_HOST'];
$username = $config['DB_USERNAME'];
$password = $config['DB_PASSWORD'];
$dbname = $config['DB_DATABASE'];


$uemail = $_POST['userEmail'];

// $upass = $_POST['userPassword'];
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$output_array = array(); 

        $sql = "SELECT * from users WHERE email = '".$uemail."'";

        if ($res = $conn->query($sql)) {
            if($res->num_rows > 0){
                $row = $res->fetch_array();
                
                $rname = $row['name'];
                $remail = $row['email'];
                $ruid = $row['uid'];
                $rpass = $row['password'];

                $from = 'pishang7@gmail.com';

                // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                
                // Create email headers
                $headers .= 'From: '.$from."\r\n".
                    'Reply-To: '.$from."\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                $message = '<html>

                <head><title> Forgot Password - ClipSync </title></head><body><div>
                <div>Your <a title="ClipSync" href="http://clipsync.pishangujeniya.com" target="_blank" rel="noopener"><strong>ClipSync</strong></a> credentials are requested and here are those</div>
                <div><em>(Ignore if you did not request but do not share this information)</em></div>
                <div>&nbsp;</div>
                <div>Your details are :</div>
                <div>&nbsp;</div>
                <div>Your <strong>Name</strong> : '.$rname. '</div>
                <div>Your <span style="color: #339966;"><strong>email</strong> </span>id : '.$remail. '</div>
                <div>Your <span style="color: #ff0000;"><strong>password</strong></span> is : '.$rpass. '</div>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <div>END of EMAIL</div>
                <div>&nbsp;</div>
                <div>Contact More :</div>
                <div>&nbsp;</div>
                <div><a title="ClipSync" href="http://clipsync.pishangujeniya.com" target="_blank" rel="noopener">http://clipsync.pishangujeniya.com</a></div>
                </div></body>

                </html>';


                

                if(mail($remail,'ClipSync Password Request',$message,$headers)){
                    $output_array['info'] = "Your details are sent to the registered email id \n Please CHECK YOUR SPAM FOLDER TOO";
                    $output_array["success"] = "true";
                  }
              else{
                $output_array['info_2'] = "Got the user but mailing failed";
                $output_array["success"] = "false";
                  }
                  
            }else{
                $output_array["success"] = "false";
            }
        } else {
            $output_array["success"] = "false";
            $output_array["error"]  = "Error: " . $sql . " ERROR :" . $conn->error;
        }


echo json_encode($output_array,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
$conn->close();
?>