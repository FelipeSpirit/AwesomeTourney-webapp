<?php
abstract class TournamentType {
	private $name;
	public $key;
	
	function __construct($name, $key) {
		$this->name=$name;
		$this->key=$key;
	}
	
	public function getName(){
		return $this->name;
	}

	public abstract function generateRounds($qCompetitors);
	public abstract function generateMatches($tourney);
	public abstract function chargeMatches($tourney);
}