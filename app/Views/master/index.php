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
    <div class="col-md-6">
        <a href="<?= base_url('master/sheets') ?>" class="btn btn-primary btn-lg btn-block">
            Validar hojas de personaje
            <span class="badge badge-light"><?= $sheets_pending_count ?></span>
        </a>
        <a href="<?= base_url('master/adventures') ?>" class="btn btn-primary btn-lg btn-block">
            Aventuras y sesiones
        </a>
        <a href="<?= base_url('master/new-session') ?>" class="btn btn-primary btn-lg btn-block">
            Nueva sesión
        </a>
        <a href="<?= base_url('master/publish') ?>" class="btn btn-primary btn-lg btn-block">
            Publicar sesiones
        </a>
    </div>
    <div class="col-md-6">
        
    </div>
</div>