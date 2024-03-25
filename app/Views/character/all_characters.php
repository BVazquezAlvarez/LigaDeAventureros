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

<div class="row mb-3">
    <div class="col-md-6 buttons-ranks">
        <button class="js-button-rank" data-rank="1"><?= rank_name(1) ?></button>
        <button class="js-button-rank" data-rank="2"><?= rank_name(2) ?></button>
        <button class="js-button-rank" data-rank="3"><?= rank_name(3) ?></button>
        <button class="js-button-rank" data-rank="4"><?= rank_name(4) ?></button>
    </div>
    <div class="col-md-6">
        <input type="text" class="form-control" id="all-characters-search" placeholder="Búsqueda...">
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Personaje</th>
                <th scope="col">Jugador</th>
                <th scope="col">Clase</th>
                <th scope="col">Nivel</th>
                <th scope="col">Rango</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($characters as $char) : ?>
                <tr class="js-all-characters-search <?= $userdata && $char->user_uid == $userdata['uid'] ? 'table-warning' : '' ?>" data-rank="<?= rank_get($char->level) ?>" data-query="<?= strtolower($char->name) ?> <?= strtolower($char->display_name) ?> <?= strtolower($char->class) ?> <?= $char->level ?>">
                    <th scope="row"><a href="<?= base_url('character') ?>/<?= $char->uid ?>"><?= $char->name ?></th>
                    <td><a href="<?= base_url('profile') ?>/<?= $char->user_uid ?>"><?= $char->display_name ?></a></td>
                    <td><?= $char->class ?></td>
                    <td><?= $char->level ?></td>
                    <td><?= rank_name(rank_get($char->level)) ?></td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
</div>