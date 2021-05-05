<?php

class login_model {
    private $bll;
    static $_instance;
    //////
    function __construct() {
        $this -> bll = login_bll::getInstance();
    }// end_construct

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance
    public function register_user($args){
        return $this -> bll -> register_user_BLL($args);
    }
    public function set_token_email($args){
        return $this -> bll -> set_token_email_BLL($args);
    }
    public function check_token($args){
        return $this -> bll -> check_token_BLL($args);
    }
    public function delete_token($args){
        return $this -> bll -> delete_token_BLL($args);
    }
    public function verify_user($args){
        return $this -> bll -> verify_user_BLL($args);
    }
    public function check_by_user($args){
        return $this -> bll -> check_by_user_BLL($args);
    }
    public function check_social_user($args){
        return $this -> bll -> check_social_user_BLL($args);
    }
    public function get_by_id($args){
        return $this -> bll -> get_by_id_BLL($args);
    }
}