<?php

require APPPATH.'third_party/PHPMailer/PHPMailerAutoload.php';
include APPPATH.'third_party/config_mail.php';

class MailModel extends CI_Model {
	
	/*function __construct()
	{   

	}*/

	/**
	 * Returns one user
	 */
	public function enviarCorreoRegistro($email) {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        
        //Configuracion servidor mail
        $mail->From = MAILFROM; //remitente
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = SECURITY; //seguridad
        $mail->Host = HOST; // servidor smtp
        $mail->Port = PORT; //puerto
        $mail->Username = USERNAME; //nombre usuario
        $mail->Password = PASSWORD; //contraseña

        $mail->AddAddress($email);
        $mail->IsHTML(true);
        $mail->Subject = SUBJECT;
        $md5email = md5($email);
        $mail->Body = BODY."<br><br><a href='http://127.0.0.1/Frontend/index.php/Registro/activacion/".$md5email."'>Verificar Cuenta Aquí</a><br><br>".FOOTERMAIL;
        return $mail->Send();
    }
}