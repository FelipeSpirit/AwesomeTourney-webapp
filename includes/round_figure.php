<?php
class RoundFigure implements Figure {
	private $round_var;
	private Array $matches;

	function __construct(){
		$this->matches = [];
	}

	public function addMatch(MatchFigure $match){
		$this->matches[] = $match;
	}

	public function getInfo(){
		$ret="";

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
	}

	public function draw(){
		include 'draw_round.php';
	}
}