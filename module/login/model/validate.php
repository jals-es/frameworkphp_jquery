<?php 

function v_user($user){
    $path = "/^[a-zA-Z]+$/";
    if(preg_match($path, $user)){
        try{
            $dao = new DAOLogin();
            $rdao = $dao -> check_user_by_username($user);
        }catch(Exception $e){
            return false;
        }

        if($rdao){
            return true;
        }
    }
    return false;
}


function v_o_user($user){
    $path = "/^[a-zA-Z]+$/";
    if(preg_match($path, $user)){
        return true;
    }
    return false;
}

function v_pass($pass, $rpass){
    $path = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/";
    if(preg_match($path, $pass)){
        if($pass === $rpass){
            return true;
        }
    }
    return false;
}

function v_o_pass($pass){
    $path = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/";
    if(preg_match($path, $pass)){
        return true;
    }
    return false;
}

function v_email($email){
    $path = "/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/";
    if(preg_match($path, $email)){
        try{
            $dao = new DAOLogin();
            $rdao = $dao -> check_user_by_email($email);
        }catch(Exception $e){
            return false;
        }

        if($rdao){
            return true;
        }
    }
    return false;
}

function validate($user, $pass, $rpass, $email){
    $v_user = v_user($user);
    $v_pass = v_pass($pass, $rpass);
    $v_email = v_email($email);

    $return[0] = true;
    if(!$v_user){
        $return[1]["user"] = " * El usuario ya existe o es incorrecto.";
        $return[0] = "error";
    }
    if(!$v_pass){
        $return[1]["pass"] = " * Contraseñas incorrectas o no coinciden.";
        $return[0] = "error";
    }
    if(!$v_email){
        $return[1]["email"] = " * El email ya existe o es incorrecto.";
        $return[0] = "error";
    }
    return $return;
}

function validate_log($user, $pass){
    $v_user = v_o_user($user);
    $v_pass = v_o_pass($pass);

    if($v_user && $v_pass){
        return true;
    }
    return false;
}

function get_gravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

?>