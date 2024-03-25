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

<div class="alert alert-warning text-center" role="alert">
  <h4 class="alert-heading">WORK IN PROGRESS</h4>
  <p class="mb-0">Este es un sitio en desarrollo y el diseño no es final.</p>
</div>

<div class="card <?= $character->active ? "" : "text-secondary" ?>">
    <div class="text-center card-header">
        <h1 class="d-inline h3"><?= $character->name ?></h1> <?= $character->active ? "" : "(Inactivo)" ?>
        <div><a href="<?= base_url('profile') ?>/<?= $player->uid ?>"><?= $player->display_name ?></a></div>
    </div>
    <div class="card-body">
      <? if ($isOwner && !$character->active) : ?>
        <p>
          Mientras el personaje esté inactivo, no podrás anotarte a partidas ni aparecerá en la lista de todos los personajes.<br>
          Otros usuarios seguirán pudiendo verlo mediante enlace directo o a través de tu perfil.
        </p>
      <? endif; ?>
      <? if ($character->image) : ?>
        <a href="#" data-toggle="modal" data-target="#image-modal" class="character-image">
          <div class="image-box">
            <img src="<?= base_url('img/characters') ?>/<?= $character->image ?>">
          </div>
        </a>
      <? endif; ?>
      <p>
        <strong><?= $character->class ?></strong> de nivel <strong><?= $character->level ?></strong><br/>
        Rango <?= rank_name(rank_get($character->level)) ?>
      </p>
      <? if ($character->wiki) : ?>
        <p>
          <a href="<?= $character->wiki ?>" target="_blank">Ver página de Wiki</a>
        </p>
      <? endif; ?>
      <p>
        <a href="#" data-toggle="modal" data-target="#character-sheet-modal">Hoja de personaje</a>
        <? if ($character->uploaded_sheet != $character->validated_sheet && ($isOwner || ($userdata && $userdata['master']))) : ?>
            <? if ($character->validated_sheet) : ?>
                (<a href="#" data-toggle="modal" data-target="#character-sheet-validated-modal">última validada</a>)
            <? else : ?>
                (<span class="text-danger">Sin validar</span>)
            <? endif; ?>
        <? endif; ?>
      </p>
      <? if ($character->logsheet && ($isOwner || ($userdata && $userdata['master']))) : ?>
        <p>
          <a href="<?= $character->logsheet ?>" target="_blank">Logsheet</a>
        </p>
      <? endif; ?>
      <div class="character-description">
        <? if ($character->description) : ?>
          <?= preg_replace('/(\r\n)+/', '<br>', htmlspecialchars($character->description)) ?>
        <? else : ?>
          El propietario de este personaje no ha proporcionado una biografía. <span class="emoji">&#x1F641;</span>
        <? endif; ?>
      </div>
    </div>
    <? if (($isOwner && $userdata['confirmed']) || ($userdata && $userdata['admin'])) : ?>
      <div class="card-footer">
        <button type="button" class="btn btn-primary js-update-character-btn mt-1" data-character="<?= htmlspecialchars(json_encode($character)) ?>">Actualizar</button>
        <? if ($character->active) : ?>
          <a href="<?= base_url('character') ?>/<?= $character->uid ?>/disable" class="btn btn-outline-danger mt-1">Desactivar</a>
        <? else : ?>
          <a href="<?= base_url('character') ?>/<?= $character->uid ?>/enable" class="btn btn-outline-success mt-1">Reactivar</a>
        <? endif; ?>
        <button type="button" class="btn btn-danger mt-1" data-toggle="modal" data-target="#delete-character-modal">Eliminar</button>
      </div>
    <? endif; ?>
    <? if ($userdata && $userdata['master']) : ?>
      <div class="card-footer">
        <button class="btn btn-outline-primary js-define-logsheet mt-1" data-uid="<?= $character->uid ?>" data-name="<?= $character->name ?>" data-logsheet="<?= $character->logsheet ?>">Definir logsheet</button>
        <? if ($character->uploaded_sheet != $character->validated_sheet) : ?>
          <button class="btn btn-primary js-validate-btn mt-1" data-uid="<?= $character->uid ?>" data-name="<?= $character->name ?>">Validar hoja de personaje</button>
          <button class="btn btn-danger js-reject-btn mt-1" data-uid="<?= $character->uid ?>" data-name="<?= $character->name ?>">Rechazar hoja de personaje</button>
        <? endif; ?>
      </div>
    <? endif; ?>
</div>

<?= view('partials/modals/character_sheet') ?>
<? if (($character->uploaded_sheet != $character->validated_sheet && ($isOwner || ($userdata && $userdata['master']))) && $character->validated_sheet) : ?>
  <?= view('partials/modals/character_sheet_validated') ?>
<? endif; ?>
<? if ($isOwner) : ?>
    <?= view('partials/modals/update_character') ?>
<? endif; ?>
<? if ($userdata && $userdata['master']) : ?>
  <?= view('partials/modals/validate_sheets') ?>
  <?= view('partials/modals/define_logsheet') ?>
<? endif; ?>
<? if ($character->image) : ?>
  <?= view('partials/modals/image', ['title' => $character->name, 'img' => (base_url('img/characters').'/'.$character->image) ]) ?>
<? endif; ?>
<?= view('partials/modals/delete_character') ?>