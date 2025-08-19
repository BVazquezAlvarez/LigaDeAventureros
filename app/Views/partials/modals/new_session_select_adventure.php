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

<div class="modal fade" id="modal-select-adventure" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title">Seleccionar Aventura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container pt-0">
                    <div class="row mb-1">
                        <div class="col-12">
                            <input type="text" id="js-new-session-filter-adventure-name-search" class="form-control" placeholder="Buscar...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <strong>Tipo</strong>
                            <div class="form-check">
                                <input class="form-check-input js-new-session-filter-type" type="radio" name="js-new-session-filter-type" id="js-new-session-filter-type-0" value="0" checked>
                                <label class="form-check-label" for="js-new-session-filter-type-0">
                                    Todos los tipos
                                </label>
                            </div>
                            <? foreach ($adventure_type as $adv_type) : ?>
                                <div class="form-check">
                                    <input class="form-check-input js-new-session-filter-type" type="radio" name="js-new-session-filter-type" id="js-new-session-filter-type-<?=$adv_type->id ?>" value="<?=$adv_type->id ?>">
                                    <label class="form-check-label" for="js-new-session-filter-type-<?=$adv_type->id ?>">
                                        <?= $adv_type->name ?>
                                    </label>
                                </div>
                            <? endforeach; ?>
                        </div>
                        <div class="col-4">
                            <strong>Rango</strong>
                            <div class="form-check">
                                <input class="form-check-input js-new-session-filter-rank" type="radio" name="js-new-session-filter-rank" id="js-new-session-filter-rank-0" value="0" checked>
                                <label class="form-check-label" for="js-new-session-filter-rank-0">
                                    Todos los rangos
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input js-new-session-filter-rank" type="radio" name="js-new-session-filter-rank" id="js-new-session-filter-rank-1" value="1">
                                <label class="form-check-label" for="js-new-session-filter-rank-1">
                                    <?= rank_name(1) ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input js-new-session-filter-rank" type="radio" name="js-new-session-filter-rank" id="js-new-session-filter-rank-2" value="2">
                                <label class="form-check-label" for="js-new-session-filter-rank-2">
                                    <?= rank_name(2) ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input js-new-session-filter-rank" type="radio" name="js-new-session-filter-rank" id="js-new-session-filter-rank-3" value="3">
                                <label class="form-check-label" for="js-new-session-filter-rank-3">
                                    <?= rank_name(3) ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input js-new-session-filter-rank" type="radio" name="js-new-session-filter-rank" id="js-new-session-filter-rank-4" value="4">
                                <label class="form-check-label" for="js-new-session-filter-rank-4">
                                    <?= rank_name(4) ?>
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <strong>Modalidad</strong>
                            <div class="form-check">
                                <input class="form-check-input js-new-session-filter-wsetting" type="radio" name="js-new-session-filter-wsetting" id="js-new-session-filter-wsetting-0" value="0" checked>
                                <label class="form-check-label" for="js-new-session-filter-wsetting-0">
                                    Todas las modalidades
                                </label>
                            </div>
                            <? foreach ($world_settings as $setting) : ?>
                                <div class="form-check">
                                    <input class="form-check-input js-new-session-filter-wsetting" type="radio" name="js-new-session-filter-wsetting" id="js-new-session-filter-wsetting-<?=$setting->id ?>" value="<?=$setting->id ?>">
                                    <label class="form-check-label" for="js-new-session-filter-wsetting-<?=$setting->id ?>">
                                        <?= $setting->name ?>  (<?= $setting->timeline ?>)
                                    </label>
                                </div>
                            <? endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Aventura</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Rango</th>
                                <th scope="col">Modalidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($adventures as $adventure) : ?>
                                <tr class="js-new-session-filter-adventure" data-uid="<?= $adventure->uid ?>" data-name="<?= $adventure->name ?>" data-rank="<?= $adventure->rank ?: 0?>" data-type="<?= $adventure->type ?>" data-wsetting="<?= $adventure->w_setting_id ?: 0 ?>">
                                    <td class="align-middle">
                                        <button class="js-new-session-select-adventure btn btn-primary" type="button" data-uid="<?= $adventure->uid ?>">
                                            Seleccionar
                                        </button>
                                    </td>
                                    <td class="align-middle"><?= $adventure->name ?></td>
                                    <td class="align-middle"><?= $adventure->type_name ?></td>
                                    <td class="align-middle"><?= rank_full_text($adventure->rank) ?></td>
                                    <td class="align-middle"><?= $adventure->w_setting_id ? ($adventure->w_setting_name . ' (' . $adventure->timeline . ')') : 'Todas las modalidades' ?></td>
                                </tr>
                            <? endforeach; ?>
                            <tr>
                                <td class="align-middle">
                                    <button class="js-new-session-select-adventure btn btn-primary" data-uid="__new" type="button">
                                        Seleccionar
                                    </button>
                                </td>
                                <td class="align-middle" colspan="4"><strong>Crear una nueva aventura</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>