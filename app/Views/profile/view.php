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

<div class="card">
    <div class="card-header">
        <h1 class="d-inline-block mb-0"><?= $user->display_name ?></h1>
        <? if ($user->admin) : ?><h5 class="d-inline-block"><span class="badge badge-secondary">Administrador</span></h5><? endif; ?>
        <? if ($user->master) : ?><h5 class="d-inline-block"><span class="badge badge-primary">Master</span></h5><? endif; ?>
        <? if (!$user->confirmed) : ?><h5 class="d-inline-block"><span class="badge badge-warning">Usuario sin confirmar</span></h5><? endif; ?>
        <? if ($user->banned) : ?><h5 class="d-inline-block"><span class="badge badge-danger">Usuario bloqueado</span></h5><? endif; ?>
    </div>
    <div class="card-body">
        <h2 class="h3">Lista de personajes</h2>
        <? if ($characters) : ?>
            <div class="row">
                <? foreach ($characters as $char) : ?>
                    <div class="col-md-4 mb-2">
                        <div class="card <?= $char->active ? "" : "text-secondary" ?>">
                            <div class="card-header">
                                <h3 class="d-inline h5 mb-0"><?= $char->name ?></h1> <?= $char->active ? "" : "(Inactivo)" ?>
                            </div>
                            <div class="card-body">
                                <p><?= $char->class ?> <strong><?= $char->level ?></strong> (Rango <?= rank_name(rank_get($char->level)) ?>)</p>
                                <p><a href="<?= base_url('character_sheets') ?>/<?= $char->uploaded_sheet ?>" target="_blank">Hoja de personaje</a></p>
                                <? if ($char->uploaded_sheet != $char->validated_sheet && ($isOwner || ($userdata && $userdata['master']))) : ?>
                                    <? if ($char->validated_sheet) : ?>
                                        <p><a href="<?= base_url('character_sheets') ?>/<?= $char->validated_sheet ?>" target="_blank">Última hoja de personaje validada</a></p>
                                    <? else : ?>
                                        <p class="text-danger">Este personaje todavía no ha sido validado.</p>
                                    <? endif; ?>
                                <? endif; ?> 
                                <? if ($isOwner && $userdata['confirmed']) : ?>
                                    <div class="col-md-12 mt-3">
                                        <button type="button" class="btn btn-primary js-update-character-btn" data-uid="<?= $char->uid ?>" data-name="<?= $char->name ?>" data-class="<?= $char->class ?>" data-level="<?= $char->level ?>">Actualizar</button>
                                    </div>
                                <? endif; ?>
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
</div>

<? if ($isOwner) : ?>
    <?= view('partials/modals/new_character') ?>
    <?= view('partials/modals/update_character') ?>
<? endif; ?>