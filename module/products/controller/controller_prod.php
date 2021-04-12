<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/clase/appbar/';
include($path . "module/products/model/DAOProd.php");
// include("module/products/model/DAOProd.php");

if(isset($_GET['op'])){
    switch($_GET['op']){
        case 'list':
            try{
                $daoprod = new DAOProd();
                $rdo = $daoprod->get_all_prod();
            }catch (Exception $e){
                $callback = '?page=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }
            
            if(!$rdo){
                $callback = '?page=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }else{
                include("module/products/view/list_prod.php");
            }
            break;
        case 'create':
            $check = true;
            
            if (isset($_POST['create'])){
                
                include("module/products/model/validate.php");
        
                if ($check){
                    $_SESSION['prod']=$_POST;
                    try{
                        echo "<script>console.log('entra2');</script>";
                        $daoprod = new DAOProd();
                        $rdo = $daoprod->insert_user($_POST);
                    }catch (Exception $e){
                        $callback = '?page=503';
                        die('<script>window.location.href="'.$callback .'";</script>');
                    }
                    
                    if($rdo){
                        echo '<script language="javascript">alert("Registrado en la base de datos correctamente")</script>';
                        $callback = '?page=controller_prod&op=list';
                        die('<script>window.location.href="'.$callback .'";</script>');
                    }else{
                        $callback = '?page=503';
                        die('<script>window.location.href="'.$callback .'";</script>');
                    }
                }
            }
            
            include("module/products/view/create_prod.php");
            break;
        case 'update':
            
            $check = true;
            
            if (isset($_POST['update'])){
                include("module/products/model/validate.php");
                
                if ($check){
                    $_SESSION['user']=$_POST;
                    try{
                        $daoprod = new DAOProd();
                        $rdo = $daoprod->update_prod($_POST, $_GET['id']);
                    }catch (Exception $e){
                        $callback = '?page=503';
                        die('<script>window.location.href="'.$callback .'";</script>');
                    }
                    
                    if($rdo){
                        echo '<script language="javascript">alert("Actualizado en la base de datos correctamente")</script>';
                        $callback = '?page=controller_prod&op=list';
                        die('<script>window.location.href="'.$callback .'";</script>');
                    }else{
                        $callback = '?page=503';
                        die('<script>window.location.href="'.$callback .'";</script>');
                    }
                }
            }
            
            try{
                $daoprod = new DAOProd();
                $rdo = $daoprod->get_prod_by_cod($_GET['id']);
                $prod= $rdo -> fetch_assoc();
            }catch (Exception $e){
                $callback = '?page=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }
            
            if(!$rdo){
                $callback = '?page=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }else{
                include("module/products/view/update_prod.php");
            }
            break;
        case 'read':
            try{
                $daoprod = new DAOProd();
                $rdo = $daoprod->get_prod_by_cod($_GET['id']);
                $prod = $rdo -> fetch_assoc();
            }catch (Exception $e){
                $callback = '?page=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }
            if(!$rdo){
                $callback = '?page=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }else{
                // include("module/products/view/read_prod.php");
                echo json_encode($prod);
            }
            break;
        case 'delete':
            if (isset($_POST['delete'])){
                try{
                    $daouser = new DAOProd();
                    $rdo = $daouser->delete_prod($_GET['id']);
                }catch (Exception $e){
                    $callback = '?page=503';
                    die('<script>window.location.href="'.$callback .'";</script>');
                }
                
                if($rdo){
                    echo '<script language="javascript">alert("Borrado en la base de datos correctamente")</script>';
                    $callback = '?page=controller_prod&op=list';
                    die('<script>window.location.href="'.$callback .'";</script>');
                }else{
                    $callback = '?page=503';
                    die('<script>window.location.href="'.$callback .'";</script>');
                }
            }
            
            include("module/products/view/delete_prod.php");
            break;
        default;
            include("view/inc/error404.php");
            break;
    }
}else{
    include("view/inc/error404.php");
}

?>