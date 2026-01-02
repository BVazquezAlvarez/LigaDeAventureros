<?php
// LigaDeAventureros
// Copyright (C) 2023-2026 Santiago González Lago

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
    <div class="col-md-6 mb-3">
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
        <h2 class="text-center">Mis próximas sesiones</h2>
        <? if ($upcoming_sessions) : ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Aventura</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Ubicación</th>
                            <th scope="col">Jugadores</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach ($upcoming_sessions as $session) : ?>
                            <tr>
                                <td class="align-middle">
                                    <?= $session->adventure_name ?></br>
                                    <?= rank_full_text($session->rank) ?>
                                </td>
                                <td class="align-middle"><?= date('d/m/Y', strtotime($session->date)) ?> <?= date('H:i', strtotime($session->time)) ?></td>
                                <td class="align-middle"><?= $session->location ?></td>
                                <td class="align-middle"><?= $session->players_min ?>-<?= $session->players_max ?> (<?= $session->registered_players ?>)</td>
                                <td class="align-middle">
                                    <a href="<?= base_url('master/edit-session') ?>/<?= $session->uid ?>" class="btn btn-primary mb-1">Editar</a>
                                    <a href="<?= base_url('master/session-log') ?>/<?= $session->uid ?>" class="btn btn-primary mb-1">Log</a>
                                    <? if ($session->master_uid == $userdata['uid']) : ?>
                                        <button class="btn btn-danger mb-1 js-session-rm" data-uid="<?= $session->uid ?>">Eliminar</button>
                                    <? endif; ?>
                                </td>
                            </tr>
                        <? endforeach; ?>
                    </tbody>
                </table>
            </div>
        <? else : ?>
            <div class="text-center">No tienes ninguna sesión futura publicada</div>
        <? endif; ?>
    </div>
</div>

<?= view('partials/modals/session_remove') ?>