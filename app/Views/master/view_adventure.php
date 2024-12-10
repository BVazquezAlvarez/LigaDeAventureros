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
    <div class="card-header text-center">
        <h2 class="d-inline-block mb-0"><?= $adventure->name ?></h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="text-center mb-3">
                    <img class="img-fluid" src="<?= base_url('img/adventures') ?>/<?= $adventure->thumbnail ?>" alt="<?= $adventure->name ?>">
                    <h2><?= $adventure->name ?></h2>
                    <h4><?= rank_full_text($adventure->rank) ?></h4>
                    <? if ($adventure->w_setting_id == 0) : ?>
                        <h4>Todas las modalidades</h4>
                    <? else :?>
                        <h4><?= $adventure->w_setting_name?></h4>
                    <? endif; ?>
                        <h5><?= $adventure->type_name?></h5>
                    <p>
                        <div><strong>Jugadores:</strong> <?= $adventure->players_min_recommended ?>-<?= $adventure->players_max_recommended ?></div>
                        <div><strong>Duración:</strong> <?= $adventure->duration ?></div>
                        <? if ($adventure->themes) : ?>
                            <div><strong>Temas:</strong> <?= $adventure->themes ?></div>
                        <? endif; ?>
                    </p>
                    <p><i><?= str_replace("\r\n", '<br>', $adventure->description) ?></i></p>
                    <p><?= str_replace("\r\n", '<br>', $adventure->rewards) ?></p>
                    <a href="<?= base_url('master/edit-adventure') ?>/<?= $adventure->uid ?>" class="btn btn-primary"><i class="fa-solid fa-pen"></i> Editar</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Fecha</th>
                                <th scope="col">Master</th>
                                <th scope="col">Ubicación</th>
                                <th scope="col">Jugadores</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($sessions as $session) : ?>
                                <tr>
                                    <td class="align-middle"><?= date('d/m/Y', strtotime($session->date)) ?> <?= date('H:i', strtotime($session->time)) ?></td>
                                    <td class="align-middle"><?= $session->master_name ?></td>
                                    <td class="align-middle"><?= $session->location ?></td>
                                    <td class="align-middle"><?= $session->players_min ?>-<?= $session->players_max ?> (<?= $session->registered_players ?>)</td>
                                    <td class="align-middle">
                                        <a href="<?= base_url('master/edit-session') ?>/<?= $session->uid ?>" class="btn btn-primary mb-1">Editar</a>
                                        <? if ($session->master_uid == $userdata['uid']) : ?>
                                            <button class="btn btn-danger mb-1 js-session-rm" data-uid="<?= $session->uid ?>">Eliminar</button>
                                        <? endif; ?>
                                    </td>
                                </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('partials/modals/session_remove') ?>