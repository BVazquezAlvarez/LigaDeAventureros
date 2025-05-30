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

<h1>Hay espacio para ti en la partida <?= $adventure->name ?></h1>

<p>
    ¡Hola <?= $user->display_name ?>!
</p>

<p>
    Alguien ha abandonado la partida por lo que se ha abierto un hueco para ti. Si no puedes ir, recuerda cancelar tu inscripción.
</p>

<p>
    Te recordamos la información de la partida:
</p>
<ul>
    <li><strong>Ubicación:</strong> <?= $session->location ?></li>
    <li><strong>Fecha:</strong> <?= weekday(date('N', strtotime($session->date))) ?> <?= date('d/m/Y', strtotime($session->date)) ?><br/></li>
    <li><strong>Hora:</strong> <?= date('H:i', strtotime($session->time)) ?></li>
    <li><strong>Duración:</strong> <?= $adventure->duration ?></strong> 
</ul>

<p>
    Te has anotado con el siguiente personaje:
</p>
<ul>
    <li><strong>Nombre:</strong> <?= $character->name ?></li>
    <li><strong>Clase:</strong> <?= $character->class ?></li>
    <li><strong>Nivel:</strong> <?= $character->level ?></li>
</ul>

<? if ($master_email) : ?>
    <p>
        Si tienes alguna duda, puedes responder a este email para contactar con el Master.
    </p>
<? endif; ?>