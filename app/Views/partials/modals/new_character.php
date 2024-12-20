<?php
// LigaDeAventureros
// Copyright (C) 2023-2024 Santiago González Lago

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

<div class="modal fade" id="new-character-modal" tabindex="-1">
    <form class="modal-dialog modal-dialog-centered" method="post" action="<?= base_url('new-character') ?>" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo personaje</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" required>
                        <? if (isset(session('validation_errors')['name'])) : ?>
                            <small class="text-danger"><?= session('validation_errors')['name'] ?></small>
                        <? endif; ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="class">Clase <span class="text-danger">*</span></label>
                        <input type="text" name="class" id="class" class="form-control" required>
                        <? if (isset(session('validation_errors')['class'])) : ?>
                            <small class="text-danger"><?= session('validation_errors')['class'] ?></small>
                        <? endif; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="level">Nivel <span class="text-danger">*</span></label>
                        <input  name="level" id="level" class="form-control" type="number" min="1" max="20" required>
                        <? if (isset(session('validation_errors')['level'])) : ?>
                            <small class="text-danger"><?= session('validation_errors')['level'] ?></small>
                        <? endif; ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="w_setting_id">Modalidad <span class="text-danger">*</span></label>
                        <select name="w_setting_id" id="w_setting_id" class="form-control">
                          <? foreach ($world_settings as $setting) : ?>
                            <option value="<?=$setting->id ?>"><?=$setting->name ?>  (<?= $setting->timeline ?>)</option>
                        <? endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="character_sheet">Hoja de personaje (Tamaño máximo: <strong>5MB</strong>) <span class="text-danger">*</span></label>
                        <input type="file" name="character_sheet" id="character_sheet" class="form-control-file" accept=".pdf" required>
                    </div>
                    <? if (isset(session('validation_errors')['character_sheet'])) : ?>
                        <small class="text-danger"><?= session('validation_errors')['character_sheet'] ?></small>
                    <? endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
            </div>
        </div>
    </form>
</div>