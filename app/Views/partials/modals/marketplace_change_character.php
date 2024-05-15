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

<div class="modal fade" id="change-character-modal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar personaje</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <? foreach ($characters as $char) : ?>
                    <label class="d-flex align-items-center mb-1">
                        <input type="radio" class="mr-3" name="active_character" value="<?= $char->uid ?>" <?= $char->uid == $active_character->uid ? 'checked' : '' ?> />
                        <div class="character-image-all-characters">
                            <div class="image-box image-box-circle">
                                <img src="<?= $char->image ? (base_url('img/characters').'/'.$char->image) : base_url('img/placeholder.png') ?>">
                            </div>
                        </div>
                        <strong><?= $char->name ?></strong>
                    </label>
                <? endforeach; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="marketplace-change-character">Aceptar</button>
            </div>
        </div>
    </div>
</div>