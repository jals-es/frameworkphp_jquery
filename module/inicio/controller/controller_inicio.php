<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/clase/appbar/';
include($path . "module/inicio/model/DAOHome.php");


if(isset($_GET['op'])){
    switch($_GET['op']){
        case "slider":
            try{
                $dao = new DAOHome();
                $rdao = $dao -> get_prods_random(10);
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
        case "categories":
            try {
                $dao = new DAOHome();
                $rdao = $dao -> get_categories();
            } catch (Exception $e) {
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
}else{
    include('module/inicio/view/inicio.html');
}

?>