<?php
$roundType=$this->round->getTournament()->getTournamentType()->key;

if($roundType == 'S'){
	$midd=0;
	
	if(isset($this->previousMatchB)){
		if(isset($this->previousMatchA))
			$this->y=$this->previousMatchA->y + ($this->previousMatchB->y - $this->previousMatchA->y) / 2;
		else
			$this->y=$this->previousMatchB->y;
	}
}else if($roundType == 'D'){
	$midd = $this->round->getTournament()->getMaxValues()['rounds'] / 2;

	if($this->round->aux_var < $midd){
		if(isset($this->previousMatchA)){
			if($this->previousMatchA->round->aux_var < $midd){
				$this->y=$this->previousMatchA->y;

				if(isset($this->previousMatchB)){
					if($this->previousMatchB->round->aux_var < $midd)
						$this->y=$this->previousMatchA->y + ($this->previousMatchB->y - $this->previousMatchA->y) / 2;
				}
			}else if(isset($this->previousMatchB)){
				if($this->previousMatchB->round->aux_var < $midd)
					$this->y=$this->previousMatchB->y;
			}
		}else if(isset($this->previousMatchB)){
			if($this->previousMatchB->round->aux_var < $midd)
				$this->y=$this->previousMatchB->y;
		}
	}else{
		if(isset($this->previousMatchA)){
			if($this->previousMatchA->round->aux_var >= $midd){
				$this->y=$this->previousMatchA->y;

				if(isset($this->previousMatchB)){
					if($this->previousMatchB->round->aux_var >= $midd)
						$this->y=$this->previousMatchA->y + ($this->previousMatchB->y - $this->previousMatchA->y) / 2;
				}
			}else if(isset($this->previousMatchB)){
				if($this->previousMatchB->round->aux_var >= $midd)
					$this->y=$this->previousMatchB->y;
			}
		}else if(isset($this->previousMatchB)){
			if($this->previousMatchB->round->aux_var >= $midd)
				$this->y=$this->previousMatchB->y;
		}
	}
}

$x = 25;
$margin=1;

$width = 150;
$width_header = 20;
$width_competitor = $width - $width_header * 2 - $margin*4;

$dark='';

if(isset($_COOKIE['dark']))
	$dark= '-dark';

?>
								<svg class="graph-conection"
									x="0"
									y="0"
									width="<?php echo $x * 2 + $width; ?>"
									heigth="<?php echo $this->match_height; ?>">
									<?php 
									if(isset($this->nextMatch))
										if(($this->nextMatch->round->aux_var < $midd 
												&& $this->round->aux_var < $midd)
											||($this->nextMatch->round->aux_var >= $midd 
												&& $this->round->aux_var >= $midd)
											||$roundType == 'S'):?>
										<line class="bracket-line<?php echo $dark; ?>" 
											x1="<?php echo $x + $width; ?>" 
											y1="<?php echo $this->y+$this->match_height / 2; ?>" 
											x2="200" 
											y2="<?php echo $this->y+$this->match_height / 2; ?>"/>
									<?php 
										endif; 

									if(isset($this->previousMatchB))
										if(($this->round->aux_var < $midd)
											||($this->round->aux_var >= $midd 
												&& $this->previousMatchB->round->aux_var>=$midd)
											||$roundType=='S'):?>
										<line  class="bracket-line<?php echo $dark; ?>" 
											x1="0" 
											y1="<?php echo $this->y+$this->match_height / 2; ?>" 
											x2="<?php echo $x; ?>" 
											y2="<?php echo $this->y+$this->match_height / 2; ?>"/>
									<?php 
									endif;?>
								</svg>

								<?php 
								if(isset($this->previousMatchA))
									if(($this->round->aux_var < $midd 
											&& $this->previousMatchB->round->aux_var<$midd)
										||($this->round->aux_var >= $midd 
											&& $this->previousMatchA->round->aux_var>=$midd)
										||$roundType=='S'):?>
									<svg class="graph-connection-line"
										x="0" 
										y="<?php echo $this->match_height / 2 + $this->previousMatchA->y-1;?>" width="100" 
										height="<?php echo 1 + $this->previousMatchB->y-$this->previousMatchA->y; ?>">
										<line class="bracket-line<?php echo $dark; ?>"
											x1="1" 
											y1="0" 
											x2="1" 
											y2="<?php echo 1 + $this->previousMatchB->y-$this->previousMatchA->y; ?>" />
											<text class="graph-match-header-text<?php echo $dark; ?>" x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-size="9"><?php echo $this->getData()[0]; ?></text>
									</svg>
								<?php 
								endif;?>

								<svg class="graph-match" 
									x="<?php echo $x;?>" 
									y="<?php echo $this->y;?>" 
									width="<?php echo $width;?>"
									height="<?php echo $this->match_height; ?>">


									<rect class="graph-match-rect<?php echo $dark; ?>" 
									x="0" 
									y="0"  
									width="<?php echo $width; ?>" 
									height="<?php echo $this->match_height; ?>"
									rx="5" ry="5"/>

									<svg class="graph-match-header" 
										x="<?php echo $margin; ?>" 
										y="<?php echo $margin; ?>" 
										width="<?php echo $width_header;?>" 
										height="<?php echo $this->match_height-$margin*2; ?>">

										<rect class="graph-match-header-rect<?php echo $dark; ?>" 
										x="0" 
										y="0" 
										width="<?php echo $width_header;?>" 
										height="<?php echo $this->match_height-$margin*2; ?>" 
										rx="5" ry="5"/>

										<rect class="graph-match-header-rect<?php echo $dark; ?>" 
										x="<?php echo $width_header/2;?>" 
										y="0" 
										width="<?php echo $width_header/2;?>" 
										height="<?php echo $this->match_height-$margin*2; ?>"/>

										<text class="graph-match-header-text<?php echo $dark; ?>" x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-size="9"><?php echo $this->getData()[0]; ?></text>
									</svg>

									<svg class="graph-competitor" 
										x="<?php echo $width_header + $margin * 2;?>" 
										y="<?php echo $margin; ?>" 
										width="<?php echo $width_competitor; ?>"
										height="<?php echo ($this->match_height-$margin * 3) / 2; ?>"
										>

										<rect class="graph-competitor-rect<?php echo $dark; ?> <?php if($this->winner==0) echo 'graph-winner'; ?>" 
										x="0" 
										y="0" 
										width="<?php echo $width_competitor;?>" 
										height="<?php echo ($this->match_height-$margin * 3) / 2; ?>"/>

										<text class="graph-competitor-text<?php echo $dark; ?>" 
											x="5" 
											y="52%" 
											font-size="14" dominant-baseline="middle">
											<?php echo $this->getData()[1]; ?>
										</text>
									</svg>

									<svg class="graph-competitor" 
										x="<?php echo $width_header + $margin * 2;?>" 
										y="<?php echo ($this->match_height-$margin * 3) / 2 + $margin * 2; ?>" 
										width="<?php echo $width_competitor;?>"
										height="<?php echo ($this->match_height-$margin * 3) / 2; ?>"
										>

										<rect class="graph-competitor-rect<?php echo $dark; ?> <?php if($this->winner==1) echo 'graph-winner'; ?>" 
										x="0" 
										y="0" 
										width="<?php echo $width_competitor;?>" 
										height="<?php echo ($this->match_height-$margin * 3) / 2; ?>"/>

										<text class="graph-competitor-text<?php echo $dark; ?>" 
											x="5" 
											y="52%" font-size="14" dominant-baseline="middle">
											<?php echo $this->getData()[2]; ?>
										</text>
									</svg>

									<svg class="graph-score" 
										x="<?php echo $width_header + $width_competitor + $margin * 3;?>"
										y="<?php echo $margin; ?>"
										width="<?php echo $width_header;?>"
										height="<?php echo ($this->match_height-$margin * 3) / 2; ?>">
								

										<path class="graph-score-rect<?php echo $dark; ?>" 
											d="M 0 0 H <?php echo $width_header * 3 / 4; ?> Q <?php echo $width_header; ?> 0 <?php echo $width_header; ?> <?php echo $width_header / 4; ?> V <?php echo ($this->match_height-$margin * 3) / 2; ?> H 0 Z"/>

										<text class="graph-score-text<?php echo $dark; ?>" x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" font-size="12"><?php echo $this->getData()[3]; ?></text>
									</svg>

									<svg class="graph-score" 
										x="<?php echo $width_header + $width_competitor + $margin * 3;?>"
										y="<?php echo ($this->match_height-$margin * 3) / 2 + $margin * 2; ?>"
										width="<?php echo $width_header;?>"
										height="<?php echo ($this->match_height-$margin * 3) / 2; ?>">

										<path class="graph-score-rect<?php echo $dark; ?>" 
											d="M 0 0 H <?php echo $width_header; ?> V <?php echo ($this->match_height - $margin * 3) / 2 - $width_header / 4; ?> Q <?php echo $width_header; ?> <?php echo ($this->match_height-$margin * 3) / 2; ?> <?php echo $width_header * 3 / 4; ?> <?php echo ($this->match_height-$margin * 3) / 2; ?> H 0 Z"/>

											<text class="graph-score-text<?php echo $dark; ?>" x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-size="12"><?php echo $this->getData()[4]; ?></text>
									</svg>
								</svg>

							<?php 
							if(isset($_SESSION['user'])):
								global $user;
								global $owner;
								if($owner==$user->getId()):
									if (isset($this->competitor_1) && isset($this->competitor_2)): ?>
									<svg class="graph-config" 
										x="<?php echo $x  +$width - $width_header;?>" 
										y="<?php echo $this->y;?>" 
										width="<?php echo 25+$width_header;?>"
										height="<?php echo $this->match_height; ?>">

										<path class="graph-config-rect"
											d="M 17 <?php echo ($this->match_height-$margin * 3) / 2+1; ?> 
											L <?php echo $width_header; ?> <?php echo ($this->match_height-$margin * 3) / 2 - 2; ?> 
											V <?php echo ($this->match_height-$margin * 3) / 2 - 9; ?> 
											Q <?php echo $width_header; ?> <?php echo ($this->match_height-$margin * 3) / 2 - 14; ?> <?php echo $width_header+5; ?> <?php echo ($this->match_height-$margin * 3) / 2 - 14; ?> 
											H 40
											Q 45 <?php echo ($this->match_height-$margin * 3) / 2 - 14; ?> 45 <?php echo ($this->match_height-$margin * 3) / 2 - 9; ?>
											V <?php echo ($this->match_height-$margin * 3) / 2 + 9; ?> 
											Q 45 <?php echo ($this->match_height-$margin * 3) / 2 + 14; ?> 40 <?php echo ($this->match_height-$margin * 3) / 2 + 14; ?> 
											H 25
											Q <?php echo $width_header; ?> <?php echo ($this->match_height-$margin * 3) / 2 + 14; ?> <?php echo $width_header; ?> <?php echo ($this->match_height-$margin * 3) / 2 + 9; ?> 
											V <?php echo ($this->match_height-$margin * 3) / 2 + 4; ?> Z" />

										<a href="javascript:showScoreModal(<?php echo $this->getData()[0];?>,
										<?php
										if(isset($this->nextMatch)){
											$a=2;
											if($this->nextMatch->previousMatchB->getId()==$this->id){
												$a= 1;
											}else{
												$a= 0;
											}

											if(isset($this->nextLMatch))
												if(isset($this->nextMatch->previousMatchA))
													if($this->nextMatch->previousMatchA->getId()==$this->nextMatch->previousMatchB->getId())
														$a= 0;

											echo $a;
										}else
											echo 2;?>,
										<?php
										if(isset($this->nextLMatch)){
											if($this->nextLMatch->previousMatchB->getId()==$this->id){
												echo 1;
											}else{
												echo 0;
											}
										}else
											echo 2;?>);">
											<path class="graph-config-play" 
											d="M <?php echo $width_header + 6; ?> <?php echo ($this->match_height-$margin * 3) / 2 - 10; ?> 
											L <?php echo $width_header + 21; ?> <?php echo ($this->match_height-$margin * 3) / 2 + 0; ?> 
											L <?php echo $width_header + 6; ?> <?php echo ($this->match_height-$margin * 3) / 2 + 10; ?> Z"/>
										</a>
											}
									</svg>
							<?php 
									endif;
								endif;
							endif; ?>
