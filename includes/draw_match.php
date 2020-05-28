<?php
if(isset($this->previousMatchB)){
	$this->y=$this->previousMatchA->y + ($this->previousMatchB->y - $this->previousMatchA->y) / 2;
}
?>
								<svg x="0" y="<?php echo $this->y;?>" height="<?php echo $this->match_height; ?>" class="graph-match">
									<rect class="graph-match-rect" x="10" y="0" rx="5" ry="5" width="150" height="<?php echo $this->match_height; ?>"/>
									<svg class="grap-match-header" x="10" y="2" width="28" height="<?php echo $this->match_height; ?>">
										<rect class="grap-match-header-rect" x="3" y="1" rx="5" ry="5" width="26" height="49"/>
										<text class="grap-match-header-text" x="7" y="32" font-size="16"><?php echo $this->getData()[0]; ?></text>
									</svg>

									<svg x="40" y="2" height="25" class="graph-competitor">
										<rect class="graph-competitor-rect" x="1" y="1" rx="5" ry="5" width="116" height="23"/>
										<text class="graph-competitor-text" x="10" y="18" font-size="15" ><?php echo $this->getData()[1]; ?></text>
									</svg>

									<svg x="40" y="28" height="25" class="graph-competitor">
										<rect class="graph-competitor-rect" x="1" y="1" rx="5" ry="5" width="116" height="23"/>
										<text class="graph-competitor-text" x="10" y="18" font-size="15" ><?php echo $this->getData()[2]; ?></text>
									</svg>

									<?php if(isset($this->nextMatch)):?>
									<line x1="160" y1="28" x2="200" y2="28" style="stroke-width:2; stroke:var(--dark);"/>
									<?php endif; ?>

									<?php if(isset($this->previousMatchA)):?>
										<line x1="1" y1="28" x2="10" y2="28" style="stroke-width:2; stroke:var(--dark);"/>
										<line x1="1" y1="0" x2="1" y2="56" style="stroke-width:2; stroke:var(--dark);"/>
									<?php endif; ?>
								</svg>