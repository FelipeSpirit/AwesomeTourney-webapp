	<header class="<?php if($dark) echo 'header-dark';?>">
		<div class="navbar navbar-expand-lg navbar-<?php if($dark) echo 'dark'; else echo 'light';?> static-top shadow-sm">
			<div class="container d-flex justify-content-between">
				<a class="navbar-brand" href="/">
					<div class="header-logo">
						<img id="header-logo" src="/images/logo.png">
					</div>
					
				</a>
				<p>v1.08</p>
				<div id="navbarHeaderA">
					<div class="container">
						<form class="form-inline">
					    	<input class="form-control" type="text" placeholder="Buscar" aria-label="Search" disabled>
					    </form>

						<ul class="navbar-nav mr-auto">
							<?php 
							if (isset($_SESSION['user'])):?>
						    	<li class="nav-item">
						        	<a class="btn btn-<?php if($dark) echo 'dark'; else echo 'light';?>" href="/dashboard">Dashboard</a>
							    </li>

							    <li class="nav-item">
						        	<a class="btn btn-<?php if($dark) echo 'dark'; else echo 'light';?>" href="/tourneys">Torneos</a>
							    </li>
							    

							    <li class="nav-item">
							    	<div class="dropdown">
							    		<a class="btn btn-<?php if($dark) echo 'dark'; else echo 'light';?> dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>

									   <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownMenuLink">
									        <a class="btn dropdown-item" href="/user?id=<?php echo $user->getId();?>"><?php echo $user->getNickname(); ?></a>
									        <div class="dropdown-divider"></div>
									        <a class="dropdown-item" href="/includes/logout.php">Cerrar sesión</a>
									    </div>
									</div>
							    </li>
							<?php 
							else: ?>
								<li class="nav-item">
						        	<a class="btn btn-<?php if($dark) echo 'dark'; else echo 'light';?>" href="/login">Iniciar sesión</a>
							    </li>
							<?php 
							endif; ?>
					    </ul>
					</div>
				</div>

			    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeaderB" aria-controls="navbarHeaderB" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
			</div>
		</div>

		<div class="collapse bg-dark" id="navbarHeaderB">
			<div class="container">
				<div class="row">
					<?php 
					if (isset($_SESSION['user'])):?>
						<div class="col-sm-12" style="margin-bottom: 10px;">
							<a class="btn btn-primary btn-block" href="/user?id=<?php echo $user->getId();?>"><?php echo $user->getNickname(); ?></a>
						</div>
					<?php
					endif;?>
					
					<div class="col-sm-6">
						<h4 class="text-light">Buscar</h4>
						<form>
					    	<div class="form-group">
					    		<input class="form-control" type="text" placeholder="Buscar" aria-label="Search" disabled>
					    	</div>
					    </form>
					</div>

					<div class="col-sm-6">
						<h4 class="text-light" style="text-align: center;">Menu</h4>
						<div class="d-flex justify-content-center">
							<div class="btn-group-vertical">
								<?php 
								if (isset($_SESSION['user'])):?>
								<a class="btn btn-dark" href="/dashboard">Dashboard</a>
								<a class="btn btn-dark" href="/tourneys">Mis torneos</a>
								<div class="dropdown-divider"></div>
								<a class="btn btn-danger" href="/includes/logout.php">Cerrar sesión</a>
								<?php
								else:?>
									<a class="btn btn-dark" href="/login">Iniciar sesión</a>
								<?php
								endif;?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>