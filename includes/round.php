<?php
class Round{
	private Array $matches;

	function __construct($round=null, $round_var=0){
		$this->matches=[];
		
		if($round != null){
			foreach ($round->matches as $match) {
				$match_v=new MatchFigure($match);
				$this->matches[]=$match_v;
			}
		}

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