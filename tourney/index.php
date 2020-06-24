<?php
include '../includes/classes.php';
//Sesion de usuario
$userSession = new UserSession();
$user = new User();

//carga de usuario
if(isset($_SESSION['user']))
	$user->charge($_SESSION['user']);
//carga de torneo

if(!isset($_GET['name']))
	if(isset($_GET['id'])){
		$tournament= new TournamentFigure();
		$tournament->charge($_GET['id']);
		$tournament->chargeMatches();
		$owner=$tournament->getOwnerId();
	}


//control temas
if(isset($_COOKIE['dark'])){
	$dark= '-dark';
	$light= '-light';
}else{
 	$light= '';
 	$dark = '';
}
?>

<!DOCTYPE html>
<html class="h-100">
<head>
	<title><?php //Titulo de la pagina
	if(isset($tournament))
	 if($tournament->getName()) echo $tournament->getName().' |';?> Awesome Tourney</title>
	<link rel="shortcut icon" href="/images/favicon.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
</head>

<body class="d-flex flex-column h-100 bg-<?php if($dark) echo 'dark'; else echo 'light';?>">
	<?php include '../fragments/menu.php'; ?>
	<div class="container">
		<div class="row">
			<?php 
			//si no existe el torneo no se cargan botones de control
			if(isset($tournament)):
				if($tournament->getName()):?>
					<div class="col-lg-12">
						<div class="row">
							<div class="col-lg-12">
								<label><h1 class="text<?php echo $light;?>"><?php echo $tournament->getName(); ?></h1></label>
							</div>

							<div class="col-lg-12">
								<div class="btn-group">
									<button class="btn btn-secondary">Reglas</button>
									<button class="btn btn-secondary" onclick="location.href='competitors?id='+<?php echo $_GET['id'];?>;">Participantes</button>
								</div>

								<div class="btn-group">
									<?php 
									if ($tournament->getState()=='IN'): ?>
										<button class="btn btn-danger" hidden>Inscribirse</button>
									<?php 
									endif;

									if ($tournament->getOwnerId()==$user->getId()): 
										if ($tournament->getState()=='IN'): ?>
											<button class="btn btn-primary" onclick="<?php if(count($tournament->getCompetitors())>2) echo 'startTourney(this,'.$_GET['id'].')';?>;">Iniciar torneo</button>
									<?php 
										endif;
									endif; ?>
								</div>
							</div>
						</div>
					</div>
			<?php 
				endif;

				//Si no se han creado los encuentros no se carga el svg
				$tourneyType=$tournament->getTournamentType()->key;

				if($tourneyType=='S')
					$qRounds=count($tournament->getRounds());
				else if($tourneyType=='D')
					$qRounds=count($tournament->getRounds()) / 2;

				if(count($tournament->getRounds())!=0):
					$r=$tournament->getRounds()[$qRounds - 1];
					$m=$r->getMatches()[count($r->getMatches())-1];

					//Se muestra si hay ganador
					if ($m->getWinner() != -1): ?>
						<div class="col-lg-12">
							<h2>Ganador: <?php if($m->getWinner()==0) echo $m->getCompetitor1()->getNickname(); else  echo $m->getCompetitor2()->getNickname(); ?></h2>
						</div>
					<?php 
					endif; ?>

					<div class="col-lg-12">
						<div id="bracket-container" class="overflow-auto bracket-container<?php echo $dark;?>">
							<div>
								<svg width="<?php echo count($tournament->getRounds()) * ($tourneyType=='S'?200:100) + 15; ?>" height="<?php echo $tournament->getMaxValues()['matches'] * ($tourneyType=='S'?70:140) + 100; ?>">
									<?php
									foreach ($tournament->getRounds() as $round){
										$round->draw();
									}
									?>
								</svg>
							</div>
						</div>
					</div>
				<?php 
				elseif($tournament->getName()): ?>
					<div class="col-lg-12 text<?php echo $light;?>">
						<h3>No se ha iniciado el torneo.</h3>
						<?php
						//Si esta inactivo y el organizador tiene sesion abierta
						if ($tournament->getOwnerId()==$user->getId()): 
							if ($tournament->getState()=='IN'): ?>
								<button class="btn btn-primary" onclick="<?php if(count($tournament->getCompetitors())>2) echo 'startTourney(this,'.$_GET['id'].')';?>;">Iniciar torneo</button>
						<?php 
							endif;
						endif; ?>
					</div>
				<?php
				else:?>
					<div class="col-lg-12 text<?php echo $light;?>">
						<h3>Esta pagina no tiene ningún torneo</h3>
					</div>
				<?php 
				endif;
			else:?>
				<label><h2>No se ha seleccionado ningun torneo</h2></label>
			<?php	
			endif;?>
		</div>
	</div>

	<div id="score-modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
	    	<div class="modal-content bg-<?php if($dark) echo 'dark'; else echo 'light';?>">
		      	<form method="post" action="change_score.php">
		      		<input id="pos-input" type="text" name="position" hidden>
		      		<input id="posL-input" type="text" name="positionL" hidden>
		      		<input id="m-input" type="text" name="match" hidden>
		      		<input type="text" name="tourney" value="<?php echo $_GET['id']; ?>" hidden>
		      		<input type="text" name="tourneyType" value="<?php echo $tourneyType; ?>" hidden>

		      		<div class="modal-header">
				        <h5 class="modal-title" id="exampleModalCenterTitle">Puntuación del encuentro #<label id="label-match"></label></h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				    </div>

				    <div class="modal-body">
				    	<h6 style="text-align: center;">Ganador</h6>
				    	<div class="d-flex justify-content-center">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<label class="btn btn-secondary">
								    <input id="p1-input" type="radio" name="winner" value="0">
								    <div id="p1-label"></div>
								</label>

								<label class="btn btn-secondary">
									<input id="p2-input" type="radio" name="winner" value="1">
									<div id="p2-label"></div>
								</label>
							</div>
				    	</div>
				    </div>

				    <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				        <button class="btn btn-primary">Guardar</button>
				    </div>
		      	</form>
	    	</div>
	  	</div>
	</div>

	<footer class="footer mt-auto py-3">
		<div class="container text<?php echo $light;?>">
			<p>&copy; 2020 | Todos los derechos reservados</p>
			<button onclick="toggleTheme(<?php if (isset($_COOKIE['dark'])) echo "true"; else echo 'false'; ?>);" class="btn btn-<?php if(isset($_COOKIE['dark'])) echo "light"; else echo "dark"; ?>"><?php if(isset($_COOKIE['dark'])) echo "Light"; else echo "Dark"; ?></button>
		</div>
	</footer>

	<script type="text/javascript" src="/assets/js/db.js"></script>
	<script type="text/javascript" src="/assets/js/dynamic.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script type="text/javascript">
		function showScoreModal(match, pos,posL){
			//consulta del match
			consultDB(["match","tourney=<?php echo $_GET['id'];?>&match="+match]).then(function(ans){
				var ps=ans.split(';');

				$('#label-match').html(match);
				$('#m-input').val(match);

				$('#p1-label').html(ps[0]);
				$('#p2-label').html(ps[1]);
				
				$('#pos-input').val(pos);
				$('#posL-input').val(posL);

				$('#score-modal').modal('show');
			});
		}

		var curXPos = 0;
		var curDown = false;

		$('#bracket-container').on("mousemove", function (event) {
		  if (curDown === true) {
		    $('#bracket-container').scrollLeft(parseInt($('#bracket-container').scrollLeft() + (curXPos - event.pageX)));
		  }
		});

		$('#bracket-container').on("mousedown", function (e) { 
			curDown = true;  
			curXPos = e.pageX; 
			e.preventDefault();
			$('#bracket-container').css('cursor','grabbing');
		});

		$(window).on("mouseup", function (e) { 
			curDown = false; 
			$('#bracket-container').css('cursor','grab');
		});

		$(window).on("mouseout", function (e) { curDown = false; });

	</script>
</body>
</html>