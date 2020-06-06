<?php
class RoundFigure implements Figure {
	private $round_var;
	public $aux_var;
	private $name;
	private $matches;
	private $tourney;

	function __construct(){
		$this->matches = [];
	}

	public function addMatch(MatchFigure $match){
		$match->setRound($this);
		$this->matches[] = $match;
	}

	public function getInfo(){
		$ret=$this->round_var.' ';

		foreach ($this->matches as $match) {
			$ret = $ret.$match->getInfo().' |||| ';	
		}

		return $ret.'<br>';
	}

	public function getMatches(){
		return $this->matches;
	}

	public function setRound_var($round_var){
		$this->round_var = $round_var;
		$this->aux_var = $round_var;
	}

	public function getRound_var(){
		return $this->round_var;
	}

	public function setName($name){
		$this->name = $name;
	}

	public function draw(){
		include 'draw_round.php';
	}

	public function setTournament($tourney){
		$this->tourney = $tourney;
	}

	public function getTournament(){
		return $this->tourney;
	}
}