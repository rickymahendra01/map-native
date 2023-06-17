<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

function send_mail($dest,$attc,$subject, $body, $altBody){
	// setting
	$mail = new PHPMailer();
        $mail->IsSMTP();  
        $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
        $mail->SMTPSecure = "tls"; 
	$mail->Host     = "smtp.gmail.com"; 
        $mail->Port       = '587';  
	$mail->SMTPAuth = TRUE;     
        $mail->SMTPKeepAlive = true;
	$mail->Username = "ppgt.mail@gmail.com";  
	$mail->Password = "ppgt@2022"; 
        $mail->CharSet  = "utf-8";  
        $mail->SMTPDebug  = 0;  

	$mail->From     = "ppgt.mail@gmail.com";
	$mail->FromName = "Persekutuan Pemuda Gereja Toraja";

	$arr_dest = explode(",",$dest);
	$jml = count($arr_dest);
	for ($i=0;$i<=$jml-1;$i++)
	{
		$mail->AddAddress($arr_dest[$i]);
	}

	$mail->AddReplyTo("ppgt.mail@gmail.com");

	$arr_attc = explode(",",$attc);
	$mail->WordWrap = 0;     
	$jml2 = count($arr_attc);
	for ($j=0;$j<=$jml2-1;$j++)
	{
		$attacment = $arr_attc[$j];
		$mail->AddAttachment($attacment);
	}
        
	$mail->IsHTML(true);          

	$mail->Subject  =  $subject;
	$mail->Body     =  $body;
	$mail->AltBody  =  "Persekutuan Pemuda Gereja Toraja";

	if(!$mail->Send()){
            return FALSE;
	}else{
	    return TRUE;
	}
}