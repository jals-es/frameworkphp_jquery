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
        $token = $_POST['token'];
        // $token = "eyJ0eXAiOiJKV1QiLCAiYWxnIjoiSFMyNTYifQ.eyJpYXQiOiAiMTYyMDA1NTE1NiIsImV4cCI6ICIxNjIwMDU4NzU2IiwibmFtZSI6ICI0MDczMGQwZjRlOGQwODBiMDc0OWU0ZGIwNzYwZGFjMzk2YmNlN2UxM2RmNWIyOTFmMjA0MDgwOTEwMzRhZTllIn0.qtGvGjUBh8V-DW0zlKqHnQkT8yNmwHfIGK4TE2GoHi8";
        if(isset($token)){
            $user = common::accessModel('general_model', 'checksession', [$token]) -> getResolve();
            // print_r($user);
            if($user[0]){
                if($user[0]['estado'] == 1){
                    echo "true";
                }else{
                    echo "error";
                }
            }else{
                echo "error";
            }
        }else{
            echo "error";
        }
    }
}