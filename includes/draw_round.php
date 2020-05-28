<?php 
$match_height=55;
?>	
						<svg class="graph-round"x="<?php echo $this->round_var * 200; ?>" y="0" width="200">
							<?php
							$match_var = 0;
							$aux_matches = 0;

							foreach ($this->getMatches() as $match){
								$match->setY($aux_matches);
								$match->draw();
								$aux_matches += $match_height + ($match_var % 2 == 0 ? 10 : 20);
								$match_var++;
							}
							?>
						</svg>