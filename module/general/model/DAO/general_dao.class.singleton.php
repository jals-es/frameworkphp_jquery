<?php

class general_dao {
    static $_instance;
    //////
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance
    public function locales(){
        return db::query() -> select(['*'], 'locales') -> execute() -> queryToArray(true) -> toJSON();
    }
    public function search($search) {
        return db::query() -> manual("SELECT p.cod_prod, p.name, p.precio
                                FROM productos p LEFT JOIN (
                                    SELECT v.id_prod, COUNT(v.id) veces
                                    FROM visitas_prod v
                                    GROUP BY v.id_prod
                                ) k
                                ON p.cod_prod = k.id_prod
                                WHERE p.name LIKE '%$search%' OR p.descripcion LIKE '%$search%'
                                ORDER BY k.veces DESC, RAND() 
                                LIMIT 8") -> execute() -> queryToArray(true) -> toJSON();
    }

    public function checksession($token){
        require JWT_PATH . 'middleware.php';

        $token = jwt_decode($token);
        if($token){
            $id_user = $token -> name;
            return db::query() -> select(['*'], 'users') -> where(['id' => [$id_user]]) -> execute() -> queryToArray(true);
        }
        return false;
    }
}