<?php

    class Competitor {
        private $id;
        private $nick_name;
        private $name;
        private $last_name;
        private $phone_number;
        private $email;

        function __construct() {
            $params = func_get_args();
            $num_params = func_num_args();
            $funcion_constructor ='__construct'.$num_params;
            if (method_exists($this,$funcion_constructor)) {
                call_user_func_array(array($this,$funcion_constructor),$params);
            }
        }

        function __construct5($nk, $na, $la, $pho, $ema) {
            $this->nick_name = $nk;
            $this->name = $na;
            $this->last_name = $la;
            $this->phone_number = $pho;
            $this->email = $ema;
        }

        function __construct0() {
            
        }

        function get_nick() {
            return $this->nick_name;
        }

        function to_string() {
            echo "P: " . $this->nick_name . " " . $this->name . " " . $this->last_name . 
            " " . $this->phone_number . " " . $this->email . "<br>";
        }

    }

?>