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

<? if ($sessions) : ?>
    <form id="publish-sessions-form" method="post">
        <div class="mb-1 text-right">
            <button type="submit" class="btn btn-primary js-publish-submit"><i class="fa-solid fa-eye"></i> Publicar seleccionadas</button>
            <button type="button" class="btn btn-primary" id="publish-later"><i class="fa fa-clock"></i> Programar seleccionadas</button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">
                            <input type="checkbox" id="checkbox-select-all">
                        </th>
                        <th scope="col">Aventura</th>
                        <th scope="col">Rango</th>
                        <th scope="col">Modalidad</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Master</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Publicación programada</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($sessions as $session) : ?>
                        <tr>
                            <td class="align-middle">
                                <input type="checkbox" name="session[]" value="<?= $session->uid ?>" class="js-checkbox-select-all">
                            </td>
                            <th class="align-middle" scope="row"><?= $session->adventure_name ?></th>
                            <td class="align-middle"><?= rank_full_text($session->rank) ?></td>
                            <? if ($session->w_setting_id != 0) : ?>
                                <td class="align-middle"><?= $session->w_setting_name ?></td>
                            <? else: ?>
                                <td>Todas las modalidades</td>
                            <? endif; ?>
                            <td class="align-middle"><?= $session->type_name ?></td>
                            <td class="align-middle"><?= $session->master ?></td>
                            <td class="align-middle"><?= date('d/m/Y', strtotime($session->date)) ?></td>
                            <td class="align-middle"><?= date('H:i', strtotime($session->time)) ?></td>
                            <td class="align-middle">
                                <? if ($session->date_published) : ?>
                                    <?= date('d/m/Y H:i', strtotime($session->date_published)) ?>
                                <? else : ?>
                                    <i class="text-muted">No programada</i>
                                <? endif; ?>
                            </td>
                        </tr>
                    <? endforeach; ?>
                    <? if (!$sessions) : ?>
                        <tr>
                            <td class="text-center" colspan="9">No hay sesiones sin publicar</td>
                        </tr>
                    <? endif; ?>
                </tbody>
            </table>
        </div>
    </form>

    <!-- Modal para programar publicación -->
    <div class="modal fade" id="schedule-publish-modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="post" action="<?= base_url('master/publish-later') ?>" id="schedule-publish-form">
                <div class="modal-header">
                    <h5 class="modal-title">Programar publicación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="schedule_date">Fecha de publicación <span class="text-danger">*</span></label>
                        <input type="date" name="schedule_date" id="schedule_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="schedule_time">Hora de publicación <span class="text-danger">*</span></label>
                        <input type="time" name="schedule_time" id="schedule_time" class="form-control" required>
                    </div>
                    <input type="hidden" id="sessions-to-schedule" name="sessions" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Programar</button>
                </div>
            </form>
        </div>
    </div>
<? else : ?>
    <p class="text-center">No hay ninguna sesión sin publicar</p>
    <p class="text-center">
        <a href="<?= base_url('master/new-session') ?>">¿Por qué no creas una nueva?</a>
    </p>
<? endif; ?>