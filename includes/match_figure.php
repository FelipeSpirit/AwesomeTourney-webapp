<?php
class MatchFigure implements Figure{
	private $x;
	private $y;
	private $match_height=55;
	public $_id,$pMatchAId,$pMatchBId;
	private $id;
	protected $round;
	private $nextMatch,$nextLMatch, $previousMatchA, $previousMatchB;
	private $tournament;
	private $competitor_1,$competitor_2, $winner;
	private $score_1;
	private $score_2;

	function __construct() {
		$params= func_get_args();
		$num_params=func_num_args();
		$func_constr ='__construct'.$num_params;
		$this->score_1=0;
		$this->score_2=0;
		$this->winner=-1;

		if(method_exists($this, $func_constr))
			call_user_func_array(array($this,$func_constr), $params);
	}

	function __construct0(){
	}

	function __construct1($id){
		$this->id=$id;
	}

	function __construct2($id,TournamentFigure $t){
		$this->id=$id;
		$this->tournament=$t;
	}

	function __construct3($id,TournamentFigure $t, Competitor $c1){
		$this->id=$id;
		$this->tournament=$t;
		$this->competitor_1=$c1;
	}

	function __construct4($id,TournamentFigure $t,$c1, $c2){
		$this->id=$id;
		$this->tournament=$t;
		$this->competitor_1=$c1;
		$this->competitor_2=$c2;
	}

	public function getInfo(){
		$ret=$this->id.': ';

		$retA="";
		$retB="";

		if(isset($this->competitor_1))
			$retA=$this->competitor_1->getNickname();
		else if(isset($this->previousMatchA))
			$retA='Ganador de '.$this->previousMatchA->getId();

		if(isset($this->competitor_2))
			$retB=$this->competitor_2->getNickname();
		else if(isset($this->previousMatchB))
			$retB='Ganador de '.$this->previousMatchB->getId();

		return $ret.$retA.' vs '.$retB;
	}

	public function getTournament(){
		return $this->tournament;
	}

	public function getId(){
		return $this->id;
	}

	public function setNextMatch(MatchFigure $match){
		$this->nextMatch=$match;
	}

	public function setNextLoserMatch(MatchFigure $match){
		$this->nextLMatch=$match;
	}

	public function setPreviousMatches(MatchFigure $matchA,MatchFigure $matchB){
		$this->previousMatchA=$matchA;
		$this->previousMatchB=$matchB;
	}

	public function setPreviousMatchA(MatchFigure $matchA){
		$this->previousMatchA=$matchA;
	}

	public function setPreviousMatchB(MatchFigure $matchB){
		$this->previousMatchB=$matchB;
	}

	public function getWinner(){
		return $this->winner;
	}

	public function setScore($s1,$s2, $def=false,$winner=2){
		$this->score_1=$s1;
		$this->score_2=$s2;

		if($def){
			if($this->score_1>$this->score_2)
				$this->winner=$this->competitor_1;
			else
				$this->winner=$this->competitor_2;

			if(isset($this->nextMatch))
				$this->nextMatch->setWinner($this);
		}

		if($winner!==2){
			$this->winner=$winner;
		}
	}

	public function setWinner(Match $pMatch){
		if($this->previousMatchA==$pMatch)
			$this->competitor_1=$this->previousMatchA->getWinner();
		else
			$this->competitor_2=$this->previousMatchB->getWinner();
	}

	public function getData(){
		$ret=$this->id;

		$retA="";
		$retB="";

		if(isset($this->competitor_1))
			$retA = $this->competitor_1->getNickname();
		else if(isset($this->previousMatchA)){
			$retA='Ganador de '.$this->pMatchAId;
			
			if($this->tournament->getTournamentType()->key=='D'){
				if($this->previousMatchA->getRound_var()!==-1)
					if($this->previousMatchA->getRound_var() < $this->tournament->getMaxValues()['rounds'] / 2 && $this->getRound_var() >= $this->tournament->getMaxValues()['rounds'] / 2)
						$retA='Perdedor de '.$this->pMatchAId;
			}
		}

		if(isset($this->competitor_2))
			$retB = $this->competitor_2->getNickname();
		else if(isset($this->previousMatchB)){
			$retB='Ganador de '.$this->pMatchBId;

			if($this->tournament->getTournamentType()->key=='D'){
				if($this->previousMatchB->getRound_var()!==-1)
					if($this->previousMatchB->getRound_var() < $this->tournament->getMaxValues()['rounds'] / 2 && $this->getRound_var() >= $this->tournament->getMaxValues()['rounds'] / 2)
						$retB='Perdedor de '.$this->pMatchBId;
			}
		}

		if($retA !== "")
			if($retA === $retB)
				$retB='Perdedor de '.$this->previousMatchB->getId();

		return [$ret,$retA,$retB,$this->score_1,$this->score_2];
	}

	public function getCompetitor1(){
		return $this->competitor_1;
	}

	public function getCompetitor2(){
		return $this->competitor_2;
	}

	public function getNicknames(){
		$a1=0;
		$a2=0;
		$c1="";
		$c2="";

		if(isset($this->competitor_1)){
			if($this->competitor_1->getId()==0){
				$c1 = "'".$this->competitor_1->getNickname()."'";
				$a1=1;
			}else{
				$c1=$this->competitor_1->getId();
				$a1=2;
			}
		}

		if(isset($this->competitor_2)){
			if($this->competitor_2->getId()==0){
				$c2 = "'".$this->competitor_2->getNickname()."'";
				$a2=1;
			}else{
				$c2=$this->competitor_2->getId();
				$a2=2;
			}
		}

		return [$a1,$c1,$a2,$c2];
	}

	public function draw(){
		include 'draw_match.php';
	}

	public function setMatchHeight($match_height){
		$this->match_height;
	}

	public function setY($y){
		$this->y = $y;
	}

	public function getNextMatch(){
		return $this->nextMatch;
	}

	public function getNextLoserMatch(){
		return $this->nextLMatch;
	}

	public function setRound($round){
		$this->round = $round;
	}

	public function getRound_var(){
		if(isset($this->round->aux_var))
			return $this->round->aux_var;
		return -1;
	}

	public function setId($id){
		$this->id=$id;
	}

	public function getRound(){
		return $this->round;
	}

	public function getScore1(){
		return $this->score_1;
	}

	public function getScore2(){
		return $this->score_2;
	}

	public function setDBData($match){
		$this->competitor_1=$match->getCompetitor1();
		$this->competitor_2=$match->getCompetitor2();
		$this->score_1=$match->getScore1();
		$this->score_2=$match->getScore2();
		$this->winner=$match->getWinner();
		$this->pMatchAId=$match->getPMatchAId();
		$this->pMatchBId=$match->getPMatchBId();
	}

	public function setPMatchAId($pMatchAId){
		$this->pMatchAId=$pMatchAId;
	}

	public function setPMatchBId($pMatchBId){
		$this->pMatchBId=$pMatchBId;
	}

	public function getPMatchAId(){
		return $this->pMatchAId;
	}

	public function getPMatchBId(){
		return $this->pMatchBId;
	}
}