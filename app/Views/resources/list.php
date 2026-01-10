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
  <div class="col-md-6 offset-md-6">
    <input type="text" class="form-control" name="q" value="<?= $q ?>" placeholder="Búsqueda...">
  </div>
</form>

<div class="table-responsive">
  <table class="table table-hover">
    <tbody>
      <? foreach ($resources as $resource) : ?>
        <tr>
          <td class="align-middle p-0">
            <a href="<?= $resource->location ?>" target="_blank" class="text-decoration-none text-dark d-block p-3" title="#">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?= $resource->title ?>
                  <div><small>
                    <? if ($resource->type == 'url') : ?>
                      <i class="fa-solid fa-link text-primary me-2"></i>
                    <? elseif ($resource->type == 'file') : ?>
                      <i class="fa-solid fa-file text-success me-2"></i>
                    <? endif; ?>
                    <span class="text-muted"><?= $resource->description ?></span>
                  </small></div>
                </div>
                <div>
                  <i class="fa-solid fa-arrow-up-right-from-square fa-lg text-muted"></i>
                </div>
              </div>
            </a>
          </td>
        </tr>
      <? endforeach; ?>
    </tbody>
  </table>
</div>

<div class="text-right text-muted">
  Mostrando <?= count($resources) ?> de <?= $total ?> resultados
</div>

<?= $pagination ?>