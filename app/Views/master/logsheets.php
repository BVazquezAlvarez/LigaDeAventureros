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

<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Aventura</th>
                <th scope="col">Fecha</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <? if ($logsheets) : ?>
                <? foreach ($logsheets as $ls) : ?>
                    <tr>
                        <td class="align-middle"><strong><?= $ls->adventure_name ?></strong></td>
                        <td class="align-middle"><?= date('d/m/Y', strtotime($ls->date)) ?></td>
                        <td  class="align-middle">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#log-<?= $ls->uid ?>-modal"><i class="fa-solid fa-pencil"></i> Realizar log</button>
                        </td>
                    </tr>
                <? endforeach; ?>
            <? else : ?>
                <tr>
                    <td colspan="3" class="text-center">
                        <i>No quedan logs pendientes.</i>
                    </td>
                </tr>
            <? endif; ?>
        </tbody>
    </table>
</div>

<? foreach ($logsheets as $ls) : ?>
    <div class="modal fade" id="log-<?= $ls->uid ?>-modal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <form class="modal-content" method="post" action="<?= base_url('master/logsheet_create') ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Crear log para <?= $ls->adventure_name ?> (<?= date('d/m/Y', strtotime($ls->date)) ?>)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="session_uid" value="<?= $ls->uid ?>">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Personaje</th>
                                    <th scope="col">Nivel</th>
                                    <th scope="col">Oro</th>
                                    <th scope="col">PT</th>
                                    <th scope="col">Objetos mágicos</th>
                                    <th scope="col">Muere</th>
                                </tr>
                            </thead>
                            <tbody>
                                <? $count = $ls->players_max ?>
                                <? foreach ($ls->session_players as $sp) : ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="log_character[]" value="<?= $sp->character_uid ?>" <?= $count > 0 ? 'checked' : '' ?>>
                                            <? $count-- ?>
                                        </td>
                                        <td>
                                            <a class="font-weight-bold" href="<?= base_url('character') ?>/<?= $sp->character_uid ?>" target="_blank"><?= $sp->name ?></a>
                                            <span class="badge text-small badge-pill badge-rank-<?= rank_get($sp->level) ?>"><?= rank_name(rank_get($sp->level)) ?></span>
                                        </td>
                                        <td class="w-limited">
                                            <input type="number" step="0.5" class="form-control" name="level[<?= $sp->character_uid ?>]">
                                        </td>
                                        <td class="w-limited">
                                            <input type="number" step="1" class="form-control" name="gold[<?= $sp->character_uid ?>]">
                                        </td>
                                        <td class="w-limited">
                                            <input type="number" step="1" class="form-control" name="treasure_points[<?= $sp->character_uid ?>]">
                                        </td>
                                        <td class="w-50">
                                            <select class="s2-multi" name="items[<?= $sp->character_uid ?>][]" multiple style="width:100%">
                                                <? foreach ($items as $item) : ?>
                                                    <option value='<?= $item->id ?>'><?= $item->name ?></option>
                                                <? endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="checkbox" id="death-<?= $sp->character_uid ?>" name="death[]" value="<?= $sp->character_uid ?>">
                                            <label for="death-<?= $sp->character_uid ?>"><i class="fa-solid fa-skull"></i></label>
                                        </td>
                                    </tr>
                                <? endforeach; ?>
                                <tr>
                                    <td colspan="7" class="text-center font-weight-bold">
                                        <label>Recompensa de master</label>
                                    </td>
                                <tr>
                                </tr>
                                    <td colspan="2">
                                        <select class="form-control" name="master_character">
                                            <option value="">No entregar</option>
                                            <? foreach ($my_characters as $ch) : ?>
                                                <option value='<?= $ch->uid ?>'><?= $ch->name ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </td>
                                    <td class="w-limited">
                                        <input type="number" step="0.1" class="form-control" name="level_master">
                                    </td>
                                    <td class="w-limited">
                                        <input type="number" step="1" class="form-control" name="gold_master">
                                    </td>
                                    <td class="w-limited">
                                        <input type="number" step="1" class="form-control" name="treasure_points_master">
                                    </td>
                                    <td class="w-50">
                                        <select class="s2-multi" name="items_master[]" multiple style="width:100%">
                                            <? foreach ($items as $item) : ?>
                                                <option value='<?= $item->id ?>'><?= $item->name ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <label for="notes">Notas</label>
                    <textarea class="form-control" id="notes" name="notes" rows="5"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
<? endforeach; ?>