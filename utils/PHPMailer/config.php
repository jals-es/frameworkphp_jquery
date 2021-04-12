<?php

/*
*
* Endeos, Working for You
* blog.endeos.com
*
*/

require_once('PHPMailerAutoload.php');


$mail = new PHPMailer;

//$mail->SMTPDebug    = 3;

$mail->IsSMTP();
$mail->Host = 'smtp.ionos.es';   /*Servidor SMTP*/																		
$mail->SMTPSecure = 'TLS';   /*Protocolo SSL o TLS*/
$mail->Port = 587;   /*Puerto de conexión al servidor SMTP*/
$mail->SMTPAuth = true;   /*Para habilitar o deshabilitar la autenticación*/
$mail->Username = 'admin@webforshops.com';   /*Usuario, normalmente el correo electrónico*/
$mail->Password = '@Webforshops123';   /*Tu contraseña*/
$mail->From = 'admin@webforshops.com';   /*Correo electrónico que estamos autenticando*/
$mail->FromName = 'Admin Webforshops';   /*Puedes poner tu nombre, el de tu empresa, nombre de tu web, etc.*/
$mail->CharSet = 'UTF-8';   /*Codificación del mensaje*/

?>