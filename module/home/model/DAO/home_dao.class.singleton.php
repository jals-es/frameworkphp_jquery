<?php

class home_dao {
    static $_instance;
    //////
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance

    public function selectSlide () {
        return db::query() -> select(['cod_prod' ,'name', 'img'], 'productos') -> order(['name'], 'DESC') -> limit(5) -> execute() -> queryToArray(true) -> toJSON();
    }// end_selectSlide

    public function selectCategories() {
        return db::query() -> select(['*'], 'categorias') -> limit(4) -> execute() -> queryToArray(true) -> toJSON();
    }// end_selectCategories
}// end_home_dao