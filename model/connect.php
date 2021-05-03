<?php
//////
class Connect {
    //////
    public static function enable() {
        //////
        // $ini_file = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/clase/frameworkphp_angular/model/credentials.ini');
        $ini_file = parse_ini_file(MODEL_PATH.'credentials.ini');
        //////
        $connection = mysqli_connect($ini_file['host'], $ini_file['user'], $ini_file['password'], $ini_file['db']);
        //////
        if (!$connection) {
            echo mysqli_connect_error();
        }// end_if
        return $connection;
    }// end_enable
    //////
    /////

    public static function close($connection) {
        //////
        mysqli_close($connection);
    }// end_close
    //////

}// end_Connect
//////