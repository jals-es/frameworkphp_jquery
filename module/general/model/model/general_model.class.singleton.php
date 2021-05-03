<?php

class general_model {
    private $bll;
    static $_instance;
    //////
    function __construct() {
        $this -> bll = general_bll::getInstance();
    }// end_construct

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance
    public function locales(){
        return $this -> bll -> locales_BLL();
    }
    public function search($search) {
        return $this -> bll -> search_BLL($search);
    }
    public function checksession($args) {
        return $this -> bll -> checksession_BLL($args);
    }
}