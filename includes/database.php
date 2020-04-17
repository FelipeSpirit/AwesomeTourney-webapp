<?php
class Database{
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct(){
        $this->host = 'localhost';
        $this->db   = 'tourney';
        $this->user = 'admin';
        $this->password = 'admin';
        $this->charset  = 'utf8mb4';
    }

    function connect(){
        try{
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            
            $pdo = new PDO($connection, $this->user, $this->password, $options);
    
            return $pdo;
        }catch(PDOException $e){
            print_r('Error connection: ' . $e->getMessage());
        }
    }

    public function insert($table,$insert){
        $this->connect()->exec("ALTER TABLE $table AUTO_INCREMENT = 1");

        try{
            $pdo = $this->connect();
            $query = $pdo->exec($insert);
            return $pdo->lastInsertId();
        }catch(PDOException $e){
            return null;
        }
    }

    public function consult($consult){
        $query = $this->connect()->prepare($consult);
        $query->execute();

        return $query;
    }
}
?>