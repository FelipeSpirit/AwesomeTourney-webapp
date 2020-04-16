<?php

    class Competitor {
        private $nick_name;
        private $name;
        private $last_name;
        private $phone_number;

        function __construct($nk, $na, $la, $pho) {
            $this->nick_name = $nk;
            $this->name = $na;
            $this->last_name = $la;
            $this->phone_number = $pho;
        }

        function toString() {
            echo "P: " . $this->nick_name . " " . $this->name . " " . $this->last_name . " " . $this->phone_number;
        }

    }

?>