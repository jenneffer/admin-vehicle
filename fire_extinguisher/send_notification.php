<?php 
// ========== MAIL CONFIGURATION ========== //
// initialize phpmailer class
require '../assets/PHPMailer/PHPMailerAutoload.php';
require_once('../assets/config/database.php');
require_once('../function.php');
global $conn_admin_db;

/* ------ Set up OUTLOOK configuration ------  */
$mail = new PHPMailer;

$mail->isSMTP();
$mail->Host = 'mail.engpeng.com.my';
$mail->SMTPAuth = true;
$mail->Username = 'notification@engpeng.com.my'; // sender mail  // notification
$mail->Password = 'N0+!fic@tion'; // sender mail    // 'N0+!fic@tion
$mail->SMTPSecure = 'None';
$mail->Port = 587;

$mail->setFrom('notification@engpeng.com.my', 'Attendance Notification');
$mail->addReplyTo('notification@engpeng.com.my', 'Attendance Notification');

$today = date( 'Y-m-d' );
$upcoming_renewal = date( 'Y-m-d', strtotime( "+30 days" ) );
//get the data of upcoming fire extinguisher renewal

$query = "SELECT * FROM fe_master_listing fli
        INNER JOIN fe_location flo ON flo.location_id = fli.location
        INNER JOIN company c ON c.id = fli.company_id        
        WHERE expiry_date BETWEEN '".$today."' AND '".$upcoming_renewal."'";

$rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
if ( mysqli_num_rows($rst) > 0 ){
    $data = array();
    while( $row = mysqli_fetch_assoc( $rst ) ){        
        $email = $row['cr_email'];        
        $data[$email][] = $row;
    }
    
    foreach ($data as $cr_email => $fe_data){
        $str_fe_data = [];
        foreach ($fe_data as $d){
            $name = $d['cr_name'];
            $str_fe_data[] = "<a>".$d['serial_no']."</a>";
        }
        $str_fe_data = implode("<br/>", $str_fe_data);
        $mail->addAddress($cr_email); 
        $mail->Subject = 'Fire Extinguisher Upcoming Renewal';
        $mail->isHTML(true);
        $mail->Body = $str_fe_data;
        /*			*/
        if ($mail->send()) {
            ?><script>alert("email sent!");</script><?php
			} else {
				?><script>alert("Email NOT send.")</script><?php
			}
        
    }
}

//send email and register to db for email sent


//register sent email to db

?>