<?php 


function validate_name($name){
    if(isset($name) || !empty($name)){

        $daoprod = new DAOProd();
        
        $rdo = $daoprod->get_prod_by_name($name);

        $row = $rdo -> fetch_assoc();

        if(!isset($row['name']) || isset($_POST['update'])){
            //echo "<script>console.log('name true');</script>";
            return true;
        }
    }
    return false;
}

function validate_descripcion($descripcion){
    if(isset($descripcion) || !empty($descripcion)){
        //echo "<script>console.log('descripcion true');</script>";
        return true;
    }
    return false;
}

function validate_tipo($tipo){
    if($tipo === "hamburguesa" || $tipo === "pizza"){
        //echo "<script>console.log('tipo true');</script>";
        return true;
    }
    return false;
}

function validate_pan($pan){
    if(isset($pan) || !empty($pan)){
        //echo "<script>console.log('pan true');</script>";
        return true;
    }
    return false;
}

function validate_content($content){
    if(isset($content) || !empty($content)){
        //echo "<script>console.log('content true');</script>";
        return true;
    }
    return false;
}

function validate_price($tipo){
    if($tipo === "hamburguesa"){
        $precio = 5;
    }else if($tipo === "pizza"){
        $precio = 10;
    }
    //echo "<script>console.log('price ".$precio."');</script>";
    return $precio;
}

///function validate(){
    $check = true;

    $v_name = validate_name($_POST['name']);
    $v_descripcion = validate_descripcion($_POST['descripcion']);
    $v_tipo = validate_tipo($_POST['tipo']);
    $v_pan = validate_pan($_POST['pan']);
    $v_content = validate_content($_POST['content']);
    $_POST['price'] = validate_price($_POST['tipo']);

    if(!$v_name){
        $error_name = " * El nombre ya existe.";
        $check = false;
    }
    if(!$v_descripcion){
        $error_descripcion = " * La descripción no puede estar vacía.";
        $check = false;
    }
    if(!$v_tipo){
        $error_tipo = " * Error con el tipo de producto."; 
        $check = false;
    }
    $error_ingredientes = "";
    if(!$v_pan){
        $error_ingredientes .= " * Selecciona uno de los 3 tipos de pan/masa disponibles.<br>";
        $check = false;
    }
    if(!$v_content){
        $error_ingredientes .= " * Selecciona almenos 1 ingrediente.";
        $check = false;
    }
    if($_POST['price'] <= 0){
        $error_precio = " * Error con el precio.";
        $check = false;
    }
    //return $check;
//}

?>