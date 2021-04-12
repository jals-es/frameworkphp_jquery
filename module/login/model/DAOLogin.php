<?php 

$path = $_SERVER['DOCUMENT_ROOT'] . '/clase/appbar/';
include( $path."model/connect.php");
include( $path."model/credentials.php");
include( $path."module/general/model/jwt/middleware.php");
include( $path."module/login/model/validate.php");
    
class DAOLogin{

    function register_user($user, $pass, $rpass, $email){

        $validate = validate($user, $pass, $rpass, $email);

        if($validate[0] === true){

            global $secret;
            $pwd_secret = hash_hmac("sha256", $pass, $secret);
            $pwd_hash = password_hash($pwd_secret, PASSWORD_DEFAULT);

            $avatar = get_gravatar($email, 80, 'mp', 'g');

            $conn = conn();

            $sql = "INSERT INTO users VALUES (NULL, '$user', '$pwd_hash', '$email', '$avatar', '1')";

            $result = $conn -> query($sql);

            $conn -> close();

            if($result){
                return true;
            }else{
                return "error";
            }
            
        }else{
            return $validate;
        }
        
    }

    function check_user_by_username($user){
        $conn = conn();

        $sql = "SELECT * FROM users WHERE user='$user'";

        $result = $conn -> query($sql);

        $conn -> close();

        if($result -> num_rows === 0){
            return true;
        }
        return false;
    }

    function check_user_by_email($email){
        $conn = conn();

        $sql = "SELECT * FROM users WHERE email='$email'";

        $result = $conn -> query($sql);

        $conn -> close();

        if($result -> num_rows === 0){
            return true;
        }
        return false;
    }

    function login($user, $pass){
        $val = validate_log($user, $pass);

        if($val){
            
            global $secret;
            $pwd_secret = hash_hmac("sha256", $pass, $secret);

            //comprobamos el usuario y sacamos su id
            $conn = conn();

            $sql = "SELECT id, pass FROM users WHERE user='$user'";

            $result = $conn -> query($sql);

            $conn -> close();

            if($result -> num_rows > 0){
                $user = $result -> fetch_assoc();

                if(password_verify($pwd_secret, $user['pass'])){

                    return jwt_encode($user['id']);

                }
            }
        }
        return "error";
    }
}

?>