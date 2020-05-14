<?php
include '../includes/person.php';
include '../includes/competitor.php';
include '../includes/match.php';
include '../includes/round.php';
include '../includes/tournament_type.php';
include '../includes/simple_elimination.php';
include '../includes/tournament.php';

$type= new SimpleElimination();

$tournament= new Tournament('Torneo Setup Team', $type);

$competitor1 = new Competitor(1, 'Felipe');
$competitor2 = new Competitor(2, 'Luis');
$competitor3 = new Competitor(3, 'Yohan');
$competitor4 = new Competitor(4, 'Fabian C');
$competitor5 = new Competitor(5, 'David');
$competitor6 = new Competitor(6, 'Daniel');
$competitor7 = new Competitor(7, 'Diego');
$competitor8 = new Competitor(8, 'Fabian R');

$tournament->addCompetitor($competitor1);
$tournament->addCompetitor($competitor2);
$tournament->addCompetitor($competitor3);
$tournament->addCompetitor($competitor4);
$tournament->addCompetitor($competitor5);
$tournament->addCompetitor($competitor6);
$tournament->addCompetitor($competitor7);
$tournament->addCompetitor($competitor8);
?>

<!DOCTYPE html>
<html class="h-100">
<head>
	<title><?php echo $tournament->getName(); ?> | Awesome Tourney</title>
	<link rel="shortcut icon" href="/images/favicon.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
</head>

<body class="d-flex flex-column h-100">

	<header>
		<div class="navbar navbar-dark static-top shadow-sm">
			<div class="container d-flex justify-content-between">
				<a class="navbar-brand" href="/">
					<div class="header-logo">
						<img id="header-logo" src="/images/logo.png">
					</div>
				</a>

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
			</div>
		</div>

		<div class="collapse bg-dark" id="navbarHeader">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-12 py-4">
						<h4 class="text-white">Gestionar torneos</h4>
						<p class="text-muted"></p>
					</div>
					
				</div>
			</div>
		</div>
	</header>

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<label><h1><?php echo $tournament->getName(); ?></h1></label>
			</div>

			<div class="col-lg-12">
				<div>
					<svg width="1000"  height="<?php echo count($tournament->getRounds()[0]->getMatches())*80; ?>">
						<?php
						$round_var=0;
						foreach ($tournament->getRounds() as $round):
						?>
						<svg class="graph-round"x="<?php echo $round_var*180; ?>" y="<?php echo $round_var*33; ?>" width="150">
							<?php
							$match_var=0;
							foreach ($round->getMatches() as $match):
							?>
								<svg x="0" y="<?php echo $match_var*65; ?>" height="55" class="graph-match">
									<rect x="0" y="0" width="150" height="55" style="fill:gray" />
									<svg x="0" y="0" width="28" height="55" height="55">
										<rect x="1" y="1" width="28" height="53" style="fill:lightblue;"/>
										<text x="8" y="35" font-size="20"><?php echo $match->getData()[0]; ?></text>
									</svg>

									<svg x="30" y="0" height="25" class="graph-competitor">
										<rect x="1" y="1" width="118" height="23" style="fill:lightblue;"/>
										<text x="10" y="18" font-size="15" ><?php echo $match->getData()[1]; ?></text>
									</svg>

									<svg x="30" y="30" height="25" class="graph-competitor">
										<rect x="1" y="1" width="118" height="23" style="fill:lightblue;"/>
										<text x="10" y="18" font-size="15" ><?php echo $match->getData()[2]; ?></text>
									</svg>
								</svg>
							<?php
							$match_var++;
							endforeach;
							?>
						</svg>
						<?php
						$round_var++;
						endforeach;
						?>
					</svg>
				</div>
			</div>
		</div>
	</div>

	<footer class="footer mt-auto py-3">
		<div class="container">
			<p>&copy; 2020 | Todos los derechos reservados</p>
		</div>
	</footer>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>