<?php 

$path = $_SERVER['DOCUMENT_ROOT'] . '/clase/appbar/';
include( $path."model/connect.php");
    
class DAOHome{

    function get_prods_random($limit){

        $conn = conn();

        $sql = "SELECT p.cod_prod, p.name, p.img
                FROM productos p LEFT JOIN (
                    SELECT v.id_prod, COUNT(v.id) veces
                    FROM visitas_prod v
                    GROUP BY v.id_prod
                ) k
                ON p.cod_prod = k.id_prod
                ORDER BY k.veces DESC, RAND() 
                LIMIT $limit
            ";

        $result = $conn -> query($sql);

        $return = get_array($result);

        $conn -> close();

        return $return;
    }

    function get_categories(){
        
        $conn = conn();

        $sql = "SELECT * FROM categorias LIMIT 4";

        $result = $conn -> query($sql);

        $return = get_array($result);

        $conn -> close();

        return $return;
    }
}

?>