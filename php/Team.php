<?php

class Team {
    private $id;
    private $team_name;
    private $competitors;

    function __construct() {
        
    }

    function add_competitor($comp) {
        $this->competitors[] = $comp;
    }

    function echo_team() {
        foreach ($this->competitors as $key => $value) {
            $value->to_string();
        }
    }

}

?>