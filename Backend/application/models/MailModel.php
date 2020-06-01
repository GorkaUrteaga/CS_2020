<?php

require APPPATH . 'third_party/PHPMailer/PHPMailerAutoload.php';
include APPPATH . 'third_party/config_mail.php';

class MailModel extends CI_Model
{

    /*function __construct()
	{   

	}*/

    public function enviarCorreo($emailTo, $subject, $body)
    {
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

        $mail->AddAddress($emailTo);
        $mail->IsHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        return $mail->Send();
    }

    /**
     * Returns one user
     */
    public function enviarCorreoRegistro($email)
    {
        $sha1email = sha1($email);
        $body = BODY . "<br><br><a href='" . RUTAACTIVACION . $sha1email . "'>Verificar Cuenta Aquí</a><br><br>" . FOOTERMAIL;
        $subject = SUBJECT;

        return $this->enviarCorreo($email, $subject, $body);
    }

    public function enviarCorreoRecuperarContrasena($email, $codigo)
    {
        $sha1email = sha1($email);
        $body = BODY . "<br><br>CÓDIGO: $codigo<br><br>" . FOOTERMAIL;
        $subject = SUBJECT;

        return $this->enviarCorreo($email, $subject, $body);

    }
}
