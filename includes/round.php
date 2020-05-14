<?php
class Round{
	private Array $matches;

	function __construct(){
		$this->matches=[];
	}

	public function addMatch(Match $match){
		$this->matches[]=$match;
	}

	public function getInfo(){
		$ret="";

		foreach ($this->matches as $match) {
			$ret=$ret.$match->getInfo().' |||| ';	
		}

		return $ret.'<br>';
	}

	public function getMatches(){
		return $this->matches;
	}
}