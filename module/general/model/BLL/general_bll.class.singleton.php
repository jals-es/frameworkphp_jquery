<?php
class general_bll {
    private $dao;
    static $_instance;

    function __construct() {
        $this -> dao = general_dao::getInstance();
    }// end_construct

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance
    public function locales_BLL(){
        return $this -> dao -> locales();
    }
    public function search_BLL($search) {
        return $this -> dao -> search($search[0]);
    }
    public function checksession_BLL($args){
        return $this -> dao -> checksession($args[0]);
    }
}