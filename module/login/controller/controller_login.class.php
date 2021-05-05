<?php

class controller_login{
    function list(){
        common::loadView(VIEW_PATH_LOGIN, 'login.html');
    }
    function log(){
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        if(isset($user) && isset($pass)){

            $check_user = common::accessModel('login_model', 'check_by_user', [$user]);
            if(isset($check_user[0])){
                $ini_file = parse_ini_file(MODEL_PATH.'credentials.ini');
                $secret = $ini_file['secret'];

                $pwd_secret = hash_hmac("sha256", $pass, $secret);

                if(password_verify($pwd_secret, $check_user[0]['pass'])){
                    if($check_user[0]['estado'] == 1){
                        //Usuario correcto, sacamos JWT
                        require JWT_PATH . 'middleware.php';

                        $token = jwt_encode($check_user[0]['id']);

                        $return['type'] = "success";
                        $return['msg'] = "Bienvenido ".$check_user[0]['user'];
                        $return['data'] = $token;

                    }else{
                        $return['type'] = "error";
                        $return['msg'] = "Correo no verificado.";
                    }
                }else{
                    $return['type'] = "error";
                    $return['msg'] = "Usuario o contraseña incorrectos";
                }
                
            }else{
                $return['type'] = "error";
                $return['msg'] = "Usuario o contraseña incorrectos";
            }
        }else{
            $return['type'] = "error";
            $return['msg'] = "Necesitas usuario y contraseña para iniciar sesión";            
        }

        echo json_encode($return);
    }
    function reg(){
        $user = $_POST["user"]; 
        $pass = $_POST["pass"];
        $rpass = $_POST["rpass"]; 
        $email = $_POST["email"];

        // $user = "jals"; 
        // $pass = "@H8899hola";
        // $rpass = "@H8899hola"; 
        // $email = "juan.antonio.lis@gmail.com";

        if(isset($user) && isset($pass) && isset($rpass) && isset($email)){
            $return = common::accessModel('login_validate', 'validate', [$user, $pass, $rpass, $email]); //Retorna error si la validación falla, o si es todo correcto retorna la url del gravatar
            if($return[0] !== "error"){
                $gravatar = $return[0];

                $ini_file = parse_ini_file(MODEL_PATH.'credentials.ini');
                $secret = $ini_file['secret'];

                $pwd_secret = hash_hmac("sha256", $pass, $secret);
                $pwd_hash = password_hash($pwd_secret, PASSWORD_DEFAULT);

                $fecha = time();
                $rand = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
                $id_user = hash_hmac("sha256", $fecha . "_" . $rand, $secret);

                $register = common::accessModel('login_model', 'register_user', [$id_user, $user, $pwd_hash, $email, $gravatar, 0]); //Registra el usuario y si es todo correcto retorna el id de usuario
                // echo "register " . $register;
                if($register){

                    $fecha_email = time() + (60*60*24);
                    $rand_email = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
                    $token_email = hash_hmac("sha256", $fecha_email . "_" . $rand_email, $secret);

                    $insert_token_email = common::accessModel('login_model', 'set_token_email', [$id_user, $token_email]); //Inserta el token

                    // echo "token email " . $insert_token_email;

                    $url_token_email = SITE_PATH."login/verify/".$token_email;

                    if($insert_token_email){

                        require_once(UTILS.'PHPMailer/config.php');

                        $mail->ClearAllRecipients();

                        $mail->AddAddress($email);

                        $mail->IsHTML(true);  //podemos activar o desactivar HTML en mensaje
                        $mail->Subject = "Verificación correo FrameworkPHP";

                        $msg = "<h1>Bienvenido a Nuestro Restaurante</h1><br>";
                        $msg .= "<p>Necesitamos verificar su correo electrónico.</p><br>";
                        $msg .= "Por favor, pulse <a href='".$url_token_email."'>AQUÍ</a> para verificar su correo electrónico.";

                        $mail->Body    = $msg;
                        $mail->Send();

                        if($mail -> ErrorInfo === ""){
                            
                            $return[0] = "true";
                        }else{
                            $return[0] = "error";
                        }
                    }else{
                        $return[0] = "error";
                    }
                }else{
                    $return[0] = "error";
                }
                
            }
        }else{
            $return[0] = "error";
            $return[1]["user"] = " * El usuario ya existe o es incorrecto.";
            $return[1]["pass"] = " * Contraseñas incorrectas o no coinciden.";
            $return[1]["email"] = " * El email ya existe o es incorrecto.";
        }
        echo json_encode($return);
    }
    function verify(){
        
        $return['return'] = "false";
        if(isset($_GET['param']) && !empty($_GET['param'])){
            $token = $_GET['param'];
            // echo $token;

            $check_token = common::accessModel('login_model', 'check_token', [$token]) -> getResolve();
            // print_r($check_token);
            if($check_token){
                if($check_token[0]['expire'] > time()){
                    // echo "verificado";
                    $user_id = $check_token[0]['id_user'];
                    $update_user = common::accessModel('login_model', 'verify_user', [$user_id]);
                    // echo $update_user;
                    if($update_user){
                        if(common::accessModel('login_model', 'delete_token', [$token])){
                            $return['return'] = "true";
                            $return['type'] = "true";
                            $return['msg'] = "Usuario verificado correctamente.";
                        }else{
                            common::loadError();
                        }
                    }else{
                        common::loadError();
                    }
                }else{
                    //Expirado
                    if(common::accessModel('login_model', 'delete_token', [$token])){
                        $return['return'] = "true";
                        $return['type'] = "error";
                        $return['msg'] = "El enlace para verificar el correo ha expirado (Duración máxima 1 día).";
                    }else{
                        common::loadError();
                    }
                }
            }else{
                common::loadError();
            }
        }else{
            common::loadError();
        }
        if($return['return'] === "true"){
            echo "<script>localStorage.removeItem('login_page'); sessionStorage.setItem('val_return','".json_encode($return)."');</script>";
            common::loadView(VIEW_PATH_LOGIN, 'login.html');
        }else{
            common::loadError();
        }
    }

    function social(){
        if(isset($_POST['uid']) && isset($_POST['user']) && isset($_POST['email']) && isset($_POST['avatar'])){
            
            $uid = $_POST['uid'];
            $username = $_POST['user'];
            $email = $_POST['email'];
            $avatar = $_POST['avatar'];

            $return['type'] = "error";

            $check_user = common::accessModel('login_model', 'check_social_user', [$uid]);
            
            if($check_user -> num_rows == 0){
                // El usuario existe
                
                $register = common::accessModel('login_model', 'register_user', [$uid, $username, NULL, $email, $avatar, 1]);

                if($register){
                    $return['type'] = "success";
                }else{
                    $return['type'] = "error";
                    $return['msg'] = "No se ha podido registrar a ".$username;
                }
            }else{
                $return['type'] = "success";
            }

            if($return['type'] === "success"){
                
                require JWT_PATH . 'middleware.php';

                $token = jwt_encode($uid);

                $return['msg'] = "Bienvenido ".$username;
                $return['data'] = $token;
            }

            echo json_encode($return);
        }   
    }
}