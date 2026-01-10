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

<div class="row">
    <div class="offset-md-3 col-md-6">
        <a href="<?= base_url('admin/users') ?>" class="btn btn-primary btn-lg btn-block">
            Administrar usuarios
            <span class="badge badge-success"><?= $users_confirmed ?></span>
            <span class="badge badge-warning"><?= $users_unconfirmed ?></span>
            <span class="badge badge-danger"><?= $users_banned ?></span>
        </a>
        <a href="<?= base_url('admin/resources') ?>" class="btn btn-primary btn-lg btn-block">
            Administrar recursos
            <span class="badge badge-light"><?= $resources ?></span>
        </a>
        <a href="<?= base_url('admin/logs') ?>" class="btn btn-primary btn-lg btn-block">
            Comprobar logs
            <span class="badge badge-light"><?= $logs ?></span>
        </a>
        <a href="<?= base_url('admin/settings') ?>" class="btn btn-primary btn-lg btn-block">
            Configuraciones del servidor
        </a>
    </div>
</div>