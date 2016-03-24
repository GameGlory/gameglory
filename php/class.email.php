<?php
require_once("../phpmailer/class.phpmailer.php");

class EMail{
	
	private $sender = null;
	private $receiver = null;
	
	public function __construct($sender , $receiver){
		
			$this->sender = $sender;
			$this->receiver = $receiver;
			
	}
		 public function sendEmail($subject,$message){
		
				$mail = new PHPMailer;

$mail->IsSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Port = 587;
$mail->Username = 'bennydorlisme@gaming-for-glory.com';                            // SMTP username
$mail->Password = 'Rakande101';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

$mail->From = $this->sender;
$mail->FromName = 'GameGlory';
$mail->AddAddress($this->receiver);  // Add a recipient
//$mail->AddAddress('ellen@example.com');               // Name is optional
//$mail->AddReplyTo('info@example.com', 'Information');
//$mail->AddCC('cc@example.com');
//$mail->AddBCC('bcc@example.com');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->AddAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->AddAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->IsHTML(true);                                  // Set email format to HTML

$mail->Subject = $subject;
$mail->Body    = $message;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->Send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
		}
}
}
?>