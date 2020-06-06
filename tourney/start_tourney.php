<?php
include '../includes/classes.php';
$t_id=$_POST['id'];
$db=new Database();
$t= new TournamentFigure();
$t->charge($t_id);
$matches_aux=[];

foreach ($t->generateMatches() as $round) {
	foreach ($round->getMatches() as $match) {
		$matches_aux[]=$match;
		$index_torney=$match->getId();
		$aux=$match->getNicknames();
		$insert="INSERT INTO encuentros (id_torneo, index_torneo".($aux[0] == 0 ? "" : ($aux[0] == 1 ? ",nickname_a" : ",persona_a")).($aux[2] == 0 ? "" : ($aux[2] == 1 ? ",nickname_b" : ",persona_b")).")";
		$values=" VALUES ($t_id,$index_torney".($aux[0] == 0 ? "" : ",".$aux[1]).($aux[2] == 0 ? "" : ",".$aux[3]).")";
		
		$db->insert('encuentros',$insert.$values);
	}
}

$qs=$db->consult("SELECT id_encuentro FROM encuentros WHERE id_torneo=$t_id ORDER BY index_torneo");

$ids=[];
foreach ($qs as $q) {
	$ids[]=$q['id_encuentro'];
}

for ($i=0; $i < count($matches_aux); $i++) {
	if($matches_aux[$i]->getNextMatch()){
		$id=$ids[$i];
		$m_id=$ids[$matches_aux[$i]->getNextMatch()->getId()-1];
		$u="UPDATE encuentros SET proximo_encuentro = $m_id WHERE id_encuentro = $id";
		$db->consult($u);
	}

	if($matches_aux[$i]->getNextLoserMatch()){
		$id=$ids[$i];
		$m_id=$ids[$matches_aux[$i]->getNextLoserMatch()->getId() - 1];
		$u="UPDATE encuentros SET proximo_encuentro_b = $m_id WHERE id_encuentro = $id";
		$db->consult($u);
	}
}

$update="UPDATE torneos SET estado_torneo = 'AC' WHERE id_torneo = $t_id";
$db->consult($update);

echo 'OK';

