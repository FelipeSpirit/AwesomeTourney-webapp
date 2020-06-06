<?php
include '../../includes/classes.php';

$name=$_POST['name'];
$type=$_POST['type'];
$datetime=$_POST['date'].' '.$_POST['time'];
$modd=$_POST['modd'];
$owner=$_POST['owner'];
$game=$_POST['game'];

$db= new Database();
$insert="INSERT INTO torneos (nombre_torneo, tipo_torneo, fecha_torneo, modalidad, id_persona,id_juego) VALUES ('$name', '$type','$datetime','$modd',$owner,$game)";

$t_id=$db->insert('torneos',$insert);

header('location: ../../tourney?id='.$t_id);