<?php

?><?php

//=========== MAIL SETUP =================
// Include and initialize phpmailer class
require 'PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer;

// SMTP configuration
$mail->isSMTP();
$mail->Host = 'mail.engpeng.com.my';
$mail->SMTPAuth = true;
$mail->Username = 'notification@engpeng.com.my';
$mail->Password = 'N0+!fic@tion';
$mail->SMTPSecure = 'None';
$mail->Port = 587;

$mail->setFrom('notification@engpeng.com.my', 'Attendance Notification');
$mail->addReplyTo('leonizel.bess@engpeng.com.my', 'Attendance Notification');

// Add a recipient
//$mail->addAddress('leonizel.bess@engpeng.com.my');
//$mail->addAddress('HR@engpeng.com.my');

// Add cc or bcc 
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

// Email subject
//$mail->Subject = 'Early Out List';

// Set email format to HTML
$mail->isHTML(true);

// Email body content
$mailContent = '
		<h2>Early Out List for  '.$DateToday.'</h2>
		<table cellpadding=1" cellspacing="0" width="650" border="0" bgcolor="#ffffff">
				<tr>
					<th align="left"></th>
					<th align="left">NAME</th>
					<th align="center">TIME IN</th>
					<th align="center">TIME OUT</th>
					<th align="center">SHORT</th>
					<th align="left">DEPARTMENT</th>
				</tr>';
	$no 	= 1;
	$total 	= 0;
	while ($row = mysqli_fetch_array($query)){		
		$mailContent .= '
				<tr>
					<td>'.$no.'.</td>
					<td>'.$row['Name'].'</td>
					<td align="center">'.$row['att_in'].'</td>
					<td align="center">'.$row['att_out'].'</td>
					<td align="center">'.$row['out_s'].'</td>
					<td>'.$row['gName'].'</td>
				</tr>';
			$no++;
		}
		
$mail->Body = $mailContent.'</table>';

// Send email
if(!$mail->send()){
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}else{
    echo 'Message has been sent';
	header("Location: late-in-early-out-justification-form.php");
}
?>