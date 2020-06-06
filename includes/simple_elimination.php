<?php
class SimpleElimination extends TournamentType{
	function __construct() {
		parent::__construct('Eliminación simple','S');
	}

	public function generateRounds($tourney){
		$rounds=[];
		
		for ($i=0; $i < ceil(log10(count($tourney->getCompetitors())) / log10(2)); $i++) {
			$round = new RoundFigure();
			$round->setRound_var($i);
			$round->setTournament($tourney);
			$rounds[] = $round;
		}

		$qRounds = count($rounds);

		return $rounds;
	}

	public function generateMatches($tourney){
		$competitors=$tourney->getCompetitors();
		$qCompetitors=count($competitors);
		$rounds=$this->generateRounds($tourney);
		$matches=[];
		$quantity=1;

		if($qCompetitors == pow(2, count($rounds)))
			$res = 0;
		else
			$res = $qCompetitors - pow(2, count($rounds)-1);

		$auxM=$res;

		if($res > 0){
			while($res > 0){
				$rand=rand(0,count($competitors)-1);
				$c1=$competitors[$rand];
				array_splice($competitors, $rand, 1);

				$rand=rand(0,count($competitors)-1);
				$c2=$competitors[$rand];
				array_splice($competitors, $rand, 1);
				$matches[] = new MatchFigure($quantity,$tourney,$c1,$c2);

				$quantity++;
				$res--;
			}

			$res = $qCompetitors - pow(2, count($rounds) - 1);
			$matches_aux = [];
			$sup = pow(2, count($rounds) -1 ) / 2;
			$q = $quantity + $sup - 1;

			while($sup > 0){
				if(pow(2, count($rounds)-1) / 2 > $res)
					$q = $quantity;

				if(count($competitors) > 0){
					$rand = rand(0,count($competitors) - 1);
					$c1 = $competitors[$rand];
					array_splice($competitors, $rand, 1);
					
					if($auxM > 0){
						$matches_aux[] = new MatchFigure($q, $tourney, $c1);
						$auxM--;
					}else{
						$rand=rand(0,count($competitors) - 1);
						$c2=$competitors[$rand];
						array_splice($competitors, $rand, 1);
						$matches_aux[] = new MatchFigure($q, $tourney, $c1, $c2);
					}
				}else{
					$matches_aux[] = new MatchFigure($q, $tourney);
				}

				$q--;
				$sup--;
				$quantity++;
			}

			if(pow(2, count($rounds)-1) / 2 <= $res)
				for ($i=count($matches_aux)-1; $i >= 0; $i--) { 
					$matches[]=$matches_aux[$i];
				}
			else
				for ($i=0; $i < count($matches_aux); $i++) { 
					$matches[]=$matches_aux[$i];
				}

			$q=count($matches);

			for ($i=0; $i < $qCompetitors - $q;$i++) { 
				$matches[] = new MatchFigure($quantity,$tourney);
				$quantity++;
			}
		}else{
			while(count($competitors) > 0){
				$rand=rand(0,count($competitors)-1);
				$c1=$competitors[$rand];
				array_splice($competitors, $rand, 1);
				
				$rand=rand(0,count($competitors)-1);
				$c2=$competitors[$rand];
				array_splice($competitors, $rand, 1);
				$matches[]=new MatchFigure($quantity,$tourney,$c1,$c2);
				$quantity++;
			}

			while ($quantity < pow(2, count($rounds))) {
				$matches[]= new MatchFigure($quantity,$tourney);
				$quantity++;
			}
		}
		
		if(isset($rounds[0])){
			if(pow(2, count($rounds)) == $qCompetitors){
				$q_matches=$qCompetitors/2;
				$index=0;

				for ($i=0; $i < $q_matches; $i++) {
					$rounds[0]->addMatch($matches[$i]);
					$index++;
				}

				for ($i=1; $i < count($rounds); $i++) { 
					$q_matches = $q_matches / 2;

					for ($j=0; $j < $q_matches; $j++) { 
						$match=$matches[$index];
						$pMatchA=$rounds[$i-1]->getMatches()[$j*2];
						$pMatchB=$rounds[$i-1]->getMatches()[$j*2+1];
						$match->setPreviousMatches($pMatchA,$pMatchB);
						$pMatchA->setNextMatch($match);
						$pMatchB->setNextMatch($match);
						$rounds[$i]->addMatch($match);
						$rounds[$i-1]->getMatches()[$j*2]=$pMatchA;
						$rounds[$i-1]->getMatches()[$j*2+1]=$pMatchB;
						$index++;
					}
				}
			}else{
				$res = $qCompetitors - pow(2, count($rounds) - 1);
				$index = 0;
				
				for ($i=0; $i < $res; $i++) { 
					$rounds[0]->addMatch($matches[$i]);
					$index++;
				}

				$q_matches = pow(2, count($rounds) - 1) / 2;

				for ($i=$res; $i < $q_matches + $res; $i++) {
					$rounds[1]->addMatch($matches[$i]);
					$index++;
				}

				for ($i=2; $i < count($rounds); $i++) { 
					$q_matches = $q_matches / 2;

					for ($j=0; $j < $q_matches; $j++) { 
						$match=$matches[$index];
						$pMatchA=$rounds[$i - 1]->getMatches()[$j*2];
						$pMatchB=$rounds[$i - 1]->getMatches()[$j*2+1];
						$match->setPreviousMatches($pMatchA,$pMatchB);
						$pMatchA->setNextMatch($match);
						$pMatchB->setNextMatch($match);
						$rounds[$i]->addMatch($match);
						$rounds[$i-1]->getMatches()[$j*2]=$pMatchA;
						$rounds[$i-1]->getMatches()[$j*2+1]=$pMatchB;
						$index++;
					}
				}


				if($res <= pow(2, count($rounds)-1) / 2)
					for ($i=0; $i < $res; $i++) {
						$rounds[1]->getMatches()[$i]->setPreviousMatchB($rounds[0]->getMatches()[$i]);
						$rounds[0]->getMatches()[$i]->setNextMatch($rounds[1]->getMatches()[$i]);
					}
				else{
					$res2=$res-pow(2, count($rounds)-1) / 2;
					$sRes=$res2;
					$aux=0;

					for ($i=0; $i < $res-$sRes; $i++) {
						if($res2!==0){
							$rounds[1]->getMatches()[$i]->setPreviousMatches(
								$rounds[0]->getMatches()[$aux],
								$rounds[0]->getMatches()[$aux + 1]);
							$rounds[0]->getMatches()[$aux]->setNextMatch($rounds[1]->getMatches()[$i]);
							$rounds[0]->getMatches()[$aux+1]->setNextMatch($rounds[1]->getMatches()[$i]);

							if($res2!==0){
							  	$aux+=2;
							}

							$res2--;
						} else{
							$rounds[1]->getMatches()[$i]->setPreviousMatchB($rounds[0]->getMatches()[$aux]);
							$rounds[0]->getMatches()[$aux]->setNextMatch($rounds[1]->getMatches()[$i]);
					  		$aux++;
						}
					}
				}
			}
		}

		return $rounds;
	}

	public function chargeMatches($tourney){
		$competitors = $tourney->getCompetitors();
		$qCompetitors = count($competitors);
		$rounds = $this->generateRounds($tourney);
		$matches = $tourney->getMatches();
		$quantity = 1;

		if(isset($rounds[0])){
			if(pow(2, count($rounds)) == $qCompetitors){
				$q_matches = $qCompetitors / 2;
				$index=0;

				for ($i=0; $i < $q_matches; $i++) {
					$rounds[0]->addMatch($matches[$i]);
					$index++;
				}

				for ($i=1; $i < count($rounds); $i++) { 
					$q_matches = $q_matches / 2;

					for ($j=0; $j < $q_matches; $j++) { 
						$match=$matches[$index];
						$pMatchA=$rounds[$i-1]->getMatches()[$j*2];
						$pMatchB=$rounds[$i-1]->getMatches()[$j*2+1];
						$match->setPreviousMatches($pMatchA,$pMatchB);
						$pMatchA->setNextMatch($match);
						$pMatchB->setNextMatch($match);
						$rounds[$i]->addMatch($match);
						$rounds[$i-1]->getMatches()[$j*2]=$pMatchA;
						$rounds[$i-1]->getMatches()[$j*2+1]=$pMatchB;
						$index++;
					}
				}
			}else {
				$res=$qCompetitors-pow(2, count($rounds)-1);
				$index=0;
				
				for ($i=0; $i < $res; $i++) { 
					$rounds[0]->addMatch($matches[$i]);
					$index++;
				}

				$q_matches=pow(2, count($rounds)-1) / 2;

				for ($i=$res; $i < $q_matches + $res; $i++) {
					$rounds[1]->addMatch($matches[$i]);
					$index++;
				}

				for ($i=2; $i < count($rounds); $i++) { 
					$q_matches = $q_matches / 2;

					for ($j=0; $j < $q_matches; $j++) { 
						$match=$matches[$index];
						$pMatchA=$rounds[$i-1]->getMatches()[$j*2];
						$pMatchB=$rounds[$i-1]->getMatches()[$j*2+1];
						$match->setPreviousMatches($pMatchA,$pMatchB);
						$pMatchA->setNextMatch($match);
						$pMatchB->setNextMatch($match);
						$rounds[$i]->addMatch($match);
						$rounds[$i-1]->getMatches()[$j*2]=$pMatchA;
						$rounds[$i-1]->getMatches()[$j*2+1]=$pMatchB;
						$index++;
					}
				}


				if($res <= pow(2, count($rounds)-1) / 2)
					for ($i=0; $i < $res; $i++) {
						$rounds[1]->getMatches()[$i]->setPreviousMatchB($rounds[0]->getMatches()[$i]);
						$rounds[0]->getMatches()[$i]->setNextMatch($rounds[1]->getMatches()[$i]);
					}
				else{
					$res2 = $res - pow(2, count($rounds)-1) / 2;
					$sRes = $res2;
					$aux=0;

					for ($i=0; $i < $res-$sRes; $i++) {
						if($res2!==0){
							$rounds[1]->getMatches()[$i]->setPreviousMatches(
								$rounds[0]->getMatches()[$aux],
								$rounds[0]->getMatches()[$aux + 1]);
							$rounds[0]->getMatches()[$aux]->setNextMatch($rounds[1]->getMatches()[$i]);
							$rounds[0]->getMatches()[$aux+1]->setNextMatch($rounds[1]->getMatches()[$i]);

							if($res2!==0){
							  	$aux+=2;
							}

							$res2--;
						} else{
							$rounds[1]->getMatches()[$i]->setPreviousMatchB($rounds[0]->getMatches()[$aux]);
							$rounds[0]->getMatches()[$aux]->setNextMatch($rounds[1]->getMatches()[$i]);
					  		$aux++;
						}
					}
				}
			}
		}

		return $rounds;
	}
}