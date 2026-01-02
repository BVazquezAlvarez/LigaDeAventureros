<?php
// LigaDeAventureros
// Copyright (C) 2026 Santiago González Lago

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
  <div class="card-header text-center">
      <h2 class="d-inline-block mb-0">Registro de eventos de la sesión <?= $adventure->name ?></h2>
      <div><small class="text-muted"><?= date('d/m/Y', strtotime($session->date)) ?></small></div>
  </div>
  <div class="card-body">
      <? if (empty($logs)) : ?>
          <p>No hay eventos registrados para esta sesión.</p>
      <? else : ?>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Jugador</th>
                <th scope="col">Evento</th>
              </tr>
            </thead>
            <tbody>
              <? foreach ($logs as $log) : ?>
                <tr>
                  <td class="align-middle"><?= date('d/m/Y H:i', strtotime($log->timestamp)) ?></td>
                  <td class="align-middle">
                    <? if ($log->player_uid) : ?>
                      <a href="<?= base_url('profile/' . $log->player_uid) ?>"><strong><?= esc($log->player_name) ?></strong></a>
                      <? if ($log->banned) : ?>
                        <span class="badge badge-danger">Usuario bloqueado</span>
                      <? endif; ?>
                      <? if ($log->player_character_uid) : ?>
                        <br/>
                        <a href="<?= base_url('character/' . $log->player_character_uid) ?>"><small><?= esc($log->character_name) ?></small></a>
                      <? endif; ?>
                    <? else : ?>
                      <em>Usuario eliminado</em>
                    <? endif; ?>
                  </td>
                  <td class="align-middle">
                    <? if ($log->event == 'join') : ?>
                      <span class="badge badge-primary">Se ha inscrito en la sesión</span>
                    <? elseif ($log->event == 'cancel') : ?>
                      <span class="badge badge-danger">Ha cancelado su inscripción</span>
                    <? elseif ($log->event == 'swap') : ?>
                      <span class="badge badge-info">Ha cambiado el personaje con el que estaba inscrito</span>
                    <? elseif ($log->event == 'kick') : ?>
                      <span class="badge badge-warning">Ha sido expulsado de la sesión</span>
                    <? endif; ?>
                  </td>
                </tr>
              <? endforeach; ?>
            </tbody>
          </table>
        </div>
      <? endif; ?>
  </div>
</div>