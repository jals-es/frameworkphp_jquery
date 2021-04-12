<?php 

$path = $_SERVER['DOCUMENT_ROOT'] . '/clase/appbar/';
include( $path."model/connect.php");
include( $path."module/general/model/jwt/middleware.php" );
// include($path . "module/general/model/DAOGeneral.php" );
    
class DAOShop{

    function get_all_prods($offset, $limit, $catego, $price_min, $price_max, $ingredientes){

        $where = false;

        if(empty($catego)){
            $sql_catego = "";
        }else if($catego === "all"){
            $sql_catego = "type LIKE '%%'";
        }else{
            $sql_catego = "type LIKE '%$catego%'";
            $where = true;
        }

        $sql_price = "";
        if(!empty($price_max)){
            $sql_price = "precio BETWEEN $price_min AND $price_max";
            $where = true;
        }
        
        $sentencia = $sql_catego." AND ".$sql_price;
        
        $i = 0;
        $sql_ingredientes = "";
        if(!empty($ingredientes)){
            foreach($ingredientes as $ing){
                if($i == 0){
                    $where = true;
                    $sql_ingredientes = "$sentencia AND ingredientes LIKE '%$ing%'";
                }else{
                    $sql_ingredientes .= " OR $sentencia AND ingredientes LIKE '%$ing%'";
                }
                $i++;
            }
        }

        if($where == true){
            $where = "WHERE $sql_ingredientes";
        }else{
            $where = "";
        }

        $conn = conn();

        $sql = "SELECT * FROM productos $where LIMIT $offset,$limit";
        $sql2 = "SELECT COUNT(*) total FROM productos $where";

        // echo $sql;

        $result = $conn -> query($sql);
        $result2 = $conn -> query($sql2);

        if($result -> num_rows > 0){
            $return = array($result2 -> fetch_assoc());
            $i = 1;
            while($row = $result -> fetch_assoc()){
                $return[$i] = $row;
                $i++;
            }
        }else{
            $return = false;
		}

        $conn -> close();

        return $return;
    }

    function get_prods_catego($catego){

        $conn = conn();

        $sql = "SELECT * FROM productos WHERE type='$catego'";

        $result = $conn -> query($sql);

        $return = get_array($result);

        $conn -> close();

        return $return;
    }

    function get_prod_by_id($id){

        $conn = conn();

        $sql = "SELECT * FROM productos WHERE cod_prod='$id'";

        $result = $conn -> query($sql);

        $return = $result -> fetch_assoc();

        $conn -> close();

        return $return;
    }

    function visit_prod($id_prod, $id_user){

        $ip = $_SERVER["REMOTE_ADDR"];

        $conn = conn();

        $sql = "INSERT INTO visitas_prod VALUES (NULL, $id_user, $id_prod, '$ip')";

        $result = $conn -> query($sql);

        $return = $result;

        $conn -> close();

        return $return;
    }

    function get_range_prices(){

        $conn = conn();

        $sql = "SELECT MIN(precio) min, MAX(precio) max FROM productos";

        $result = $conn -> query($sql);

        $conn -> close();

        $return = $result -> fetch_assoc();

        foreach($return as $index => $valor){
            $decimales = explode(".", $valor);
            if($decimales[1] == 00){
                $return[$index] = round($return[$index]);
            }else if($decimales[1] < 50 && $index === "max"){
                $return[$index] = round($return[$index]) + 1;
            }else if($decimales[1] >= 50 && $index === "max"){
                $return[$index] = round($return[$index]);
            }else if($decimales[1] < 50 && $index === "min"){
                $return[$index] = round($return[$index]);
            }else if($decimales[1] >= 50 && $index === "min"){
                $return[$index] = round($return[$index]) - 1;
            }
        }

        return $return;

    }

    function search($search){

        $conn = conn();

        $sql = "SELECT DISTINCT * FROM productos WHERE name LIKE '%$search%' OR descripcion LIKE '%$search%' ORDER BY type";

        $result = $conn -> query($sql);

        $return = get_array($result);

        $conn -> close();

        return $return;
    }

    function get_catego(){
        $conn = conn();

        $sql = "SELECT c.name, COUNT(p.cod_prod) nprods
                FROM categorias c INNER JOIN productos p
                ON c.name = p.type
                GROUP BY c.name";

        $result = $conn -> query($sql);

        $return = get_array($result);

        $conn -> close();

        return $return;
    }

    function get_ingredientes(){
        $conn = conn();

        $sql = "SELECT DISTINCT ingredientes
                FROM productos";

        $result = $conn -> query($sql);

        if($result -> num_rows > 0){
            $return = array();
            while($row = $result -> fetch_assoc()){
                $line = explode(":", $row['ingredientes']);
                foreach($line as $ing){
                    $return = array_unique($return);
                    $return[] = $ing;
                }
            }
            $return = array_unique($return);
        }else{
            $return = false;
		}

        $conn -> close();

        return $return;
    }

    function fav($type, $prod, $token){

        $data = jwt_decode($token);
        if($data){
            //El token es valido

            $id_user = $data -> name;

            $conn = conn();

            $sql = "SELECT * FROM users WHERE id='$id_user'";

            $result = $conn->query($sql);

            if($result -> num_rows > 0){
                //El usuario existe
                $user = $result->fetch_assoc();

                if($user['estado'] == 1){
                    //El usuario está activo

                    $sql_check = "SELECT * FROM favoritos WHERE id_user='$id_user' AND id_prod='$prod'";

                    $result_check = $conn -> query($sql_check);

                    if($result_check -> num_rows > 0){
                        //Existe el favorito
                        $check_fav = true;
                    }else{
                        //No existe el favorito
                        $check_fav = false;
                    }

                    switch($type){
                        case "fav":

                            if(!$check_fav){
                                //NO Existe el favorito
                                $sql_fav = "INSERT INTO favoritos VALUES (NULL, '$id_user', '$prod')";
        
                                $result_fav = $conn -> query($sql_fav);
                            }else{
                                //Existe el favorito
                                return false;
                            }
                            break;
                        case "unfav":
                            
                            if($check_fav){
                                //Existe el favorito
                                $sql_fav = "DELETE FROM favoritos WHERE id_user='$id_user' AND id_prod='$prod'";
            
                                $result_fav = $conn -> query($sql_fav);
                            }else{
                                //No existe el favorito
                                return false;
                            }
        
                            break;
                        default:
                            $conn -> close();
                            return false;
                            break;
                    }

                    if($result_fav){
                        return true;
                    }
                }
            }

            $conn -> close();

        }//el token no es valido
        return "close_session";
    }

    function get_fav($token){
        $data = checksession($token);
        if($data){
            $id_user = $data -> name;

            $conn = conn();

            $sql = "SELECT id_prod FROM favoritos WHERE id_user='$id_user'";

            $result = $conn -> query($sql);

            $return = get_array($result);

            $conn -> close();

            return $return;
        }
        return "close_session";
    }

    
}

?>