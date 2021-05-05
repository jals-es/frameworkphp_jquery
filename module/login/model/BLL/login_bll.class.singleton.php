<?php

class login_bll {
    private $dao;
    static $_instance;

    function __construct() {
        $this -> dao = login_dao::getInstance();
    }// end_construct

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance
    public function register_user_BLL($args){
        return $this -> dao -> register_user($args[0], $args[1], $args[2], $args[3], $args[4], $args[5]);
    }
    public function set_token_email_BLL($args){
        return $this -> dao -> set_token_email($args[0], $args[1]);
    }
    public function check_token_BLL($args){
        return $this -> dao -> check_token($args[0]);
    }
    public function delete_token_BLL($args){
        return $this -> dao -> delete_token($args[0]);
    }
    public function verify_user_BLL($args){
        return $this -> dao -> verify_user($args[0]);
    }
    public function check_by_user_BLL($args){
        return $this -> dao -> check_by_user($args[0]);
    }
    public function check_social_user_BLL($args){
        return $this -> dao -> check_social_user($args[0]);
    }
    public function get_by_id_BLL($args){
        return $this -> dao -> get_by_id($args[0]);
    }
}