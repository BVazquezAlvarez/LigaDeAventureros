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

<div class="row mb-3">
    <div class="col-md-6">
        <form class="card" method="post">
            <div class="card-header">
                <h4 class="d-inline-block mb-0">Filtrar aventuras</h4>
            </div>
            <div class="card-body row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="q">Nombre</label>
                        <input type="text" class="form-control" id="q" name="q" value="<?= $filters['q'] ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="rank">Rango:</label>
                        <select class="form-control" id="rank" name="rank">
                            <option value="">Todos</option>
                            <? for ($i = 1; $i <= 4; $i++) : ?>
                                <option value="<?= $i ?>" <?= $filters['rank'] == $i ? 'selected' : '' ?>><?= rank_full_text($i) ?></option>
                            <? endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="my_games" name="my_games" value="1" <?= $filters['my_games'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="my_games">Solo aventuras que he dirigido</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="unplayed" name="unplayed" value="1" <?= $filters['unplayed'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="unplayed">Solo aventuras sin sesiones jugadas</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-primary" id="applyFiltersBtn"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Aventura</th>
                <th scope="col">Rango</th>
                <th scope="col">Duración</th>
                <th scope="col">Jugadores</th>
                <th scope="col">Modalidad</th>
                <th scope="col">Tipo</th>
                <th scope="col">S. Jugadas</th>
                <th scope="col">Última sesión</th>
                <th scope="col">S. programadas</th>
                <th scope="col">Próxima sesión</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($adventures as $adv) : ?>
                <tr>
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
                    <td class="align-middle"><?= $adv->total_past ?></td>
                    <td class="align-middle">
                        <? if ($adv->last_session_datetime) : ?>
                            <?= date('d/m/Y H:i', strtotime($adv->last_session_datetime)) ?>
                        <? else : ?>
                            <span class="text-danger">Ninguna</span>
                        <? endif; ?>
                    </td>
                    <td class="align-middle"><?= $adv->total_future ?></td>
                    <td class="align-middle">
                        <? if ($adv->next_session_datetime) : ?>
                            <?= date('d/m/Y H:i', strtotime($adv->next_session_datetime)) ?>
                        <? else : ?>
                            <span class="text-danger">Ninguna</span>
                        <? endif; ?>
                    </td>
                </tr>
            <? endforeach; ?>
            <? if (!$adventures) : ?>
                <tr>
                    <td class="text-center" colspan="10">No hay ninguna aventura que coincida con tus filtros</td>
                </tr>
            <? endif; ?>
        </tbody>
    </table>
</div>