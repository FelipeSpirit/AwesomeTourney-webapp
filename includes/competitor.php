<?php

class Competitor {
    private $id;
    private $nickname;
    private $name;
    private $last_name;
    private $phone;

    function __construct($nk, $na, $la, $pho) {
        $this->nickname = $nickname;
        $this->name = $name;
        $this->last_name = $last_name;
        $this->phone = $phone;
    }

    public function getId(){
        return $this->id;
    }
}
?>