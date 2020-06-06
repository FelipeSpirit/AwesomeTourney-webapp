<?php
include '../includes/classes.php';
$t_id=$_POST['tourney'];
$ind=$_POST['match'];

$db=new Database();

$update="SELECT nickname_a,nickname_b FROM encuentros WHERE id_torneo=$t_id AND index_torneo=$ind";
$q=$db->consult($update);

$r=$q->fetch();
echo $r['nickname_a'].';'.$r['nickname_b'];
