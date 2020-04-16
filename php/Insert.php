<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php

$nick = $_GET["nick-input"];
$name = $_GET["nombres-input"];
$ape = $_GET["apell-input"];
$phone = $_GET["tel-input"];

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
 
    $query = "INSERT INTO personas (nickname_persona, nombre_persona, apellido_persona, telefono_persona)
    VALUES ('$nick','$name','$ape','$phone');";

    $result = mysqli_query($conect,$query);

    if ($result) {
        echo "Registro guardado";
    } else {
        echo "Error en la consulta";
    }

    mysqli_close($conect);
?>
    
</body>
</html>