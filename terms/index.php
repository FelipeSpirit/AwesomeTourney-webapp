<?php 
require_once '../includes/classes.php';
$userSession = new UserSession();
$user = new User();

if(isset($_SESSION['user'])){
	$user->charge($_SESSION['user']);
}

?>
<!DOCTYPE html>
<html class="h-100">
<head>
	<title>Terminos y condiciones | Awesome Tourney</title>
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
			<div class="col-lg-12">
				AwesomeTourney podrá manipular la información que proveas para que tu experiencia sea la mejor. <br>
				En cualquier momento podrás eliminar tu cuenta y tu historial si así lo deseas. <br>
				Tu información será utilizada para estadisticas del servicio y su funcionamiento.
			</div>
		</div>
	</div>
	<?php include '../fragments/footer.php'; ?>
	
	<script type="text/javascript" src="/assets/js/dynamic.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>