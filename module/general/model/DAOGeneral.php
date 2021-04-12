<?php 

$path = $_SERVER['DOCUMENT_ROOT'] . '/clase/appbar/';
include( $path."module/general/model/jwt/middleware.php" );
include( $path."model/connect.php");
    
class DAOGeneral{

    function get_locales(){

        $conn = conn();

        $sql = "SELECT * FROM locales";

        $result = $conn -> query($sql);

        $return = get_array($result);

        $conn -> close();

        return $return;
    }

    function search($search){

        $conn = conn();

        // $sql = "SELECT name, precio FROM productos WHERE name LIKE '%$search%' OR descripcion LIKE '%$search%' LIMIT 8";

        $sql = "SELECT p.cod_prod, p.name, p.precio
                FROM productos p LEFT JOIN (
                    SELECT v.id_prod, COUNT(v.id) veces
                    FROM visitas_prod v
                    GROUP BY v.id_prod
                ) k
                ON p.cod_prod = k.id_prod
                WHERE p.name LIKE '%$search%' OR p.descripcion LIKE '%$search%'
                ORDER BY k.veces DESC, RAND() 
                LIMIT 8";

        $result = $conn -> query($sql);

        $return = get_array($result);

        $conn -> close();

        return $return;
    }

    function checksession($token){
        
        $data = jwt_decode($token);
        if($data){
            //El token es valido
            $id_user = $data -> name;

            $conn = conn();

            $sql = "SELECT * FROM users WHERE id='$id_user'";

            $result = $conn->query($sql);

            $conn -> close();

            if($result -> num_rows > 0){
                //El usuario existe
                $user = $result->fetch_assoc();

                if($user['estado'] == 1){
                    //El usuario está activo
                    return $data;
                }
            }
        }
        return false;

    }
}

?>