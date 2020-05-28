<?php
include '../includes/figure.php';
include '../includes/person.php';
include '../includes/competitor.php';
include '../includes/tournament_type.php';
include '../includes/simple_elimination.php';
include '../includes/match_figure.php';
include '../includes/round_figure.php';
include '../includes/tournament_figure.php';

$type= new SimpleElimination();

$tournament= new TournamentFigure('Torneo Setup Team', $type);

function generateCompetitors($tournament,$quantity){
	$names=["Fabian","Andrés","Yohan","Laura","Catalina","Camilo","Eduardo","Luis","José","Felipe","Daniel","Diego","Alejandro","Natalia","Pedro","Jorge","Jason","Bryan","María","Juan","Juana","Roberto","Rodolfo","Antonio","Fernando","Luisa","Camila","Paola","Leonardo","Cristian","Manuel","Sara","Sofia","Samuel","Angel","David","Javier","Nicolas","Alberto","Tatiana","Karen","Mauricio","Mario","Ramiro","Daniela","Ximena","Mariana","Lorena","Humberto","Esteban","Beatriz","Adriana","Lyda","Jazmin","Lizeth","Monica","Ramona","Elizabeth","Jairo","Alfredo","Julian","Emilio","Nestor","Pablo","Domingo","Sergio","Armando","LSinister","FSpirit","Lordom","Rokko","Scott","Samkr3w","Opia"];

	for ($i=0; $i < $quantity; $i++) {
		$competitor = new Competitor(($i+1), $names[random_int(0, count($names)-1)]);
		$tournament->addCompetitor($competitor);
	}
}

generateCompetitors($tournament,32);

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

			<div class="col-lg-12 overflow-auto">
				<div>
					<svg width="<?php echo count($tournament->getRounds())*200; ?>" height="<?php echo count($tournament->getRounds()[0]->getMatches())*80; ?>">
						<?php
						foreach ($tournament->getRounds() as $round){
							$round->draw();
						}
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