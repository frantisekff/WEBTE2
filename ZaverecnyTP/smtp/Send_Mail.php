<?php
function Send_Mail($to,$subject,$body)
{
    require_once 'class.phpmailer.php';
$from       = "";
$mail       = new PHPMailer();
$mail->IsSMTP(true);            // use SMTP
$mail->IsHTML(true);
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Host       = "tls://smtp.gmail.com"; // Amazon SES server, note "tls://" protocol
$mail->Port       =  465;                    // set the SMTP port
$mail->Username   = "";  // SMTP  username
$mail->Password   = "";  // SMTP password
$mail->SetFrom($from, 'From Me');
$mail->AddReplyTo($from,'From Me');
$mail->Subject    = $subject;
$mail->MsgHTML($body);
$address = $to;
$mail->AddAddress($address, $to);
$mail->Send();
}
?>
