<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/clase/appbar/';
    include( $path."model/connect.php");
    
    class DAOProd{
        function insert_user($datos){
            $name = $datos['name'];
            $descripcion = $datos['descripcion'];
            $tipo = $datos['tipo'];
            $ingredientes = $datos['pan'];
            $i = 0;
            foreach($datos['content'] as $indice => $valor){
                $ingredientes .= ":".$valor;
                $i++;
            }
            $precio = $datos['price'];
            $estado = 1;

            $conn = conn();

            $sql = "INSERT INTO productos (cod_prod, name, descripcion, type, ingredientes, precio, estado) VALUES (NULL, '$name', '$descripcion', '$tipo', '$ingredientes', '$precio', '$estado')";

            $result = $conn -> query($sql);
            
            $conn -> close();

            return $result;
        }

        function get_prod_by_name($name){
            $conn = conn();

            $sql = "SELECT name FROM productos WHERE name='$name'";

            $result = $conn -> query($sql);

            $conn -> close();

            return $result;
        }

        function get_prod_by_cod($cod){
            $conn = conn();

            $sql = "SELECT * FROM productos WHERE cod_prod='$cod'";

            $result = $conn -> query($sql);

            $conn -> close();

            return $result;
        }

        function get_all_prod(){
            $conn = conn();

            $sql = "SELECT * FROM productos";

            $result = $conn -> query($sql);

            $conn -> close();

            return $result;
        }

        function delete_prod($id){
            $conn = conn();

            $sql = "DELETE FROM productos WHERE cod_prod='$id'";

            $result = $conn -> query($sql);

            $conn -> close();

            return $result;
        }

        function update_prod($datos, $id){
            $name = $datos['name'];
            $descripcion = $datos['descripcion'];
            $tipo = $datos['tipo'];
            $ingredientes = $datos['pan'];
            $i = 0;
            foreach($datos['content'] as $indice => $valor){
                $ingredientes .= ":".$valor;
                $i++;
            }
            $precio = $datos['price'];
            
            $conn = conn();

            $sql = "UPDATE productos SET name='$name', descripcion='$descripcion', type='$tipo', ingredientes='$ingredientes', precio='$precio' WHERE cod_prod='$id'";

            $result = $conn -> query($sql);
            
            $conn -> close();

            return $result;
        }
    }
?>