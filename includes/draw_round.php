<?php 
$this->aux_var=$this->round_var;
$match_height = 55;
$header_height = 20;


$ya=0;
$ha = $this->tourney->getMaxValues()['matches'] * 70 + 50;

if($this->tourney->getTournamentType()->key=='D')
	if($this->round_var >= $this->tourney->getMaxValues()['rounds'] / 2){
		$ya = $ha;
		$this->round_var-=$this->tourney->getMaxValues()['rounds'] / 2;
	}

$dark='';

if(isset($_COOKIE['dark']))
	$dark= '-dark';
?>						
						<svg class="graph-round" 
							x="<?php echo $this->round_var * 200; ?>" 
							y="<?php echo $ya;?>" 
							width="200"
							height="<?php echo $ha; ?>">
							<svg x="0" y="0" height="<?php echo $header_height; ?>">
								<rect class="graph-round-header-rect<?php echo $dark; ?>" x="0" width="200" height="20"/>
								<text class="graph-round-header-text<?php echo $dark; ?>" x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-size="12"><?php if($this->name == null) echo 'Round '.($this->round_var + 1); else echo $this->name.'A'; ?></text>
								<line x1="0" y1="<?php echo $header_height-1; ?>" x2="200" y2="<?php echo $header_height-1; ?>" style="stroke-width:1; stroke:gray;" />
								
								<line x1="199" y1="1" x2="199" y2="19" style="stroke-width:1; stroke:gray;" />
							</svg>
							<?php
							$match_var = 0;
							$aux_matches = 0;

							foreach ($this->getMatches() as $match){
								$match->setY($aux_matches + $header_height + 10);
								$match->draw();
								$aux_matches += $match_height + ($match_var % 2 == 0 ? 10 : 20);
								$match_var++;
							}
							?>
						</svg>