<?php 
$path = $_SERVER['DOCUMENT_ROOT'] . '/clase/appbar/';
include( $path."model/credentials.php");
require_once "JWT.php";

function jwt_encode($idUser){
    $header = '{"typ":"JWT", "alg":"HS256"}';
    global $secretJWT;
    $payload = '{"iat": "'.time().'","exp": "'.time() + (60*60).'","name": "'.$idUser.'"}';

    $JWT = new JWT;
    $token = $JWT->encode($header, $payload, $secretJWT);

    return $token;
}

function jwt_decode($token){
    
    global $secretJWT;

    $JWT = new JWT;
    $json = $JWT->decode($token, $secretJWT);

    $data = json_decode($json);

    if($data -> exp > time()){
        return $data;
    }
    return false;
}

?>