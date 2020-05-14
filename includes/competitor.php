<?php

class Competitor extends Person{
    private $nickname;

    function __construct($id,$nickname, $name=null, $last_name=null, $phone=null, $email=null) {
        $this->nickname = $nickname;
        parent::__construct($id, $name,$last_name,$phone,$email);
    }
    
    public function getNickname(){
        return $this->nickname;
    }
}