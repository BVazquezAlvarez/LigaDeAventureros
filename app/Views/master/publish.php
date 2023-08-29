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

<? if ($sessions) : ?>
    <form id="publish-sessions-form" method="post">
        <div class="mb-1 text-right">
            <button type="submit" class="btn btn-primary">Publicar seleccionadas</button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">
                            <input type="checkbox" id="checkbox-select-all">
                        </th>
                        <th scope="col">Aventura</th>
                        <th scope="col">Rango</th>
                        <th scope="col">Master</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($sessions as $session) : ?>
                        <tr>
                            <td class="align-middle">
                                <input type="checkbox" name="session[]" value="<?= $session->uid ?>" class="js-checkbox-select-all">
                            </td>
                            <th class="align-middle" scope="row"><?= $session->adventure_name ?></th>
                            <td class="align-middle"><?= rank_full_text($session->rank) ?></td>
                            <td class="align-middle"><?= $session->master ?></td>
                            <td class="align-middle"><?= date('d/m/Y', strtotime($session->date)) ?></td>
                            <td class="align-middle"><?= date('H:i', strtotime($session->time)) ?></td>
                        </tr>
                    <? endforeach; ?>
                    <? if (!$sessions) : ?>
                        <tr>
                            <td class="text-center" colspan="8">No hay sesiones sin publicar</td>
                        </tr>
                    <? endif; ?>
                </tbody>
            </table>
        </div>
    </form>
<? else : ?>
    <p class="text-center">No hay ninguna sesión sin publicar</p>
    <p class="text-center">
        <a href="<?= base_url('master/new-session') ?>">¿Por qué creas una nueva?</a>
    </p>
<? endif; ?>