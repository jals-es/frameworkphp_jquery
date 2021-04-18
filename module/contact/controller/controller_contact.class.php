<?php 

class controller_contact{
    function list(){
        common::loadView(VIEW_PATH_CONTACT, 'contact.html');
    }

    function send_email(){
        $email_cli = $_POST['email'];
        $nombre = $_POST['name'];

        require_once(UTILS.'PHPMailer/config.php');

        $mail->ClearAllRecipients( );

        $mail->AddAddress("juan.antonio.lis@gmail.com");

        $mail->IsHTML(true);  //podemos activar o desactivar HTML en mensaje
        $mail->Subject = "Mensaje enviado desde el modulo de contact en frameworkphp";

        $msg = "<h1>Mensaje de $nombre ($email_cli):</h1><br>" . $_POST['text'];

        $mail->Body    = $msg;
        $mail->Send();

        if($mail -> ErrorInfo === ""){
            echo true;
        }else{
            echo false;
        }
    }
}