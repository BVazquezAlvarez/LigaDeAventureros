<?php
// LigaDeAventureros
// Copyright (C) 2026 Santiago González Lago

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

<div class="modal fade" id="createOrUpdateResourceModal" tabindex="-1" role="dialog" aria-labelledby="createOrUpdateResourceModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createOrUpdateResourceModalLabel">Nuevo Recurso</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="createResourceForm" method="post" action="<?= base_url('admin/update-resource') ?>" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id" value="">
        <div class="modal-body">
          <div class="form-group">
            <label for="title">Título <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="title" name="title" required>
          </div>
          <div class="form-group">
            <label for="description">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="type">Tipo <span class="text-danger">*</span></label>
            <select class="form-control" id="type" name="type" required>
              <option value="">Seleccionar tipo...</option>
              <option value="file">Archivo</option>
              <option value="url">URL/Enlace</option>
            </select>
          </div>
          <div class="form-group">
            <label for="location">Localización <span class="text-danger">*</span></label>
            <div id="location-field-container">
              <div class="alert alert-info">
                Seleccione un tipo para continuar
              </div>
            </div>
            <small class="form-text text-muted" id="location-help"></small>
          </div>
          <div class="form-group">
            <label for="position">Orden <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="position" name="position" required min="0" value="0">
          </div>
          <div class="form-group">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="active" name="active" checked>
              <label class="form-check-label" for="active">Activo</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>