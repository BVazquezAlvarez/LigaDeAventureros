<?php
// LigaDeAventureros
// Copyright (C) 2023 Santiago González Lago

// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.

// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <https://www.gnu.org/licenses/>.
?>

<!DOCTYPE html>
<html lang="es-ES">
	<head>
		<title><?= (isset($title) ? $title . ' - ' : '') ?><?= setting('app_name') ?></title>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="shortcut icon" type="image/png" href="<?= base_url('favicon.ico') ?>"/>

		<script type="text/javascript" src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/jquery-ui.min.js') ?>"></script>

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
		<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
		<script type="text/javascript" src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>

		<script>
			baseUrl = "<?= base_url() ?>";
		</script>

		<script type="text/javascript" src="<?= base_url('assets/js/main.js') ?>"></script>
		<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/main.css') ?>">
	</head>

	<body>
		<header class="p-0">
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
				<div class="container-fluid">
					<a class="navbar-brand" href="<?= base_url() ?>"><span class="title"><?= setting('app_name') ?></span></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav mr-auto mb-2 mb-lg-0">
							<? if (isset($userdata) && $userdata['master']) : ?>
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
										Master
									</a>
									<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
										<li><a class="dropdown-item" href="<?= base_url('master') ?>">Panel de Control</a></li>
										<li><hr class="dropdown-divider"></li>
										<li><a class="dropdown-item" href="<?= base_url('master/sheets') ?>">Validar hojas de personaje</a></li>
										<li><a class="dropdown-item" href="<?= base_url('master/adventures') ?>">Aventuras y sesiones</a></li>
										<li><a class="dropdown-item" href="<?= base_url('master/new-session') ?>">Nueva sesión</a></li>
										<li><a class="dropdown-item" href="<?= base_url('master/publish') ?>">Publicar sesiones</a></li>
									</ul>
								</li>
							<? endif; ?>
							<? if (isset($userdata) && $userdata['admin']) : ?>
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
										Administrador
									</a>
									<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
										<li><a class="dropdown-item" href="<?= base_url('admin') ?>">Panel de Control</a></li>
										<li><hr class="dropdown-divider"></li>
										<li><a class="dropdown-item" href="<?= base_url('admin/users') ?>">Administrar usuarios</a></li>
										<li><a class="dropdown-item" href="<?= base_url('admin/logs') ?>">Comprobar logs</a></li>
										<li><a class="dropdown-item" href="<?= base_url('admin/settings') ?>">Configuraciones del servidor</a></li>
									</ul>
								</li>
							<? endif; ?>
							<li class="nav-item"><a class="nav-link" href="<?= base_url('all-characters') ?>">Todos los personajes</a></li>
							<? if (setting('wiki_link')) : ?>
								<li class="nav-item"><a class="nav-link" href="<?= setting('wiki_link') ?>" target="_blank">Wiki</a></li>
							<? endif; ?>
						</ul>
						<ul class="navbar-nav ml-auto mb-2 mb-lg-0">
							<? if ($userdata) : ?>
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
										<?= $userdata['display_name'] ?>
									</a>
									<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
										<li><a class="dropdown-item" href="<?= base_url('profile') ?>/<?= $userdata['uid'] ?>">Mi perfil</a></li>
										<li><a class="dropdown-item" href="<?= base_url('settings') ?>">Configuración</a></li>
										<li><hr class="dropdown-divider"></li>
										<li><a class="dropdown-item" href="<?= base_url('logout') ?>">Cerrar Sesión</a></li>
									</ul>
								</li>
							<? else : ?>
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
										Iniciar sesión
									</a>
									<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
										<li>
											<form class="px-4 py-3" style="min-width: 250px;" method="post" action="<?= base_url('login') ?>">
												<div class="form-group">
													<input type="text" class="form-control" name="email" value="<?= session('email_login') ?>" placeholder="Email">
												</div>
												<div class="form-group">
													<input type="password" class="form-control" name="password" placeholder="Contraseña">
												</div>
												<button type="submit" class="btn btn-primary">Iniciar sesión</button>
											</form>
										</li>
										<li><hr class="dropdown-divider"></li>
										<li>
											<a href="<?= base_url('login/google') ?>" class="dropdown-item">
												Iniciar sesión con <img src="<?= base_url('img/google.svg') ?>" height="20" alt="Google">
											</a>
										</li>
									</ul>
								</li>
							<? endif; ?>
						</ul>
					</div>
				</div>
			</nav>
		</header>

		<main class="container container-l">
			<? if (session('error')) : ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<?= session('error') ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<? endif; ?>

			<? if (session('success')) : ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<?= session('success') ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<? endif; ?>

			<?= view($view) ?>
		</main>

		<footer class="text-center">
			Liga de Aventureros de Vigo
			<div><small><a href="<?= base_url('privacy') ?>">Política de privacidad</a></small></div>
			<div class="links-container">
				<a href="https://github.com/SantiGonzalezLago/LigaDeAventureros" target="_blank"><i class="fab fa-github fa-2x text-secondary"></i></a>
			</div>
		</footer>

	</body>

	<? if (!$userdata) : ?>
		<div id="g_id_onload"
			data-client_id="<?= setting('google_client_id') ?>"
			data-login_uri="<?= base_url('login/onetap') ?>"
			data-cancel_on_tap_outside="false">
		</div>
		<script>
			document.cookie = "g_state=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
		</script>
		<script src="https://accounts.google.com/gsi/client" async defer></script>
	<? endif; ?>
</html>