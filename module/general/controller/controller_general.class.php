<?php 

class controller_general{
    function locales(){
        echo common::accessModel('general_model', 'locales') -> getResolve();
    }
    function search(){
        $search = $_POST['search'];

        if(isset($search)){
            echo common::accessModel('general_model', 'search', [$search]) -> getResolve();
        }else{
            echo "error";
        }
    }
    function checksession(){

    }
}