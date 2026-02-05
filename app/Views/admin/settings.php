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
                <th scope="col">Configuración</th>
                <th scope="col">Descripción</th>
                <th scope="col" style="width:50%">Valor</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($settings as $setting) : ?>
            <tr>
                <th scope="row" class="align-middle"><?= $setting->id ?></th>
                <td class="align-middle"><?= $setting->description ?></td>
                <td class="align-middle">
                    <form class="input-group mb-3" method="post">
                        <input type="hidden" name="id" value="<?= $setting->id ?>">
                        <input type="text" name="value" data-id="<?= $setting->id ?>" class="form-control js-setting-input" value="<?= $setting->value ?>">
                        <div class="input-group-append">
                            <button type="submit" id="button-<?= $setting->id ?>" class="btn btn-outline-secondary" disabled>&check;</button>
                        </div>
                    </form>
                </td>
            </tr>
            <? endforeach; ?>
        </tbody>
    </table>
</div>

<div>
    Datos de conexión:
    <ul>
        <li>User UID: <strong><?= $userdata['uid'] ?></strong></li>
        <li>Dirección IP: <strong><?= $_SERVER['REMOTE_ADDR'] ?></strong></li>
        <li>Hora del sistema: <strong><?= date('Y-m-d H:i:s') ?></strong></li>
    </ul>
</div>