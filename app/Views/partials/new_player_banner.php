<?php
// LigaDeAventureros
// Copyright (C) 2024 Santiago González Lago

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

<? if ($character_count > 0) : ?>
  <div class="jumbotron new-player-banner">
    <h1 class="h3 text-center">
      ¡Enhorabuena! Has creado tu primer personaje
    </h1>
    <p>
      En cuanto sea aprobado por un master, podrás:
      <ul>
        <li>Anotarte a partidas</li>
        <li>Actualizar los datos del personaje. Por ejemplo, podrás añadir una imagen y una biografía</li>
        <li>Crear nuevos personajes</li>
      </ul>
    </p>
    <p>
      Mientras tanto, echa un vistazo a <a href="<?= base_url('settings') ?>">tu configuración</a>.<br/>
      Podrás configurar el nombre que verán el resto de jugadores y elegir que notificaciones quieres recibir por correo electrónico.
    </p>
  </div>
<? else : ?>
  <div class="jumbotron new-player-banner banner-dark">
    <h1 class="display-4 text-center">¡Bienvenido!</h1>
    <p class="lead text-center">Visita nuestra guía paso a paso para crear <span class="text-accent">tu primer personaje</span> y poder participar en nuestras partidas.</p>
    <p class="text-center">
      <a class="btn btn-light btn-lg" href="<?= base_url('new-player-help') ?>" role="button">Ir a la guía</a>
    </p>
  </div>
<? endif; ?>