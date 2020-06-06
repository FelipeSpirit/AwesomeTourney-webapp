<?php
class DoubleElimination extends TournamentType{
	private $simpleElimination;

	function __construct() {
		parent::__construct('Eliminación doble','D');
		$this->simpleElimination=new SimpleElimination();
	}

	public function generateRounds($tourney){
		$roundsR=[];
		$roundsR['wRounds'] = $this->simpleElimination->generateMatches($tourney);

		for ($i=0; $i < 2; $i++) { 
			$round= new RoundFigure();
			$round->setRound_var(count($roundsR['wRounds']));
			$round->setTournament($tourney);
			$roundsR['wRounds'][]=$round;	
		}

		$qLosers=$this->calculateLosersRounds(count($tourney->getCompetitors()));

		$roundsR['lRounds']=[];

		for ($i=0; $i < $qLosers; $i++) { 
			$round= new RoundFigure();
			$round->setRound_var(count($roundsR['wRounds'])+$i);
			$round->setTournament($tourney);
			$roundsR['lRounds'][]=$round;	
		}

		return $roundsR;
	}

	public function generateMatches($tourney){
		$roundsR = $this->generateRounds($tourney);
		$wRounds =$roundsR['wRounds'];
		$lRounds  = $roundsR['lRounds'];
		$qCompetitors=count($tourney->getCompetitors());
		$idealRounds=$this->idealRounds($qCompetitors);

		if(pow(2,$idealRounds)==$qCompetitors){
			$res = $qCompetitors / 4;
		} else if(pow(2,$idealRounds) * 3 / 4 >= $qCompetitors){
			$res=$qCompetitors-pow(2,$idealRounds-1);
		}else{
			$res = $qCompetitors-pow(2,$idealRounds) * 3 / 4;
		}

		$qMatch = pow(2, $idealRounds) / 4;
		$iMatch=$qCompetitors;
		$cWRounds=count($wRounds);
		$cLRounds=count($lRounds);
		$auxMatches=null;
		$decRounds=$cWRounds-2;

		$auxMatches=array_merge($wRounds[0]->getMatches(),$wRounds[1]->getMatches());

		for ($index=0,$i=$this->calculateLosersRounds($qCompetitors) - 1; $i >= 0;$index++, $i--) {
			if($cLRounds % 2 == 0 && $index % 2 == 1)
				$decRounds--;
			else if($cLRounds % 2 == 1 && $index % 2 == 0){
				$decRounds--;
			}

			if($i != $this->calculateLosersRounds($qCompetitors) - 1)
				$val=$qMatch;
			else
				$val= $res;

			for ($j=0; $j < $val; $j++) { 
				$match= new MatchFigure($iMatch,$tourney);

				if($i % 2 == 0){
					if($index != 0){
						$cPMatches=count($lRounds[$index - 1]->getMatches());
						
						if($cPMatches==$val){
							$lRounds[$index - 1]->getMatches()[$j]->setNextMatch($match);
							$match->setPreviousMatchA($wRounds[$cWRounds - $decRounds - 2]->getMatches()[$j]);
							$wRounds[$cWRounds - $val - 2]->getMatches()[$j]->setNextLoserMatch($match);
							$match->setPreviousMatchB($lRounds[$index - 1]->getMatches()[$j]);
						}else if($cPMatches < $val){
							if($j < $cPMatches){
								$lRounds[$index - 1]->getMatches()[$j]->setNextMatch($match);
								$match->setPreviousMatchB($lRounds[$index - 1]->getMatches()[$j]);
								$lRounds[$index - 1]->getMatches()[$j]->setNextMatch($match);

								$rand = rand(0,count($auxMatches) - 1);
								$m = $auxMatches[$rand];
								array_splice($auxMatches, $rand, 1);
								$m->setNextLoserMatch($match);
								$match->setPreviousMatchA($m);
							}else{
								$rand = rand(0,count($auxMatches) - 1);
								$m = $auxMatches[$rand];
								array_splice($auxMatches, $rand, 1);
								$m->setNextLoserMatch($match);
								$match->setPreviousMatchA($m);

								$rand = rand(0,count($auxMatches) - 1);
								$m = $auxMatches[$rand];
								array_splice($auxMatches, $rand, 1);
								$m->setNextLoserMatch($match);
								$match->setPreviousMatchB($m);
							}
						}
					}else{
						$rand = rand(0,count($auxMatches) - 1);
						$m = $auxMatches[$rand];
						array_splice($auxMatches, $rand, 1);
						$m->setNextLoserMatch($match);
						$match->setPreviousMatchA($m);

						$rand = rand(0,count($auxMatches) - 1);
						$m = $auxMatches[$rand];
						array_splice($auxMatches, $rand, 1);
						$m->setNextLoserMatch($match);
						$match->setPreviousMatchB($m);
					}
				}else{
					if($index != 0)
						$cPMatches=count($lRounds[$index - 1]->getMatches());
					else
						$cPMatches=0;

					if($cPMatches / 2 == $val){
						$lRounds[$index - 1]->getMatches()[$j * 2]->setNextMatch($match);
						$lRounds[$index - 1]->getMatches()[$j * 2 + 1]->setNextMatch($match);
						$match->setPreviousMatchA($lRounds[$index - 1]->getMatches()[$j * 2]);
						$match->setPreviousMatchB($lRounds[$index - 1]->getMatches()[$j * 2 + 1]);
					}else{
						if($index==0){
							if(count($wRounds[$index]->getMatches()) / 2 == $val){
								$wRounds[$index]->getMatches()[$j * 2]->setNextLoserMatch($match);
								$wRounds[$index]->getMatches()[$j * 2 + 1]->setNextLoserMatch($match);
								$match->setPreviousMatchA($wRounds[$index]->getMatches()[$j * 2]);
								$match->setPreviousMatchB($wRounds[$index]->getMatches()[$j * 2 + 1]);

							}else{
								$rand = rand(0,count($auxMatches) - 1);
								$m = $auxMatches[$rand];
								array_splice($auxMatches, $rand, 1);
								$m->setNextLoserMatch($match);
								$match->setPreviousMatchA($m);

								$rand = rand(0,count($auxMatches) - 1);
								$m = $auxMatches[$rand];
								array_splice($auxMatches, $rand, 1);
								$m->setNextLoserMatch($match);
								$match->setPreviousMatchB($m);
							}
						}else{
							if(count($auxMatches) != 0){
								$rand = rand(0,count($auxMatches) - 1);
								$m = $auxMatches[$rand];
								array_splice($auxMatches, $rand, 1);
								$m->setNextLoserMatch($match);
								$match->setPreviousMatchA($m);

								if(isset($lRounds[$index-1]->getMatches()[$j])){
									$m=$lRounds[$index-1]->getMatches()[$j];
									$m->setNextMatch($match);
									$match->setPreviousMatchB($m);
								}else if(count($auxMatches)>0){
									$rand = rand(0,count($auxMatches) - 1);
									$m = $auxMatches[$rand];
									array_splice($auxMatches, $rand, 1);
									$m->setNextLoserMatch($match);
									$match->setPreviousMatchB($m);
								}
							}else{
								$auxRounds=[];
								foreach ($lRounds[$index-1]->getMatches() as $mm) {
									if($mm->getNextMatch()==null)
										$auxRounds[]=$mm;
								}

								$m=$auxRounds[0];
								$m->setNextMatch($match);
								$match->setPreviousMatchA($m);

								$m=$auxRounds[1];
								$m->setNextMatch($match);
								$match->setPreviousMatchB($m);
							}
						}

					}
				}

				
				$match->setRound($lRounds[$index]);
				$lRounds[$index]->addMatch($match);
				$iMatch++;
			}

			if($i % 2 == 0)
				$qMatch /= 2;
		}


		$match1= new MatchFigure($iMatch,$tourney);
		$match1->setPreviousMatchA($wRounds[count($wRounds) - 3]->getMatches()[0]);
		$wRounds[count($wRounds) - 3]->getMatches()[0]->setNextMatch($match1);

		if(count($lRounds) > 0){
			$match1->setPreviousMatchB($lRounds[count($lRounds) - 1]->getMatches()[0]);
			$lRounds[count($lRounds) - 1]->getMatches()[0]->setNextMatch($match1);
		}else
			$match1->setPreviousMatchB($wRounds[count($wRounds) - 3]->getMatches()[0]);

		
		
		$iMatch++;

		$match2= new MatchFigure($iMatch,$tourney);
		$match2->setPreviousMatchA($match1);
		$match2->setPreviousMatchB($match1);
		$match1->setNextMatch($match2);
		$match1->setNextLoserMatch($match2);

		$wRounds[count($wRounds)-2]->addMatch($match1);
		$wRounds[count($wRounds)-1]->addMatch($match2);

		if(count($wRounds) > count($lRounds)){
			$aux=count($wRounds)-count($lRounds);
			
			for ($i=0; $i < $aux; $i++) { 
				$round= new RoundFigure();
				$round->setTournament($tourney);
				$lRounds[]=$round;
			}
		}else if( count($lRounds) > count($wRounds)){
			$aux=count($lRounds)-count($wRounds);
			
			for ($i=0; $i < $aux; $i++) { 
				$round= new RoundFigure();
				$round->setTournament($tourney);
				$wRounds[]=$round;
			}
		}

		$rounds=array_merge($wRounds,$lRounds);

		$aux_id=1;

		$qRounds=count($rounds);

		for ($i=0; $i < $qRounds; $i++) { 
			$round=$rounds[$i];

			foreach ($round->getMatches() as $match) {
				$match->setId($aux_id);
				$aux_id++;
			}
		}
		return $rounds;
	}

	public function generateMatches2($tourney){
		$roundsR = $this->generateRounds($tourney);
		$wRounds =$roundsR['wRounds'];
		$lRounds  = $roundsR['lRounds'];
		$qCompetitors=count($tourney->getCompetitors());
		$idealRounds=$this->idealRounds($qCompetitors);

		if(pow(2,$idealRounds)==$qCompetitors){
			$res = $qCompetitors / 4;
		} else if(pow(2,$idealRounds) * 3 / 4 >= $qCompetitors){
			$res=$qCompetitors-pow(2,$idealRounds-1);
		}else{
			$res = $qCompetitors-pow(2,$idealRounds) * 3 / 4;
		}

		$qMatch = pow(2, $idealRounds) / 4;
		$iMatch=$qCompetitors;
		$cWRounds=count($wRounds);
		$cLRounds=count($lRounds);
		$decRounds=$cWRounds-2;

		$auxMatches=array_merge($wRounds[0]->getMatches(),$wRounds[1]->getMatches());
		$iAuxMatches=0;

		for ($index=0,$i=$this->calculateLosersRounds($qCompetitors) - 1; $i >= 0;$index++, $i--) {
			if($cLRounds % 2 == 0 && $index % 2 == 1)
				$decRounds--;
			else if($cLRounds % 2 == 1 && $index % 2 == 0){
				$decRounds--;
			}

			if($i != $this->calculateLosersRounds($qCompetitors) - 1)
				$val=$qMatch;
			else
				$val= $res;

			for ($j=0; $j < $val; $j++) { 
				$match= new MatchFigure($iMatch,$tourney);

				if($i % 2 == 0){
					if($index != 0){
						$cPMatches=count($lRounds[$index - 1]->getMatches());
						
						if($cPMatches==$val){
							$lRounds[$index - 1]->getMatches()[$j]->setNextMatch($match);
							$match->setPreviousMatchA($wRounds[$cWRounds - $decRounds - 2]->getMatches()[$j]);
							$wRounds[$cWRounds - $val - 2]->getMatches()[$j]->setNextLoserMatch($match);
							$match->setPreviousMatchB($lRounds[$index - 1]->getMatches()[$j]);
						}else if($cPMatches < $val){
							if($j < $cPMatches){
								$lRounds[$index - 1]->getMatches()[$j]->setNextMatch($match);
								$match->setPreviousMatchB($lRounds[$index - 1]->getMatches()[$j]);
								$lRounds[$index - 1]->getMatches()[$j]->setNextMatch($match);

								$rand = $iAuxMatches;
								$iAuxMatches++;
								$m = $auxMatches[$rand];
								$m->setNextLoserMatch($match);
								$match->setPreviousMatchA($m);
							}else{
								$rand = $iAuxMatches;
								$iAuxMatches++;
								$m = $auxMatches[$rand];
								$m->setNextLoserMatch($match);
								$match->setPreviousMatchA($m);

								$rand = $iAuxMatches;
								$iAuxMatches++;
								$m = $auxMatches[$rand];
								$m->setNextLoserMatch($match);
								$match->setPreviousMatchB($m);
							}
						}
					}else{
						$rand = $iAuxMatches;
						$iAuxMatches++;
						$m = $auxMatches[$rand];
						$m->setNextLoserMatch($match);
						$match->setPreviousMatchA($m);

						$rand = $iAuxMatches;
						$iAuxMatches++;
						$m = $auxMatches[$rand];
						$m->setNextLoserMatch($match);
						$match->setPreviousMatchB($m);
					}
				}else{
					if($index != 0)
						$cPMatches=count($lRounds[$index - 1]->getMatches());
					else
						$cPMatches=0;

					if($cPMatches / 2 == $val){
						$lRounds[$index - 1]->getMatches()[$j * 2]->setNextMatch($match);
						$lRounds[$index - 1]->getMatches()[$j * 2 + 1]->setNextMatch($match);
						$match->setPreviousMatchA($lRounds[$index - 1]->getMatches()[$j * 2]);
						$match->setPreviousMatchB($lRounds[$index - 1]->getMatches()[$j * 2 + 1]);
					}else{
						if($index==0){
							if(count($wRounds[$index]->getMatches()) / 2 == $val){
								$wRounds[$index]->getMatches()[$j * 2]->setNextLoserMatch($match);
								$wRounds[$index]->getMatches()[$j * 2 + 1]->setNextLoserMatch($match);
								$match->setPreviousMatchA($wRounds[$index]->getMatches()[$j * 2]);
								$match->setPreviousMatchB($wRounds[$index]->getMatches()[$j * 2 + 1]);

							}else{
								$rand = $iAuxMatches;
								$iAuxMatches++;
								$m = $auxMatches[$rand];
								$m->setNextLoserMatch($match);
								$match->setPreviousMatchA($m);

								$rand = $iAuxMatches;
								$iAuxMatches++;
								$m = $auxMatches[$rand];
								$m->setNextLoserMatch($match);
								$match->setPreviousMatchB($m);
							}
						}else{
							if(count($auxMatches) != 0){
								$rand = $iAuxMatches;
								$iAuxMatches++;
								$m = $auxMatches[$rand];
								$m->setNextLoserMatch($match);
								$match->setPreviousMatchA($m);

								if(isset($lRounds[$index-1]->getMatches()[$j])){
									$m=$lRounds[$index-1]->getMatches()[$j];
									$m->setNextMatch($match);
									$match->setPreviousMatchB($m);
								}else if(count($auxMatches)>0){
									$rand = $iAuxMatches;
									$iAuxMatches++;
									$m = $auxMatches[$rand];
									$m->setNextLoserMatch($match);
									$match->setPreviousMatchB($m);
								}
							}else{
								$auxRounds=[];
								foreach ($lRounds[$index-1]->getMatches() as $mm) {
									if($mm->getNextMatch()==null)
										$auxRounds[]=$mm;
								}

								$m=$auxRounds[0];
								$m->setNextMatch($match);
								$match->setPreviousMatchA($m);

								$m=$auxRounds[1];
								$m->setNextMatch($match);
								$match->setPreviousMatchB($m);
							}
						}

					}
				}

				
				$match->setRound($lRounds[$index]);
				$lRounds[$index]->addMatch($match);
				$iMatch++;
			}

			if($i % 2 == 0)
				$qMatch /= 2;
		}


		$match1= new MatchFigure($iMatch,$tourney);
		$match1->setPreviousMatchA($wRounds[count($wRounds) - 3]->getMatches()[0]);
		$wRounds[count($wRounds) - 3]->getMatches()[0]->setNextMatch($match1);

		if(count($lRounds) > 0){
			$match1->setPreviousMatchB($lRounds[count($lRounds) - 1]->getMatches()[0]);
			$lRounds[count($lRounds) - 1]->getMatches()[0]->setNextMatch($match1);
		}else
			$match1->setPreviousMatchB($wRounds[count($wRounds) - 3]->getMatches()[0]);

		
		
		$iMatch++;

		$match2= new MatchFigure($iMatch,$tourney);
		$match2->setPreviousMatchA($match1);
		$match2->setPreviousMatchB($match1);
		$match1->setNextMatch($match2);
		$match1->setNextLoserMatch($match2);

		$wRounds[count($wRounds)-2]->addMatch($match1);
		$wRounds[count($wRounds)-1]->addMatch($match2);

		if(count($wRounds) > count($lRounds)){
			$aux=count($wRounds)-count($lRounds);
			
			for ($i=0; $i < $aux; $i++) { 
				$round= new RoundFigure();
				$round->setTournament($tourney);
				$lRounds[]=$round;
			}
		}else if( count($lRounds) > count($wRounds)){
			$aux=count($lRounds)-count($wRounds);
			
			for ($i=0; $i < $aux; $i++) { 
				$round= new RoundFigure();
				$round->setTournament($tourney);
				$wRounds[]=$round;
			}
		}

		$rounds=array_merge($wRounds,$lRounds);

		$aux_id=1;

		$qRounds=count($rounds);

		for ($i=0; $i < $qRounds; $i++) { 
			$round=$rounds[$i];

			foreach ($round->getMatches() as $match) {
				$match->setId($aux_id);
				$aux_id++;
			}
		}
		return $rounds;
	}

	public function chargeMatches($tourney){
		$rounds = $this->generateMatches2($tourney);
		$matches= $tourney->getMatches();

		$k=0;

		for ($i=0; $i < count($rounds); $i++) {
			for ($j=0; $j < count($rounds[$i]->getMatches()); $j++) { 
				$rounds[$i]->getMatches()[$j]->setDBData($matches[$k]);
				$k++;
			}
		}
		return $rounds;
	}

	private function idealRounds($competitors){
		return ceil(log10($competitors) / log10(2));
	}

	private function roundAddition($competitors){

		if(($competitors - 1 > (pow(2, $this->idealRounds($competitors - 1)) * 3 / 4)) == ($competitors > (pow(2, $this->idealRounds($competitors)) * 3 / 4)))
			return 0;
		else
			return 1;
	}

	private function calculateLosersRounds($competitors){
		$r=0;
		
		for ($i=2; $i <= $competitors; $i++) { 
			$r+=$this->roundAddition($i);
		}

		return $r;
	}
}
?>