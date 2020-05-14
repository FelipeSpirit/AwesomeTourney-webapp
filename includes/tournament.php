<?php
class Tournament {
	private $name;
	private TournamentType $type;
	private Array $competitors;
	private Array $rounds;


    function __construct($name, TournamentType $type) {
    	$this->name=$name;
    	$this->type=$type;
    	$this->competitors=[];
    	$this->rounds=[];
    }

    function addCompetitor(Competitor $competitor) {
    	$this->competitors[]=$competitor;
    	$this->generateRounds();
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


	private function generateRounds(){
		$this->rounds=[];
		for ($i=0; $i < round(log10(count($this->competitors)) / log10(2)); $i++) { 
			$this->rounds[]=new Round();
		}

		$competitors=$this->competitors;
		$matches=[];
		$quantity=1;

		while(count($competitors)>0){
			$rand=rand(0,count($competitors)-1);
			$c1=$competitors[$rand];
			array_splice($competitors, $rand, 1);
			
			if(count($competitors)===0)
				$matches[] = new Match($quantity,$this, $c1);
			else{
				$rand=rand(0,count($competitors)-1);
				$c2=$competitors[$rand];
				array_splice($competitors, $rand, 1);
				$matches[]=new Match($quantity,$this,$c1,$c2);
			}
			$quantity++;
		}

		if(isset($this->rounds[0])){
			if(pow(2, count($this->rounds))==count($this->competitors)){
				foreach ($matches as $match) {
					$this->rounds[0]->addMatch($match);
				}

				$auxVal=count($matches);

				for ($i=1; $i < count($this->rounds); $i++) {
					$auxVal=$auxVal/2;

					for ($j=0; $j < $auxVal; $j++) {
						$match=new Match($quantity);
						$pMatchA=$this->rounds[$i-1]->getMatches()[$j*2];
						$pMatchB=$this->rounds[$i-1]->getMatches()[$j*2+1];
						$match->setPreviousMatches($pMatchA,$pMatchB);
						$pMatchA->setNextMatch($match);
						$pMatchB->setNextMatch($match);
						$this->rounds[$i]->addMatch($match);
						$this->rounds[$i-1]->getMatches()[$j*2]=$pMatchA;
						$this->rounds[$i-1]->getMatches()[$j*2+1]=$pMatchB;
						$quantity++;
					}
				}
			}else{
				$res=pow(2, count($this->rounds))-count($this->competitors);
			}
		}
	}

	public function getRounds(){
		return $this->rounds;
	}
}