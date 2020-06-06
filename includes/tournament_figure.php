<?php
class TournamentFigure {
	private $owner_id;
	private $id;
	private $name;
	private $type;
	private $competitors;
	private $rounds;
	private $matches;
	private $modality;
	private $state;

    function __construct($name=null, $type=null) {
    	$this->name=$name;
    	$this->type=$type;
    	$this->competitors=[];
    	$this->rounds=[];
    	$this->matches=[];
    }

    public function charge($t_id){
    	$db= new Database();
    	$query=$db->consult('SELECT id_torneo, id_juego, id_persona, nombre_torneo, tipo_torneo, fecha_torneo,modalidad,estado_torneo 
    		FROM torneos 
    		WHERE id_torneo='.$t_id);

    	if($query->rowCount()){
	    	$t=$query->fetch();
	    	$this->id=$t_id;
	    	$this->name=$t['nombre_torneo'];
	    	$this->owner_id=$t['id_persona'];
	    	$this->modality=$t['modalidad'];
	    	$this->state=$t['estado_torneo'];

	    	if($t['tipo_torneo']=='S'){
	    		$this->type=new SimpleElimination();
	    	}else if($t['tipo_torneo']=='D'){
				$this->type=new DoubleElimination();
	    	}else if($t['tipo_torneo']=='R'){
	    		$this->type=new RoundRobin();
	    	}
	    	
	    	$query = $db->consult('SELECT ifnull(p.id_persona,0) id_persona, p.nickname_persona,nickname 
	    		FROM inscripciones i
	    		LEFT JOIN personas p ON i.id_persona=p.id_persona 
	    		WHERE id_torneo='.$t_id);

	    	foreach ($query as $row) {
	    		$this->addCompetitor(new Competitor($row['id_persona'],$row['nickname_persona'].$row['nickname']));
	    	}

	    	$query = $db->consult("SELECT e.index_torneo,ifnull(e.id_persona_a,0) id_persona_a,ifnull(e.id_persona_b,0) id_persona_b, 
	    	    		a.nickname_persona na,b.nickname_persona nb,  
	    	    		ifnull(e.nickname_a,'$#$') nickname_a, ifnull(e.nickname_b,'$#$') nickname_b,
	    	    		e.puntuacion_a,e.puntuacion_b, e.estado_encuentro,ifnull(e.ganador,2) ganador,
	    	    		pa.index_torneo indexa, pb.index_torneo indexb
	    	    		FROM encuentros e 
	    	    		LEFT JOIN encuentros pa ON pa.proximo_encuentro=e.id_encuentro 
	    	    		LEFT JOIN encuentros pb ON pb.proximo_encuentro_b=e.id_encuentro
	    	    		LEFT JOIN personas a ON e.id_persona_a=a.id_persona 
	    	    		LEFT JOIN personas b ON e.id_persona_b=b.id_persona 
	    	    		WHERE e.id_torneo=$t_id ORDER BY e.index_torneo,indexa,indexb");
	    	
	    	$currentIndex=0;

	    	foreach ($query as $row) {
	    		if($row['index_torneo'] != $currentIndex){
	    			$currentIndex = $row['index_torneo'];

	    			if($row['nickname_a']!=="$#$"){
		    			$c1=new Competitor(0,$row['nickname_a']);
		    		} else if($row['id_persona_a']!==0) {
		    			$c1=new Competitor($row['id_persona_a'],$row['na']);
		    		}

		    		if($row['nickname_b']!=="$#$"){
		    			$c2=new Competitor(0,$row['nickname_b']);
		    		}else if($row['id_persona_b']!==0){
		    			$c2=new Competitor($row['id_persona_b'],$row['nb']);
		    		}

		    		if(isset($c1)&&isset($c2)){
		    			$m=new MatchFigure($row['index_torneo'],$this,$c1,$c2);
		    			$m->setScore($row['puntuacion_a'],$row['puntuacion_b'],$row['estado_encuentro'],$row['ganador']);
		    		}else if(isset($c1)){
		    			$m=new MatchFigure($row['index_torneo'],$this,$c1);
		    		}else if(isset($c2)){
		    			$m=new MatchFigure($row['index_torneo'],$this,null,$c2);
		    		}else{
		    			$m=new MatchFigure($row['index_torneo'],$this);
		    		}

	    			if($row['indexa'] != 0&&$row['indexb']!=0){
	    				$m->setPMatchAId($row['indexb']);
	    				$m->setPMatchBId($row['indexa']);
	    			}else{
	    				if($row['indexa'] != 0)
		    				$m->setPMatchAId($row['indexa']);

		    			if($row['indexb']!=0)
		    				$m->setPMatchAId($row['indexb']);
	    			}
	    		}else{
	    			if($row['indexa'] != 0)
	    				$m->setPMatchBId($row['indexa']);
	    			
	    			if($row['indexb'] != 0)
	    				$m->setPMatchBId($row['indexb']);
	    		}

	    		if(isset($this->matches[$currentIndex - 1])){
	    			$this->matches[$currentIndex - 1]=$m;
	    		}else{
	    			$this->matches[]=$m;
	    		}

	    		$c1=null;
	    		$c2=null;
	    	}
    	}
    }

    function addCompetitor(Competitor $competitor) {
    	$this->competitors[]=$competitor;
    }

    public function getId(){
    	return $this->id;
    }

    public function getName(){
		return $this->name;
	}

	public function getTournamentType(){
		return $this->type;
	}

	public function getCompetitors(){
		return $this->competitors;
	}

	public function getInfo(){
		$ret= $this->name.' | '
		.$this->type->getName().' | '
		.count($this->competitors).'<br><br>'.PHP_EOL
		.'Participantes<br>';


		foreach ($this->competitors as $competitor) {
			$ret=$ret.$competitor->getNickname().'<br>';
		}

		$ret=$ret.'<br><br>';

		foreach ($this->rounds as $round) {
			$ret=$ret.$round->getInfo().'<br>';
		}
		return $ret;
	}

	public function generateMatches(){
		$this->rounds = $this->type->generateMatches($this);
		return $this->rounds;
	}

	public function chargeMatches(){
		if($this->state == "AC")
			$this->rounds = $this->type->chargeMatches($this);
	}

	public function getRounds(){
		return $this->rounds;
	}

	public function getMaxValues(){
		$val=[];
		$val['matches']=0;

		foreach ($this->rounds as $r) {
			if(count($r->getMatches())>$val['matches'])
				$val['matches']=count($r->getMatches());
		}

		$val['rounds']=count($this->rounds);
		return $val;
	}

	public function getAllMatches($rounds){
		$matches=[];

		foreach ($rounds as $r) {
			foreach ($r->getMatches() as $match) {
				$matches[] = $match;
			}
		}

		return $matches;
	}

	public function getOwnerId(){
		return $this->owner_id;
	}

	public function getModality(){
		return $this->modality;
	}

	public function getState(){
		return $this->state;
	}

	public function getMatches(){
		return $this->matches;
	}
}