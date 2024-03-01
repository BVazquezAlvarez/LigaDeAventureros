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
		<title>Página en mantenimiento - <?= setting('app_name') ?></title>

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
				</div>
			</nav>
		</header>

		<main class="container container-l">
            <div class="text-center">
                <h1>¡Estamos en mantenimiento!</h1>
                <p>Disculpa las molestias. Estamos trabajando para mejorar nuestro sitio.</p>
                <i class="fa-solid fa-gears" style="font-size:15em;"></i>
            </div>
		</main>

		<footer class="text-center">
			Liga de Aventureros de Vigo
			<div class="links-container">
				<a href="https://github.com/SantiGonzalezLago/LigaDeAventureros" target="_blank"><i class="fab fa-github fa-2x text-secondary"></i></a>
			</div>
		</footer>

	</body>
</html>