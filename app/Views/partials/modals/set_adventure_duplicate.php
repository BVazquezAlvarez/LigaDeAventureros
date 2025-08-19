<?php
// LigaDeAventureros
// Copyright (C) 2025 Santiago González Lago

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

<div class="modal fade" id="modal-set-adventure-duplicate" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content" >
      <div class="modal-header">
        <h5 class="modal-title">Seleccionar Aventura Original</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="<?= base_url('admin/set-adventure-duplicate') ?>" class="modal-body">
        <input type="hidden" name="current_adventure" value="<?= $adventure->uid ?>">
        <div class="row mb-1">
            <div class="col-12">
                <input type="text" id="js-new-session-filter-adventure-name-search" class="form-control" placeholder="Buscar...">
            </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover">
              <thead class="thead-dark">
                <tr>
                  <th scope="col"></th>
                  <th scope="col">Aventura</th>
                  <th scope="col">Rango</th>
                  <th scope="col">Duración</th>
                  <th scope="col">Jugadores</th>
                  <th scope="col">Modalidad</th>
                  <th scope="col">Tipo</th>
                </tr>
              </thead>
              <tbody>
                <? foreach ($adventures as $adv) : ?>
                  <? if ($adv->uid == $adventure->uid) continue; // Skip the current adventure ?>
                  <tr class="js-new-session-filter-adventure" data-uid="<?= $adv->uid ?>" data-name="<?= $adv->name ?>">
                    <td class="align-middle">
                      <input type="radio" name="base_adventure" value="<?= $adv->uid ?>">
                    </td>
                    <th class="align-middle" scope="row"><a href="<?= base_url('master/adventure') ?>/<?= $adv->uid ?>"><?= $adv->name ?></a></th>
                    <td class="align-middle"><?= rank_full_text($adv->rank) ?></td>
                    <td class="align-middle"><?= $adv->duration ?></td>
                    <td class="align-middle"><?= $adv->players_min_recommended ?> a <?= $adv->players_max_recommended ?></td>
                    <td class="align-middle">
                      <? if ($adv->w_setting_id == 0) : ?>
                        Todas las modalidades
                      <? else : ?>
                        <?= $adv->w_setting_name ?>
                      <? endif; ?>
                    </td>
                    <td class="align-middle">
                      <?= $adv->type_name ?>
                    </td>
                  </tr>
                <? endforeach; ?>
              </tbody>
          </table>
        </div>
        <button type="submit" class="btn btn-primary">Confirmar</button>
      </form>
    </div>
  </div>
</div>