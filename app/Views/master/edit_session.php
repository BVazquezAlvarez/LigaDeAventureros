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
        <h2 class="d-inline-block mb-0">Editar sesión</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <form method="post" enctype="multipart/form-data" class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="session_master">Master <span class="text-danger">*</span></label>
                            <select id="session_master" name="session_master" class="form-control" required>
                                <? foreach ($masters as $master) : ?>
                                    <option value="<?= $master->uid ?>" <?= $session->master_uid == $master->uid ? 'selected' : '' ?>><?= $master->display_name ?></option>
                                <? endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="session_date">Fecha <span class="text-danger">*</span></label>
                            <input type="date" name="session_date" id="session_date" class="form-control" value="<?= date('Y-m-d', strtotime($session->date)) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="session_time">Hora <span class="text-danger">*</span></label>
                            <input type="time" name="session_time" id="session_time" class="form-control" value="<?= date('H:i', strtotime($session->time)) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="location">Ubicación <span class="text-danger">*</span></label>
                            <input type="text" name="location" id="location" class="form-control" list="locations" value="<?= $session->location ?>" required>
                            <datalist id="locations">
                                <? foreach ($locations as $location) : ?>
                                    <option value="<?= $location->location ?>">
                                <? endforeach; ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label>Número de jugadores</label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="session_min_players">Mínimo <span class="text-danger">*</span></label>
                            <input type="text" name="session_min_players" id="session_min_players" value="<?= $session->players_min ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="session_max_players">Máximo <span class="text-danger">*</span></label>
                            <input type="text" name="session_max_players" id="session_max_players" value="<?= $session->players_max ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" name="published" id="published" <?= $session->published ? 'checked' : '' ?> class="form-check-input">
                                <label class="form-check-label" for="published">Publicada</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-md-6">
            <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Personaje</th>
                                <th scope="col">Jugador</th>
                                <th scope="col">Registrado</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($players as $player) : ?>
                                <tr>
                                    <td class="align-middle">
                                        <a href="<?= base_url('character_sheets') ?>/<?= $player->uploaded_sheet ?>" target="_blank"><?= $player->name ?></a><br/>
                                        Nivel <?= $player->level ?> (<?= rank_name(rank_get($player->level)) ?>)
                                    </td>
                                    <td class="align-middle">
                                        <a href="<?= base_url('profile') ?>/<?= $player->uid ?>" target="_blank"><?= $player->display_name ?> </a>
                                    </td>
                                    <td class="align-middle"><?= date('d/m/Y H:i:s', strtotime($player->timestamp)) ?></td>
                                    <td class="align-middle">
                                        <button class="btn btn-danger js-session-kick" data-uid="<?= $player->uid ?>" data-name="<?= $player->name ?>">Expulsar</button>
                                    </td>
                                </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" id="session-kick-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="post" action="<?= base_url('master/kick') ?>">
            <div class="modal-body">
                <h5>¿Quieres expulsar a <span id="character-name"></span> de la sesión?</h5>
                <input type="hidden" id="player-uid" name="player-uid">
                <input type="hidden" id="session-uid" name="session-uid" value="<?= $session->uid ?>">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Sí</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </form>
    </div>
</div>