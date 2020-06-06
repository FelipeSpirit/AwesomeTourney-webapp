<?php
include '../../includes/classes.php';

$name=$_POST['name'];
$tourney=$_POST['tourney'];

$db= new Database();
$insert="INSERT INTO inscripciones (nickname, id_torneo) VALUES ('$name', $tourney)";

$db->insert('inscripciones',$insert);



header('location: ../../tourney/competitors?id='.$tourney);