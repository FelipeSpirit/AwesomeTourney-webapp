<!DOCTYPE html>
<html>
<head>
	<title>R</title>
</head>
<body>
	<h1>LOGIN</h1>
	<form method="POST">
		<input type="text" name="r-username" hidden value="<?php echo $_POST['r-username'];?>">
		<input type="text" name="r-password" hidden value="<?php echo $_POST['r-password'];?>">
		<input type="text" name="l-username"><br>
		<input type="password" name="l-password"><br>
		<input type="submit" value="Ingresar">
	</form>
	<br>
	<div>
		<?php
		if(isset($_POST['l-username'])){
			echo 'Username: '.$_POST['r-username'].' '.$_POST['l-username'].'<br>'.PHP_EOL;
			echo 'Password: '.$_POST['r-password'].' '.$_POST['l-password'];
		}
		?>
	</div>
</body>
</html>