<?php

class login_dao {
    static $_instance;
    //////
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }// end_if
        return self::$_instance;
    }// end_getInstance
    public function register_user($id_user, $user, $pass, $email, $gravatar, $estado){
        return db::query() -> insert([['id' => $id_user, 'user' => $user, 'pass' => $pass, 'email' => $email, 'avatar' => $gravatar, 'estado' => $estado]], 'users') -> execute() -> toJSON() -> getResolve();
    }

    public function set_token_email($id_user, $token){
        $expire = time() + (60*60*24);
        return db::query() -> insert([['token' => $token, 'id_user' => $id_user, 'expire' => $expire, 'tipo' => '1']], 'tokens') -> execute() -> toJSON() -> getResolve();
    }

    public function check_user($user){
        return db::query() -> manual("SELECT * FROM users WHERE user='$user'") -> execute() -> queryToArray(true) -> getResult();
    }

    public function check_email($email){
        return db::query() -> manual("SELECT * FROM users WHERE email='$email'") -> execute() -> queryToArray(true) -> getResult();
    }

    public function check_token($token){
        return db::query() -> manual("SELECT * FROM tokens WHERE token='$token' AND tipo=1") -> execute() -> queryToArray(true);
    }

    public function delete_token($token){
        return db::query() -> delete('tokens') -> where(['token' => [$token]]) -> execute() -> toJSON() -> getResolve();
    }

    public function verify_user($id_user){
        return db::query() -> update(['estado' => 1], 'users', true) -> where(['id' => [$id_user], 'estado' => ['0']]) -> execute() -> toJSON() -> getResolve();
    }

    public function check_by_user($user){
        return db::query() -> select(['*'], 'users') -> where(['user' => [$user]]) -> execute() -> queryToArray(true) -> getResolve();
    }
    public function check_social_user($uid){
        return db::query() -> select(['*'], 'users') -> where(['id' => [$uid]]) -> execute() -> queryToArray(true) -> getResult();
    }
    public function get_by_id($uid){
        return db::query() -> select(['*'], 'users') -> where(['id' => [$uid]]) -> execute() -> queryToArray(true);
    }
}