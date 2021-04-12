<?php 
$path = $_SERVER['DOCUMENT_ROOT'] . '/clase/appbar/';
include($path . "module/login/model/DAOLogin.php");


if(isset($_GET['op'])){
    switch($_GET['op']){
        case "reg":
            try{
                $dao = new DAOLogin();
                $rdao = $dao -> register_user($_POST["user"], $_POST["pass"], $_POST["rpass"], $_POST["email"]);
            }catch(Exception $e){
                $callback = '?page=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }

            if($rdao){
                echo json_encode($rdao);
            }else{
                echo json_encode($rdao);
            }

            break;

        case "log":

            $user = $_POST["user"];
            $pass = $_POST["pass"];

            try{
                $dao = new DAOLogin();
                $rdao = $dao -> login($user, $pass);
            }catch(Exception $e){
                $callback = '?page=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }

            if($rdao){
                echo json_encode($rdao);
            }else{
                echo "error";
            }

            break;
        default:
            include('view/inc/error404.php');
            break;
    }
}
?>