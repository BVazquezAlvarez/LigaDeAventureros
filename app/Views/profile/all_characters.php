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
                <tr>
                    <th scope="row"><a href="<?= base_url('character_sheets') ?>/<?= $char->uploaded_sheet ?>" target="_blank"><?= $char->name ?></th>
                    <td><a href="<?= base_url('profile') ?>/<?= $char->user_uid ?>" target="_blank"><?= $char->display_name ?></a></td>
                    <td><?= $char->class ?></td>
                    <td><?= $char->level ?></td>
                    <td><?= rank_name(rank_get($char->level)) ?></td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
</div>

<div class="text-right text-muted">
    Mostrando <?= count($characters) ?> de <?= $total ?> resultados
</div>

<?= $pagination ?>