<?php 
$path = $_SERVER['DOCUMENT_ROOT'] . '/clase/appbar/';
include($path . "module/general/model/DAOGeneral.php");


if(isset($_GET['op'])){
    switch($_GET['op']){
        case "locales":
            try{
                $dao = new DAOGeneral();
                $rdao = $dao -> get_locales();
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
        case "search":
            $rdao = false;
            if(isset($_POST['search'])){
                try{
                    $dao = new DAOGeneral();
                    $rdao = $dao -> search($_POST['search']);
                }catch(Exception $e){
                    $callback = '?page=503';
                    die('<script>window.location.href="'.$callback .'";</script>');
                }
            }
            if($rdao){
                echo json_encode($rdao);
            }else{
                echo "error";
            }
            break;

        case "checksession":
            $rdao = false;

            //correcto
            $token = $_POST['token'];
            
            //prueba
            // $token = "eyJ0eXAiOiJKV1QiLCAiYWxnIjoiSFMyNTYifQ.eyJpYXQiOiAiMTYxNjYxMDk5OCIsImV4cCI6ICIxNjE2NjE0NTk4IiwibmFtZSI6ICIkaWRVc2VyIn0.1a_GpnyxFKrbYn_HwAw6wlQaFGTW9SJrYCQPaB7gsls";
            if(isset($token)){
                try{
                    $dao = new DAOGeneral();
                    $rdao = $dao -> checksession($token);
                }catch(Exception $e){
                    $callback = '?page=503';
                    die('<script>window.location.href="'.$callback .'";</script>');
                }
            }
            if($rdao){
                echo "true";
            }else{
                echo "error";
            }
            break;

        default:
            include('view/inc/error404.php');
            break;
    }
}else{
    include('module/inicio/view/inicio.html');
}
?>