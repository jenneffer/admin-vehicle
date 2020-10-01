<?php 
// ========== MAIL CONFIGURATION ========== //
// initialize phpmailer class
require '../assets/PHPMailer/PHPMailerAutoload.php';
require_once('../assets/config/database.php');
require_once('../function.php');
global $conn_admin_db;
session_start();

/* ------ Set up OUTLOOK configuration ------  */
$mail = new PHPMailer;

$mail->isSMTP();
$mail->Host = 'mail.engpeng.com.my';
$mail->SMTPAuth = true;
$mail->Username = 'notification@engpeng.com.my'; // sender mail  // notification
$mail->Password = 'N0+!fic@tion'; // sender mail    // 'N0+!fic@tion
$mail->SMTPSecure = 'None';
$mail->Port = 587;

$mail->setFrom('notification@engpeng.com.my', 'Fire Extinguisher Renewal Notification');
$mail->addReplyTo('notification@engpeng.com.my', 'Fire Extinguisher Renewal Notification');

$today = date( 'Y-m-d' );
$upcoming_renewal = date( 'Y-m-d', strtotime( "+30 days" ) );
//get the data of upcoming fire extinguisher renewal

$query = "SELECT * FROM fe_master_listing fli
        INNER JOIN fe_location flo ON flo.location_id = fli.location_id
        INNER JOIN company c ON c.id = fli.company_id        
        WHERE expiry_date BETWEEN '".$today."' AND '".$upcoming_renewal."'";

$rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
if ( mysqli_num_rows($rst) > 0 ){
    $data = array();
    while( $row = mysqli_fetch_assoc( $rst ) ){            
        $data[] = $row;
    }
    $email_body .= "There's upcoming renewal of fire extinguisher and awaiting for you action. Please login <a href='http://192.168.9.149/admin'>HERE</a> to view the details.<br/>";
    $email_body .= "<br><table width='465' height='150' border='1' style='border-collapse: collapse;padding:12px;'><tr><th>Company</th><th>Location</th><th>Person in charge</th><th>Serial No.</th></tr>";
    foreach ($data as $fe_data){
        $pic = itemName("SELECT pic_name FROM fe_person_incharge WHERE pic_id='".$fe_data['person_incharge_id']."'");
        $email_body .= "<tr>
                            <td>".$fe_data['name']."</td>
                            <td>".$fe_data['location_name']."</td>
                            <td>".$pic."</td>
                            <td>".$fe_data['serial_no']."</td>
                        </tr>";
    }
    $email_body .="</table>";
    $mail->addAddress("jenneffer.jiminit@engpeng.com.my");
    $mail->Subject = 'Fire Extinguisher Upcoming Renewal';
    $mail->isHTML(true);
    $mail->Body = $email_body;
    if ($mail->send()) {
        ?><script>alert("email sent!");</script><?php
	} else {
		?><script>alert("Email NOT send.")</script><?php
	}
}

//send email and register to db for email sent


//register sent email to db

?>