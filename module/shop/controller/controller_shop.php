<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/clase/appbar/';
include($path . "module/shop/model/DAOShop.php");


if(isset($_GET['op'])){
    switch($_GET['op']){
        case "catego":
            if(isset($_GET['id'])){
                try{
                    $dao = new DAOShop();
                    $rdao = $dao -> get_prods_catego($_GET['id']);
                }catch(Exception $e){
                    $callback = '?page=503';
                    die('<script>window.location.href="'.$callback .'";</script>');
                }
    
                if($rdao){
                    echo json_encode($rdao);
                }else{
                    echo "error";
                }
            }else{
                echo "error";
            }

            break;
        case "prod":
            if(isset($_GET['id'])){
                try{
                    $dao = new DAOShop();
                    $rdao = $dao -> get_prod_by_id($_GET['id']);
                }catch(Exception $e){
                    $callback = '?page=503';
                    die('<script>window.location.href="'.$callback .'";</script>');
                }
    
                if($rdao){
                    echo json_encode($rdao);
                }else{
                    echo "error";
                }
            }else{
                echo "error";
            }
            break;
        case "all_prod":
            if(isset($_POST['offset']) && isset($_POST['limit'])){

                $catego = $_POST['catego'];
                $price_min = $_POST['price_min'];
                $price_max = $_POST['price_max'];
                if(!empty($_POST['ingredientes'])){
                    $ingredientes = explode(":", $_POST['ingredientes']);
                }else{
                    $ingredientes = "";
                }
                

                try{
                    $dao = new DAOShop();
                    $rdao = $dao -> get_all_prods($_POST['offset'], $_POST['limit'], $catego, $price_min, $price_max, $ingredientes);
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
        case "visit_prod":
            if(isset($_POST['id_prod'])){

                $id_user = -1;

                try{
                    $dao = new DAOShop();
                    $rdao = $dao -> visit_prod($_POST['id_prod'], $id_user);
                }catch(Exception $e){
                    $callback = '?page=503';
                    die('<script>window.location.href="'.$callback .'";</script>');
                }
            }else{
                $rdao = false;
            }

            if($rdao){
                echo json_encode($rdao);
            }else{
                echo "false";
            }
            break;
        case "get_range_prices":
            try{
                $dao = new DAOShop();
                $rdao = $dao -> get_range_prices();
            }catch(Exception $e){
                $callback = '?page=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }

            if($rdao){
                echo json_encode($rdao);
            }else{
                echo "false";
            }
            break;
        case "search":
            if(isset($_POST['content'])){
                try{
                    $dao = new DAOShop();
                    $rdao = $dao -> search($_POST['content']);
                }catch(Exception $e){
                    $callback = '?page=503';
                    die('<script>window.location.href="'.$callback .'";</script>');
                }
            }else{
                $rdao = false;
            }

            if($rdao){
                echo json_encode($rdao);
            }else{
                echo "error";
            }
            break;
        case "get_catego":
            try{
                $dao = new DAOShop();
                $rdao = $dao -> get_catego();
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
        case "get_ingredientes":
            try{
                $dao = new DAOShop();
                $rdao = $dao -> get_ingredientes();
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
        case "fav":
            $rdao = false;

            if(isset($_POST['token']) && isset($_POST['prod']) && isset($_POST['type'])){
                try{
                    $dao = new DAOShop();
                    $rdao = $dao -> fav($_POST['type'], $_POST['prod'], $_POST['token']);
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
        
        case "get_favs":
            $rdao = false;

            if(isset($_POST['token'])){
                try{
                    $dao = new DAOShop();
                    $rdao = $dao -> get_fav($_POST['token']);
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

        default:
            include('view/inc/error404.php');
            break;
    }
}else{
    
    include('module/shop/view/shop.html');
}

?>