<?php 
function generateRandomString($length) { 
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length); 
} 

function random_img($type){
    $rand = rand(0,1);
    if($rand == 0){
        $img = $type.".jpg";
    }else{
        $img = $type."2.jpg";
    }

    return $img;
}

if(isset($_GET['n'])){
    $numero = $_GET['n'];
}else{
    $numero = 5;
}

$cadena = "";
for($i = 0; $i < $numero; $i++){
    if($i == 0){
        $cadena .= "(NULL, '".generateRandomString(10)."', '".generateRandomString(30)."', 'hamburguesa', 'normal:queso', '".rand(1,10)."', '1', '".random_img("hamburguesa")."')";
    }else if($i % 2 == 0){
        //Hamburguesa
        $cadena .= ", (NULL, '".generateRandomString(10)."', '".generateRandomString(30)."', 'hamburguesa', 'normal:queso', '".rand(1,10)."', '1', '".random_img("hamburguesa")."')";
    }else{
        //Pizza
        $cadena .= ", (NULL, '".generateRandomString(10)."', '".generateRandomString(30)."', 'pizza', 'normal:queso', '".rand(1,10)."', '1', '".random_img("pizza")."')";
    }
}

include("../model/connect.php");

$conn = conn();

$sql = "INSERT INTO productos VALUES ".$cadena;

$result = $conn -> query($sql);

$conn -> close();

if($result){
    echo "$i productos creados";
}else{
    echo "error";
}

echo "<br><br><a href='../'>VOLVER</a>";

?>