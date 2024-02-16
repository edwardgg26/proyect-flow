<?php 
namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;

class Email{

    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token){
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }   

    public function enviarConfirmacion(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '64949fe3d42882';
        $mail->Password = '1c217a6a0a8127';

        $mail->setFrom("cuentas@proyectflow.com");
        $mail->addAddress($this->email);
        $mail->Subject = "ProyectFlow | Confirma tu Cuenta";
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";

        $contenido = "<html>";
        $contenido .= "<p>Hola <strong>".$this->nombre."</strong>, para confirmar tu cuenta en ProyectFlow haz click en el siguiente enlace.</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/confirmar-cuenta?token=".$this->token."'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si no creaste una cuenta puedes ignorar este mensaje.</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        $mail->send();
    }

    public function enviarReestablecimiento(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '64949fe3d42882';
        $mail->Password = '1c217a6a0a8127';

        $mail->setFrom("cuentas@proyectflow.com");
        $mail->addAddress($this->email);
        $mail->Subject = "ProyectFlow | Reestablecimiento de Contraseña";
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";

        $contenido = "<html>";
        $contenido .= "<p>Hola <strong>".$this->nombre."</strong>, para reestablecer tu contraseña en ProyectFlow haz click en el siguiente enlace.</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/reestablecer-password?token=".$this->token."'>Reestablecer Contraseña</a></p>";
        $contenido .= "<p>Si no solicitaste el reestablecimiento puedes ignorar este mensaje.</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        $mail->send();
    }

}
?>