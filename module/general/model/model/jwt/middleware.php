<?php 
require_once JWT_PATH."JWT.php";

function jwt_encode($idUser){
    $ini_file = parse_ini_file(MODEL_PATH.'credentials.ini');
    
    $header = '{"typ":"JWT", "alg":"HS256"}';
    $secretJWT = $ini_file['secretJWT'];
    $payload = '{"iat": "'.time().'","exp": "'.time() + (60*60).'","name": "'.$idUser.'"}';

    $JWT = new JWT;
    $token = $JWT->encode($header, $payload, $secretJWT);

    return $token;
}

function jwt_decode($token){
    $ini_file = parse_ini_file(MODEL_PATH.'credentials.ini');

    $secretJWT = $ini_file['secretJWT'];

    $JWT = new JWT;
    $json = $JWT->decode($token, $secretJWT);

    $data = json_decode($json);

    if($data -> exp > time()){
        return $data;
    }
    return false;
}

?>