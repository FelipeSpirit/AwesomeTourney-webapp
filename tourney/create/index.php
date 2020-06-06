<?php 
require_once '../../includes/classes.php';
$userSession = new UserSession();
$user = new User();

if(!isset($_SESSION['user'])){
    header('location: ../login');
}

$user->charge($_SESSION['user']);
?>
<!DOCTYPE html>
<html class="h-100">
<head>
	<title>Crear torneo | Awesome Tourney</title>
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
				<label><h1>Crear torneo</h1></label>
			</div>

			<div class="col-lg-12">
				<div class="card <?php if($dark) echo 'bg-dark text-white';?>">
					<div class="card-body">
						<form method="post" action="insert_tourney.php">
							<div class="form-row">
								<div class="form-group col-md-6">
									<label>Nombre</label>
									<input type="text" name="name" class="form-control" placeholder="Nombre del torneo" required>
								</div>

								<div class="form-group col-md-3">
									<label>Tipo de torneo</label>
									<select class="form-control" name="type" required>
										<option value="S">Eliminación simple</option>
										<option value="D">Eliminación doble</option>
										<option value="R" disabled>Round robin (Proximamente)</option>
									</select>
								</div>

								<div class="form-group col-md-3">
									<label>Modalidad</label>
									<select class="form-control" name="modd" required>
										<option value="P">Presencial</option>
										<option value="O" disabled>Online (Proximamente)</option>
									</select>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-md-6">
									<label>Fecha</label>
									<input id="input-date" type="date" name="date" class="form-control" required>
								</div>

								<div class="form-group col-md-6">
									<label>Hora</label>
									<input id="input-time" type="time" name="time" class="form-control" required>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group">
									<label>Juego</label>
									<select class="form-control" name="game">
										<option value="1">Super Smash Bros Ultimate</option>
									</select>
								</div>
							</div>

							<input type="text" name="owner" hidden value="<?php echo $user->getId(); ?>">
							<button class="btn btn-primary btn-block">Crear torneo</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include '../../fragments/footer.php'; ?>

	<script type="text/javascript" src="/assets/js/dynamic.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"  crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<script type="text/javascript">
		var today = new Date();
		var date = today.getFullYear() + '-'
		+ (today.getMonth() + 1 < 10 ? "0":"") + (today.getMonth() + 1) + '-' 
		+(today.getDate() < 10 ? "0":"") + today.getDate();
		var time = today.getHours() + ":" + today.getMinutes();

		$('#input-date').val(date);
		$('#input-time').val(time);
	</script>
</body>
</html>