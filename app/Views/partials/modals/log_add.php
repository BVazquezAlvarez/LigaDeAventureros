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

<div class="modal fade" id="add-log-modal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form class="modal-content" method="post" action="<?= base_url('master/logsheet_create_standalone') ?>">
            <div class="modal-header">
                <h5 class="modal-title">Añadir log</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <input type="hidden" name="character_uid" value="<?= $character->uid ?>">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="level">Nivel</label>
                        <input type="number" step="0.5" name="level" id="level" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="gold">Oro</label>
                        <input type="number" step="1" name="gold" id="gold" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="treasure_points">PT</label>
                        <input type="number" step="1" name="treasure_points" id="treasure_points" class="form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="magic_items_add">Añadir objetos mágicos</label>
                        <select class="s2-multi" id="magic_items_add" name="magic_items_add[]" multiple style="width:100%">
                            <? foreach ($all_items as $item) : ?>
                                <option value='<?= $item->id ?>'><?= $item->name ?></option>
                            <? endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="magic_items_rm">Eliminar objetos mágicos</label>
                        <select class="s2-multi" id="magic_items_rm" name="magic_items_rm[]" multiple style="width:100%">
                            <? foreach ($character_items as $item) : ?>
                                <option value='<?= $item->unique_item_id ?>'><?= $item->name ?></option>
                            <? endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="notes">Notas</label>
                        <textarea class="form-control" id="notes" name="notes" rows="5"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>