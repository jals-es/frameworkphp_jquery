<?php

	function conn(){
		$host = 'localhost';
    	$user = "root";
    	$pass = "";
    	$db = "clase_appbar";
    	$port = 3306;
    	
		$conn = new mysqli($host, $user, $pass, $db, $port);
		
		if($conn->connect_error){
			die("Connection failed: " . $conn->connect_error);
		}

		return $conn;
	}

	function get_array($result){
		if($result -> num_rows > 0){
            $return = array();
            $i = 0;
            while($row = $result -> fetch_assoc()){
                $return[$i] = $row;
                $i++;
            }
        }else{
            $return = false;
		}
		
		return $return;
	}

	function checksession($token){
        
        $data = jwt_decode($token);
        if($data){
            //El token es valido
            $id_user = $data -> name;

            $conn = conn();

            $sql = "SELECT * FROM users WHERE id='$id_user'";

            $result = $conn->query($sql);

            $conn -> close();

            if($result -> num_rows > 0){
                //El usuario existe
                $user = $result->fetch_assoc();

                if($user['estado'] == 1){
                    //El usuario está activo
                    return $data;
                }
            }
        }
        return false;

    }

?>