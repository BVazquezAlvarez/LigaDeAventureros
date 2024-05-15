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

<? if ($isOwner && !$userdata['confirmed']) : ?>
    <?= view('partials/new_player_banner' , ['character_count' => 1]) ?>
<? endif; ?>

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
            <img class="rounded" src="<?= base_url('img/characters') ?>/<?= $character->image ?>">
          </div>
        </a>
      <? endif; ?>
      <p>
        <strong><?= $character->class ?></strong> de nivel <strong><?= (int) $character->level ?></strong> en <?= $character->w_setting_name ?> (<?= $character->timeline ?>)<br/>
        <span class="badge badge-pill badge-rank-<?= rank_get($character->level) ?>">Rango <?= rank_name(rank_get($character->level)) ?></span>
      </p>
      <div class="ml-3 mb-3">
        <? if ($character->level < 20) : ?>
          <div>Progreso de nivel: <strong><?= $character->reject_level ? 'Nivel bloqueado' : 100 * fmod($character->level, 1) . '%' ?></strong></div>
        <? endif; ?>
        <div>Oro: <strong><?= $character->gold ?></strong></div>
        <div>Puntos de Tesoro: <strong><?= $character->treasure_points ?></strong></div>
        <? if (count($items)) : ?>
          <a href="#" class="link-dotted" data-toggle="modal" data-target="#magic-items-modal"><?= count($items) ?> objeto<?= count($items) != 1 ? 's' : '' ?> mágico<?= count($items) != 1 ? 's' : '' ?></a>
        <? else : ?>
          <div>0 objetos mágicos</div>
        <? endif; ?>
      </div>
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
          <a href="<?= $character->logsheet ?>" target="_blank">Logsheet (OBSOLETO)</a>
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
        <button type="button" class="btn btn-primary js-update-character-btn mt-1" data-character="<?= htmlspecialchars(json_encode($character)) ?>"><i class="fa-solid fa-pen"></i> Actualizar</button>
        <? if ($character->active) : ?>
          <a href="<?= base_url('character') ?>/<?= $character->uid ?>/disable" class="btn btn-outline-danger mt-1"><i class="fa-solid fa-eye"></i> Desactivar</a>
        <? else : ?>
          <a href="<?= base_url('character') ?>/<?= $character->uid ?>/enable" class="btn btn-outline-success mt-1"><i class="fa-solid fa-eye"></i> Reactivar</a>
        <? endif; ?>
        <button type="button" class="btn btn-danger mt-1" data-toggle="modal" data-target="#delete-character-modal"><i class="fa-solid fa-trash"></i> Eliminar</button>
      </div>
    <? endif; ?>
    <? if ($userdata && $userdata['master']) : ?>
      <div class="card-footer">
        <button class="btn btn-outline-primary mt-1" data-toggle="modal" data-target="#add-log-modal"><i class="fa-solid fa-pencil"></i> Añadir log</button>
        <? if ($character->uploaded_sheet != $character->validated_sheet) : ?>
          <button class="btn btn-primary js-validate-btn mt-1" data-uid="<?= $character->uid ?>" data-name="<?= $character->name ?>"><i class="fa-solid fa-check"></i> Validar hoja de personaje</button>
          <button class="btn btn-danger js-reject-btn mt-1" data-uid="<?= $character->uid ?>" data-name="<?= $character->name ?>"><i class="fa-solid fa-x"></i> Rechazar hoja de personaje</button>
        <? endif; ?>
      </div>
    <? endif; ?>
</div>

<? if ($logsheet) : ?>
  <div class="row mt-2">
    <div class="col-lg-4 col-md-6">
      <select class="form-control" id="logsheet-visual-control">
        <option value="">Mostrar todos los logs</option>
        <option value="logsheet-row-session">Mostrar solo las partidas</option>
      </select>
  </div>
  </div>
  <div class="table-responsive mt-1">
    <table class="table table-hover">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Fecha</th>
          <th scope="col">Partida</th>
          <th scope="col">Master</th>
          <th scope="col">Nivel</th>
          <th scope="col">Oro</th>
          <th scope="col"><span class="link-dotted" data-toggle="tooltip" data-placement="bottom" title="Puntos de Tesoro">PT</span></th>
          <th scope="col">Objetos mágicos</th>
          <th scope="col">Notas</th>
        </tr>
      </thead>
      <tbody>
        <? foreach ($logsheet as $ls) : ?>
          <tr class="logsheet-row <?= $ls->session_uid ? 'logsheet-row-session' : ''?>">
            <th scope="col"><?= date('d/m/Y H:i', strtotime($ls->date)) ?></th>
            <td>
              <? if ($ls->session_uid) : ?>
                <a href="<?= base_url('session/view') ?>/<?= $ls->session_uid   ?>" class="text-dark font-weight-bold"><?= $ls->adventure ?></a>
              <? else : ?>
                -
              <? endif; ?>
            </td>
            <td>
              <? if ($ls->master) : ?>
                <a href="<?= base_url('profile') ?>/<?= $ls->master ?>"><?= $ls->master_name ?></a>
              <? endif; ?>
            </td>
            <td><?= (int) $ls->level ?> <? if (fmod($ls->level, 1)) : ?><span class="text-small">(+<?= fmod($ls->level, 1) ?>)</span><? endif; ?></td>
            <td><?= $ls->gold ?></td>
            <td><?= $ls->treasure_points ?></td>
            <td>
              <? if ($ls->total_items) : ?>
                <span class="link-dotted" data-toggle="tooltip" data-placement="bottom" title="<?= $ls->items ?>"><?= $ls->total_items ?> objeto<?= $ls->total_items != 1 ? 's' : '' ?> mágico<?= $ls->total_items != 1 ? 's' : '' ?></span>
              <? else : ?>
                <span>0 objetos mágicos</span>
              <? endif; ?>
            </td>
            <td>
              <? if ($ls->death) : ?>
                <strong class="pl-1 pr-1 text-white bg-dark"><i class="fa-solid fa-skull"></i> ¡MUERE!</strong>
              <? endif; ?>
              <?= $ls->notes ?>
            </td>
          </tr>
        <? endforeach; ?>
      </tbody>
    </table>
  </div>
<? endif; ?>

<?= view('partials/modals/character_sheet') ?>
<? if (($character->uploaded_sheet != $character->validated_sheet && ($isOwner || ($userdata && $userdata['master']))) && $character->validated_sheet) : ?>
  <?= view('partials/modals/character_sheet_validated') ?>
<? endif; ?>
<? if ($isOwner || ($userdata && $userdata['admin'])) : ?>
    <?= view('partials/modals/update_character') ?>
  <?= view('partials/modals/delete_character') ?>
<? endif; ?>
<? if ($userdata && $userdata['master']) : ?>
  <?= view('partials/modals/validate_sheets') ?>
  <?= view('partials/modals/define_logsheet') ?>
  <?= view('partials/modals/log_add', ['character' => $character, 'character_items' => $items, 'all_items' => $all_items]) ?>
<? endif; ?>
<? if ($character->image) : ?>
  <?= view('partials/modals/image', ['title' => $character->name, 'img' => (base_url('img/characters').'/'.$character->image) ]) ?>
<? endif; ?>
<?= view('partials/modals/magic_items', ['items' => $items, 'userdata' => $userdata]) ?>