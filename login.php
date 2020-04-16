<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="icon" href="images/favicon.png" type="image/png"/>
	<link rel="stylesheet" type="text/css" href="css/login-estilo.css">
	<title>Awesome Tourney</title>
</head>
<body>
	<div class="header">
		<div class="logo">
			<img src="images/logo.png" alt="Logo Awesome Tournament">
		</div>
		<div class="menu-principal">
			<ul>
				<li><a href="#">¿Qué es Awesome Tourney?</a></li>
				<li><a href="#">Instrucciones de uso</a></li>
				<li><a href="#">Contacto</a></li>
				<li><a href="#">Acerca de</a></li>
				<li><a href="#">Reportar problema</a></li>
			</ul>
		</div>		
	</div>
	<div class="central">
		<div class="slider">
			<img id="slider-img" src="images/slider-image1.png">
		</div>
		<div class="aside-login">
			<h3 class="texto-iniciosesion">Inicio de Sesión</h1>
				<div class="input-fields">
					<input class="login-input" type="text" name="input-usuario" id="input-usuario" placeholder="Usuario" maxlength="48" required>
					<input class="login-input" type="password" name="input-contrasenia" id="input-contrasenia" placeholder="Contraseña" maxlength="32" required>
				</div>			
			<div class="boton-login">
				<button name="boton-login" id="boton-login" type="button" onclick="login()">
			<div class="img-button">
						<img src="images/Icon awesome-play.png">
						<span class="text-button">Ingresar</span>
					</div>
				</button>
			</div>
			<div class="recuperar-psw">
				<a href="#">¿Has olvidado tu contraseña?</a>
			</div>
			<div class="boton-crear">
				<button name="boton-crearcuenta" id="boton-crearcuenta" onclick="register()">¡Crear una cuenta!</button>
			</div>									
		</div>
	</div>	
	<div class="pop-up" id="pop-up">
		<div class="register-form">
			<div class="cerrar-popup"><h3 onclick="closeRegister()">+</h3></div>
			<h1>Registrarse</h1>
			<form class="reg-form" method="get" action="php/Insert.php">
				<table>
					<tr>
						<td><h3>Nombres</h3></td>
						<td><input type="text" class="input-crear" name="nombres-input" id="nombres-input" maxlength="48"></td>	
					</tr>
					<tr>
						<td><h3>Apellidos</h3></td>
						<td><input type="text" class="input-crear" name="apell-input" id="apell-input" maxlength="48"></td>
					</tr>
					<tr>
						<td><h3>Teléfono</h3></td>
						<td><input type="number" class="input-crear" name="tel-input" id="tel-input" maxlength="10"></td>
					</tr>
					<tr>
						<td><h3>E-mail *</h3></td>
						<td><input type="email" class="input-crear" name="email-input" id="email-input" maxlength="64" required></td>
					</tr>
					<tr>
						<td><h3>Nickname *</h3></td>
						<td><input type="text" class="input-crear" name="nick-input" id="nick-input" maxlength="48" required></td>
					</tr>
					<tr>
						<td><h3>Contraseña *</h3></td>
						<td><input type="password" class="input-crear" name="contra-input" id="contra-input" maxlength="32" required></td>
					</tr>
					<tr>
						<td><h3>Repetir Contraseña *</h3></td>
						<td><input type="password" class="input-crear" name="repcon-input" id="repcon-input" maxlength="32" required></td>
					</tr>	
				</table>
				<input type="submit" name="boton-crear" id="boton-crear" value="Crear Cuenta" onclick="">
				
			</form>
			<h3 class="obligatorio">Los campos marcados con (*) son obligatorios</h3>
		</div>
	</div>	
	<footer>
		<p>(C) Todos Los Derechos Reservados</p>
	</footer>
	<script type="text/javascript" src="jscripts/loginScript.js"></script>
</body>
</html>