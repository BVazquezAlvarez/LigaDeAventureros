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

<div class="modal fade" id="update-character-modal" tabindex="-1">
    <form class="modal-dialog modal-xl modal-dialog-centered" method="post" action="<?= base_url('update-character') ?>" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualizar <span id="modal-character-name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Nombre <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="class">Clase <span class="text-danger">*</span></label>
                                <input type="text" name="class" id="class" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="level">Nivel <span class="text-danger">*</span></label>
                                <input type="number" min="1" max="20" name="level" id="level" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="character_sheet">Hoja de personaje (Tamaño máximo: <strong>5MB</strong>)</label>
                                <input type="file" name="character_sheet" id="character_sheet" class="form-control-file" accept=".pdf">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="character_image">Imagen (Tamaño máximo: <strong>5MB</strong>)</label>
                                <input type="file" name="character_image" id="character_image" class="form-control-file" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="wiki">Enlace Wiki</label>
                                <input type="url" name="wiki" id="wiki" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description">Biografía</label>
                        <textarea name="description" id="description" rows="14" class="form-control"></textarea>
                    </div>
                </div>
                <input type="hidden" id="uid" name="uid">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </form>
</div>