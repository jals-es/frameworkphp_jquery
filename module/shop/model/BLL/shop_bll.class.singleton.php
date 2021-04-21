<?php

class shop_bll {
    private $dao;
    static $_instance;

    function __construct() {
        $this -> dao = shop_dao::getInstance();
    }// end_construct

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance

    public function get_all_prods_BLL($args) {

        $where = $args[2];
        $offset = $args[0];
        $limit = $args[1];
        
        $return = $this -> dao -> get_all_prods($where, $offset, $limit);

        return $return;
    }
    public function count_prods_BLL($where){
        return $this -> dao -> count_prods($where);
    }
    public function get_range_prices_BLL(){
        return $this -> dao -> get_range_prices();
    }
    public function get_catego_names_BLL(){
        return $this -> dao -> get_catego_names();
    }
    public function get_ingredientes_BLL(){
        return $this -> dao -> get_ingredientes();
    }
    public function get_prod_BLL($args){
        return $this -> dao -> get_prod($args);
    }
    public function get_catego_BLL($args){
        return $this -> dao -> get_catego($args);
    }
    public function visit_prod_BLL($args){
        return $this -> dao -> visit_prod($args);
    }
    public function search_BLL($args){
        return $this -> dao -> search($args[0]);
    }
}