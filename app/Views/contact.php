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

<div class="row">
    <form class="col-md-6 offset-md-3" method="post">
        <h1 class="text-center">Contacto</h1>
        <div class="form-group">
            <label for="name">Tu nombre <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" value="<?= $name ?>" required>
            <? if (isset(session('validation_errors')['name'])) : ?>
                <small class="text-danger"><?= session('validation_errors')['name'] ?></small>
            <? endif; ?>
        </div>
        <div class="form-group">
            <label for="email">Tu dirección de correo electrónico <span class="text-danger">*</span></label>
            <input type="email" name="email" id="email" class="form-control" value="<?= $email ?>" required>
            <? if (isset(session('validation_errors')['email'])) : ?>
                <small class="text-danger"><?= session('validation_errors')['email'] ?></small>
            <? endif; ?>
        </div>
        <div class="form-group">
            <label for="subject">Asunto <span class="text-danger">*</span></label>
            <input type="text" name="subject" id="subject" class="form-control" required>
            <? if (isset(session('validation_errors')['subject'])) : ?>
                <small class="text-danger"><?= session('validation_errors')['subject'] ?></small>
            <? endif; ?>
        </div>
        <div class="form-group">
            <label for="msg">Mensaje <span class="text-danger">*</span></label>
            <textarea name="msg" id="msg" class="form-control" rows="10" required></textarea>
            <? if (isset(session('validation_errors')['msg'])) : ?>
                <small class="text-danger"><?= session('validation_errors')['msg'] ?></small>
            <? endif; ?>
        </div>
        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    </form>
</div>