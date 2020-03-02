<?php // email configuration
	// ========== MAIL CONFIGURATION ========== //
	// initialize phpmailer class
	require 'assets/PHPMailer/PHPMailerAutoload.php';
	
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
	

$fai = "Testing, Aaron sangat hensem!";
$mail->addAddress('jenneffer.jiminit@engpeng.com.my'); 
			//
			
			$mail->Subject = 'Late In List';
			$mail->isHTML(true);
			$mail->Body = $fai; 
			/*			*/
			if ($mail->send()) {
				?><script>alert("email sent!");</script><?php
			} else {
				?><script>alert("Email NOT send.")</script><?php
			}

?>