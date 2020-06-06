<?php 
require_once '../../includes/classes.php';
$userSession = new UserSession();
$user = new User();
$tournament= new TournamentFigure();

$tournament->charge($_GET['id']);

if(isset($_SESSION['user']))
	$user->charge($_SESSION['user']);

?>
<!DOCTYPE html>
<html class="h-100">
<head>
	<title>Participantes | Awesome Tourney</title>
	<link rel="shortcut icon" href="/images/favicon.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
</head>

<body class="d-flex flex-column h-100 bg-<?php if($dark) echo 'dark'; else echo 'light';?>">

	<?php include '../../fragments/menu.php'; ?>

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-12">
					<label><h1>Participantes de <?php echo $tournament->getName(); ?></h1></label>
				</div>

				<div class="col-lg-12">
					<div class="btn-group">
						<button class="btn btn-secondary" onclick="location.href='../?id='+<?php echo $_GET['id'];?>;">Brackets</button>
						<button class="btn btn-secondary">Reglas</button>
					</div>

					<div class="btn-group">
						<?php 
						if ($tournament->getState()=='IN'): ?>
							<button class="btn btn-danger">Inscribirse</button>
						<?php 
						endif;

						if ($tournament->getOwnerId()==$user->getId()): 
							if ($tournament->getState()=='IN'): ?>
								<button class="btn btn-primary"
								onclick="<?php if(count($tournament->getCompetitors()) > 2) echo 'startTourney(this,'.$_GET['id'].",'../'".')';?>;">Iniciar torneo</button>
						<?php 
							endif;
						endif; ?>
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="card <?php if($dark) echo 'bg-dark text-white';?>">
					<div class="card-body">
					<?php if (count($tournament->getCompetitors())!==0): ?>							
						
							<?php 
							foreach ($tournament->getCompetitors() as $competitor):
								?>
								<div class="alert alert-dark">
									<?php echo $competitor->getNickname(); ?>
								</div>
							<?php 
							endforeach;
							?>
					<?php endif ?>
					<?php 
					if(isset($_SESSION['user']))
						if ($tournament->getOwnerId()==$user->getId()): 
							if ($tournament->getState()=='IN'): ?>
								<form method="post" action="insert_competitor.php">
									<input type="text" name="tourney" hidden value="<?php echo $_GET['id']; ?>">
									<div class="form-row">
										<div class="col-sm-9">
											<input type="text" name="name" class="form-control" placeholder="Nombre del participante" autofocus required>	
										</div>

										<div class="col-sm-3">
											<button class="btn btn-success btn-block">Agregar</button>
										</div>
									</div>
								</form>
					<?php endif;
					endif;?>
					</div>
				</div>
			</div>

		</div>
	</div>

	<?php include '../../fragments/footer.php'; ?>

	<script type="text/javascript" src="/assets/js/db.js"></script>
	<script type="text/javascript" src="/assets/js/dynamic.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>