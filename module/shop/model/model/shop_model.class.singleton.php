<?php

class shop_model {
    private $bll;
    static $_instance;
    //////
    function __construct() {
        $this -> bll = shop_bll::getInstance();
    }// end_construct

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance

    public function get_all_prods($args) {
        return $this -> bll -> get_all_prods_BLL($args);
    }
    public function count_prods($args){
        return $this -> bll -> count_prods_BLL($args);
    }
    public function get_range_prices(){
        return $this -> bll -> get_range_prices_BLL();
    }
    public function get_catego_names(){
        return $this -> bll -> get_catego_names_BLL();
    }
    public function get_ingredientes(){
        return $this -> bll -> get_ingredientes_BLL();
    }
    public function get_prod($args){
        return $this -> bll -> get_prod_BLL($args);
    }
    public function get_catego($args){
        return $this -> bll -> get_catego_BLL($args);
    }
    public function visit_prod($args){
        return $this -> bll -> visit_prod_BLL($args);
    }
    public function search($args){
        return $this -> bll -> search_BLL($args);
    }
}// end_shop_model