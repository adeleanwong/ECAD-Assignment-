<?php 
//loading library required for PHPMailer
require 'PHPMailer-master/PHPMailerAutoload.php'; 
define('GUSER', 'johndounut1@gmail.com'); // GMail username to access SMTP mail server
define('GPWD', 'password@12345!'); // GMail password to access SMTP mail server

function smtpmailer($to, $from, $from_name, $subject, $body) { 
	global $error;
	$mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0;  // debugging: 1 = message from client, 
	                       // 2 = message from client and response from server
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	//$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = 'smtp.gmail.com';
	//$mail->Port = 587; // use port 587 for TLS
	$mail->Port = 465; // use port 465 for SSL
	$mail->Username = GUSER;  
	$mail->Password = GPWD;           
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->IsHTML(true); // Use HTML to format the body content
	$mail->AddAddress($to);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}
}
?>