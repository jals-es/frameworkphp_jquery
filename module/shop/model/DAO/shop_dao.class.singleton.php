<?php
//////
class shop_dao {
    static $_instance;
    //////
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance

    function get_all_prods($where, $offset, $limit){
        
        $query = "SELECT * FROM productos $where LIMIT $offset,$limit";
        
        return db::query() -> manual($query) -> execute() -> queryToArray(true);
    }

    function count_prods($where){
        $query = "SELECT COUNT(*) total FROM productos $where[0]";

        return db::query() -> manual($query) -> execute() -> queryToArray(true);
    }
    function get_range_prices(){

        $query = "SELECT MIN(precio) min, MAX(precio) max FROM productos";
        return db::query() -> manual($query) -> execute() -> queryToArray(true);
    }
    function get_catego_names(){
        return db::query() -> select(['*'], 'categorias') -> execute() -> queryToArray(true) -> toJSON();
    }
    function get_ingredientes(){

        return db::query() -> select(['ingredientes'], 'productos', true) -> execute() -> queryToArray(true);
    }

    function get_prod($args){

        return db::query() -> select(['*'], 'productos') -> where(['cod_prod' => [$args[0]]]) -> execute() -> queryToArray(true) -> toJSON();

    }

    function get_catego($args){

        return db::query() -> select(['*'], 'productos') -> where(['type' => [$args[0]]]) -> execute() -> queryToArray(true) -> toJSON();
    
    }

    function visit_prod($args){
        
        $ip = $ip = $_SERVER["REMOTE_ADDR"];
        return db::query() -> insert([['id' => NULL, 'id_user' => '-1', 'id_prod' => $args[0], 'ip' => $ip]], 'visitas_prod') -> execute() -> toJSON() -> getResolve();

    }

    function search($search){
        return db::query() -> manual("SELECT DISTINCT * FROM productos WHERE name LIKE '%$search%' OR descripcion LIKE '%$search%' ORDER BY type") -> execute() -> queryToArray(true) -> toJSON();
    }

}