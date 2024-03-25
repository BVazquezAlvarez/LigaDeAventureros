<?php
// LigaDeAventureros
// Copyright (C) 2023-2024 Santiago González Lago

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

<div class="card">
    <div class="card-header">
        <h1 class="d-inline-block mb-0"><?= $user->display_name ?></h1>
        <? if ($user->admin) : ?><h5 class="d-inline-block"><span class="badge badge-secondary">Administrador</span></h5><? endif; ?>
        <? if ($user->master) : ?><h5 class="d-inline-block"><span class="badge badge-primary">Master</span></h5><? endif; ?>
        <? if (!$user->confirmed) : ?><h5 class="d-inline-block"><span class="badge badge-warning">Usuario sin confirmar</span></h5><? endif; ?>
        <? if ($user->banned) : ?><h5 class="d-inline-block"><span class="badge badge-danger">Usuario bloqueado</span></h5><? endif; ?>
    </div>
    <div class="card-body">
        <? if ($characters) : ?>
            <div class="row">
                <? foreach ($characters as $char) : ?>
                    <div class="col-lg-4 col-md-6 mb-2">
                        <div class="card character-card <?= $char->active ? "" : "text-secondary" ?>">
                            <div class="card-header">
                                <h3 class="d-inline h5 mb-0"><?= $char->name ?></h1> <?= $char->active ? "" : "(Inactivo)" ?>
                            </div>
                            <div class="card-body">
                                <a href="<?= base_url('character') ?>/<?= $char->uid ?>" class="character-image-profile">
                                    <div class="image-box">
                                        <img src="<?= $char->image ? (base_url('img/characters').'/'.$char->image) : base_url('img/placeholder.png') ?>">
                                    </div>
                                </a>
                                <div><?= $char->class ?> <strong><?= $char->level ?></strong> (Rango <?= rank_name(rank_get($char->level)) ?>)</div>
                                <div>
                                    <a href="<?= base_url('character') ?>/<?= $char->uid ?>">Detalles</a>
                                    <? if ($char->uploaded_sheet != $char->validated_sheet && ($isOwner || ($userdata && $userdata['master']))) : ?>
                                        <span class="text-danger">(Sin validar)</span>
                                    <? endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <? endforeach; ?>
                <? if ($isOwner && $userdata['confirmed']) : ?>
                    <div class="col-md-12 mt-3">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new-character-modal">Nuevo personaje</button>
                    </div>
                <? endif; ?>
            </div>
        <? else : ?>
            <? if ($isOwner) : ?>
                <div>Todavía no has creado ningún personaje. <a href="#" data-toggle="modal" data-target="#new-character-modal">Crea uno</a></div>
            <? else : ?>
                <div>Este jugador no tiene ningún personaje creado.</div>
            <? endif; ?>
        <? endif; ?>
    </div>
    <? if ($userdata && $userdata['admin']) : ?>
        <div class="card-footer">
            <? if (!$isOwner) : ?>
                <a href="<?= base_url('admin/user_login') ?>/<?= $user->uid ?>" class="btn btn-primary mt-1 mr-3">Suplantar</a>
            <? endif; ?>
            <? if ($user->confirmed && !$user->banned) : ?>
                <? if ($user->master) : ?>
                    <button class="btn btn-outline-primary mt-1 mr-1 js-master-rm" data-uid="<?= $user->uid ?>" data-name="<?= $user->display_name ?>">Eliminar Master</span>
                <? else : ?>
                    <button class="btn btn-primary mt-1 mr-1 js-master-add" data-uid="<?= $user->uid ?>" data-name="<?= $user->display_name ?>">Hacer Master</span>
                <? endif; ?>
                <? if (!$isOwner) : ?>
                    <? if ($user->admin) : ?>
                        <button class="btn btn-outline-primary mt-1 mr-1 js-admin-rm" data-uid="<?= $user->uid ?>" data-name="<?= $user->display_name ?>">Eliminar Administrador</span>
                    <? else : ?>
                        <button class="btn btn-primary mt-1 mr-1 js-admin-add" data-uid="<?= $user->uid ?>" data-name="<?= $user->display_name ?>">Hacer Administrador</span>
                    <? endif; ?>
                    <button class="btn btn-danger mt-1 mr-1 js-ban" data-uid="<?= $user->uid ?>" data-name="<?= $user->display_name ?>">Bloquear</span>
                <? endif; ?>
            <? endif; ?>
            <? if ($user->banned) : ?>
                <button class="btn btn-outline-danger mt-1 mr-1 js-unban" data-uid="<?= $user->uid ?>" data-name="<?= $user->display_name ?>">Desbloquear</span>
            <? endif; ?>
        </div>
    <? endif; ?>
</div>

<? if ($isOwner) : ?>
    <?= view('partials/modals/new_character') ?>
<? endif; ?>
<? if ($userdata && $userdata['admin']) : ?>
    <?= view('partials/modals/admin_actions') ?>
<? endif; ?>