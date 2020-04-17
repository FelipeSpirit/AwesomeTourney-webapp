<?php
class User {
	public static function exists($nickname, $password){
		$database= new Database();

		$query = $database->consult("SELECT id_persona 
            FROM personas
            WHERE nickname_persona = '$nickname' 
            AND contrasena_persona = '$password'");
        
        if($query->rowCount())
        	return $query->fetch()['id_persona'];
        else
            return false;
	}
}

class UserSession{
    public function __construct(){
        session_start();
    }

    public function closeSession(){
        session_unset();
        session_destroy();
    }
}
?>