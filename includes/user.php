<?php
class User extends Person {
    private $tournaments;

    public function __construct(){
        $this->tournaments=[];
    }

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

    public function charge($u_id, $chargeTourneys='N'){
        $db= new Database();
        $query=$db->consult('SELECT id_persona, nickname_persona FROM personas WHERE id_persona='.$u_id);
        $data=$query->fetch();

        $this->id=$u_id;
        $this->nickname=$data['nickname_persona'];

        if($chargeTourneys=='Y'){
            $query=$db->consult('SELECT t.id_torneo 
                FROM torneos t 
                INNER JOIN personas p ON t.id_persona=p.id_persona 
                WHERE p.id_persona='.$u_id);

            foreach ($query as $row) {
                $t=new TournamentFigure();
                $t->charge($row['id_torneo']);
                $this->tournaments[] = $t;
            }
        }
    }

    public function getTournaments(){
        return $this->tournaments;
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