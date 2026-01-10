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

<form class="row mb-3">
  <div class="col-md-6 mb-1">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createOrUpdateResourceModal">
      <i class="fas fa-plus"></i> Nuevo Recurso
    </button>
  </div>
  <div class="col-md-6">
    <input type="text" class="form-control" name="q" value="<?= $q ?>" placeholder="Búsqueda...">
  </div>
</form>

<div class="table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Título</th>
        <th>Descripción</th>
        <th>Tipo</th>
        <th>Enlace</th>
        <th>Orden</th>
        <th>Activo</th>
      </tr>
    </thead>
    <tbody>
      <? foreach ($resources as $resource) : ?>
        <tr>
          <td>
            <strong><?= $resource->title ?></strong>
            <div>
              <small>
                <a href="#" class="js-edit-resource" data-info="<?= htmlspecialchars(json_encode($resource), ENT_QUOTES, 'UTF-8') ?>">
                  <i class="fa-solid fa-edit"></i> Editar
                </a>
              </small>
            </div>
          </td>
          <td><?= $resource->description ?></td>
          <td>
            <? if ($resource->type == 'url') : ?>
              <i class="fa-solid fa-link text-primary me-2"></i>
            <? elseif ($resource->type == 'file') : ?>
              <i class="fa-solid fa-file text-success me-2"></i>
            <? endif; ?>
            <?= $resource->type ?>
          </td>
          <td><a href="<?= $resource->location ?>" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> Ver</a></td>
          <td><?= $resource->position ?></td>
          <td><input type="checkbox" class="js-update-resource-active" data-id="<?= $resource->id ?>" <?= $resource->active ? 'checked' : '' ?>></td>
        </tr>
      <? endforeach; ?>
    </tbody>
  </table>
</div>

<div class="text-right text-muted">
  Mostrando <?= count($resources) ?> de <?= $total ?> resultados
</div>

<?= $pagination ?>

<?= view('partials/modals/resource_new_edit') ?>