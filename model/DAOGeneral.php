<?php
//////
$path = $_SERVER['DOCUMENT_ROOT'] . '/frameworkCars.v.1.3/';
include ($path . 'model/Connect.php');

class DAOGeneral {
    //////
    public static function query($values) {
        //////
        $connection = Connect::enable();
        $query = mysqli_query($connection, $values);
        $error = false;
        //////
        if (!$query) {
            $error = true;
            $errorDesc = mysqli_error($connection);
        }// end_if
        Connect::close($connection);
        //////
        return array('query' => $query, 'error' => $error, 'desc' => $errorDesc);
    }// end_select

    public static function singleQuery($values) {
        //////
        $query = DAOGeneral::query($values);
        //////
        if (mysqli_num_rows($query['query']) > 0) {
            $query['resolve'] = mysqli_fetch_assoc($query['query']);
        }// end_if
        //////
        return $query;
    }// end_singleQuery
    //////

    public static function multipleQuery($values) {
        //////
        $query = DAOGeneral::query($values);
        $rowsValue = array();
        //////
        if (mysqli_num_rows($query['query']) > 0) {
            while ($row = mysqli_fetch_assoc($query['query'])) {
                $rowsValue[] = $row;
            }// end_while
            $query['resolve'] = $rowsValue;
        }// end_if
        //////
        return $query;
    }// end_multipleQuery
    //////

    public static function booleanQuery($values) {
        //////
        $query = DAOGeneral::query($values);
        //////
        if ($query['query']) {
            $query['resolve'] = true;
        }else {
            $query['resolve'] = false;
        }// end_else
        //////
        return $query;
    }// end_booleanQuery
}// end_DAOGeneral