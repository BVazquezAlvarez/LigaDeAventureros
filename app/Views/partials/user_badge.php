<?php
// LigaDeAventureros
// Copyright (C) 2023-2026 Santiago González Lago

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

<a href="<?= base_url('character') ?>/<?= $player->character_uid ?>" class="btn btn-<?= $player->badge_color ?> badge badge-player <?= ($userdata && $player->uid == $userdata['uid']) ? 'badge-me' : '' ?> <?= $player->priority ? "border-priority" : "" ?>" >

    <? if ($player->priority >= PRIORITY_MASTER)  : ?>
        <i class="fa-solid fa-circle-up"
            style="position: absolute; left: -1px; top: -4px;"
            data-toggle="tooltip"
            title="El master ha dado prioridad a este jugador">
        </i>
    <? elseif ($player->priority == PRIORITY_STANDARD)  : ?>
        <i class="fa-solid fa-circle-up"
            style="position: absolute; left: -1px; top: -4px;"
            data-toggle="tooltip"
            title="Este jugador ha priorizado esta partida">
        </i>
    <? elseif ($player->priority == PRIORITY_NEW_PLAYER)  : ?>
        <i class="fas fa-universal-access"
            style="position: absolute; left: -1px; top: -4px;"
            data-toggle="tooltip"
            title="Los jugadores nuevos tienen prioridad">
        </i>
    <? elseif ($player->priority == PRIORITY_STANDARD + PRIORITY_NEW_PLAYER)  : ?>
        <i class="fas fa-universal-access"
            style="position: absolute; left: -1px; top: -4px;"
            data-toggle="tooltip"
            title="Los jugadores nuevos tienen prioridad">
        </i>
        <i class="fa-solid fa-circle-up"
            style="position: absolute; left: 13px; top: -4px;"
            data-toggle="tooltip"
            title="Este jugador ha priorizado esta partida">
        </i>
    <? endif; ?>
    <div><?= $player->name ?></div>
    <div>(<?= $player->display_name ?>)</div>
</a>