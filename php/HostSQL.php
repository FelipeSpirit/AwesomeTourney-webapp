<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Host</title>
</head>
<body>
    
<?php

    $db_host = "localhost";
    $db_nombre = "basecita";
    $db_usuario = "root";
    $db_ps = "";

    $conect = mysqli_connect($db_host,$db_usuario,$db_ps);

    if (mysqli_connect_errno()) {
        echo "Fallo al conectar con la base de datos";
        exit();
    }

    mysqli_select_db($conect, $db_nombre) or die ("No se pudo conectar con la BD");

    //$query = "SELECT * FROM personas;";
/*
    $result = mysqli_query($conect,$query);
    
    $fila = mysqli_fetch_row($result);
    */

    function add($a,$b,$c,$d) {
        global $conect;

        $query = "INSERT INTO personas (nickname_persona, nombre_persona, apellido_persona, telefono_persona)
        VALUES ($a,$b,$c,$d);";

        $result = mysqli_query($conect,$query);
    }

    function close() {
        global $conect;
        mysqli_close($conect);
    }

    //////
    	//require "HostSQL.php";
	include "Competitor.php";

	$db_host = "localhost";
    $db_nombre = "basecita";
    $db_usuario = "root";
    $db_ps = "";

    $conect = mysqli_connect($db_host,$db_usuario,$db_ps);

    if (mysqli_connect_errno()) {
        echo "Fallo al conectar con la base de datos";
        exit();
    }

	mysqli_select_db($conect, $db_nombre) or die ("No se pudo conectar con la BD");
	
	if(isset($_POST["boton-crear"])) {
		//add($_POST["nick-input"], $_POST["nombres-input"], $_POST["apell-input"], $_POST["tel-input"]);

		$a = $_POST["nick-input"];
		$b = $_POST["nombres-input"];
		$c = $_POST["apell-input"];
		$d = $_POST["tel-input"];

		$query = "INSERT INTO personas (nickname_persona, nombre_persona, apellido_persona, telefono_persona)
		VALUES ($a,$b,$c,$d);";
	
		$result = mysqli_query($conect,$query);

		echo "Creada";
	}

   

?>

</body>
</html>