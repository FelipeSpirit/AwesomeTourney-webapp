<?php
include '../includes/classes.php';

$db=new Database();
$pos=$_POST['position'];
$posL=$_POST['positionL'];
$t_id=$_POST['tourney'];
$m_id=$_POST['match'];

print_r($_POST);

if(isset($_POST['winner'])){
	$winner=$_POST['winner'];

	if($pos != 2){
		$m_aux = $m_id-1;
		$m_aux2 = $m_id-2;

		$c="SELECT proximo_encuentro, nickname_a,nickname_b FROM encuentros WHERE id_torneo=$t_id AND index_torneo=$m_id";

		$q=$db->consult($c);

		$r=$q->fetch();

		$e_id=$r['proximo_encuentro'];
		$n=$winner == 0 ? $r['nickname_a'] : $r['nickname_b'];
		$header=$pos==0?'nickname_a':'nickname_b';

		$update="UPDATE encuentros SET $header = '$n' WHERE id_encuentro= $e_id";
		$db->consult($update);
	}

	if($posL != 2){
		$m_aux = $m_id-1;
		$m_aux2 = $m_id-2;

		$c="SELECT proximo_encuentro_b, nickname_a,nickname_b FROM encuentros WHERE id_torneo=$t_id AND index_torneo=$m_id";

		$q=$db->consult($c);

		$r=$q->fetch();

		$e_id=$r['proximo_encuentro_b'];
		$n=$winner == 1 ? $r['nickname_a'] : $r['nickname_b'];
		$header=$posL==0?'nickname_a':'nickname_b';

		$update="UPDATE encuentros SET $header = '$n' WHERE id_encuentro= $e_id";
		echo $update;
		$db->consult($update);
	}

	$update="UPDATE encuentros SET ganador = $winner WHERE id_torneo=$t_id AND index_torneo=$m_id";
	$db->consult($update);
}


header('location: ../tourney?id='.$t_id);



