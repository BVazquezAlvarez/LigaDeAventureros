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

<form class="card" method="post" enctype="multipart/form-data">
    <div class="card-header text-center">
        <h2 class="d-inline-block mb-0">Editando mercader: <?= $merchant->name ?></h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" value="<?= $merchant->name ?>" required>
                            <? if (isset(session('validation_errors')['name'])) : ?>
                                <small class="text-danger"><?= session('validation_errors')['name'] ?></small>
                            <? endif; ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" id="merchant-permanent" name="permanent" class="form-check-input" <?= $merchant->permanent ? 'checked' : '' ?>>
                                <label class="form-check-label" for="merchant-permanent">Permanente</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 js-merchant-permanent" style="<?= $merchant->permanent ? 'display:none' : '' ?>">
                        <div class="form-group">
                            <label for="timestamp_start">Inicio <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="timestamp_start" id="timestamp_start" class="form-control" value="<?= $merchant->timestamp_start ?>" <?= $merchant->permanent ? '' : 'required' ?>>
                            <? if (isset(session('validation_errors')['timestamp_start'])) : ?>
                                <small class="text-danger"><?= session('validation_errors')['timestamp_start'] ?></small>
                            <? endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6 js-merchant-permanent" style="<?= $merchant->permanent ? 'display:none' : '' ?>">
                        <div class="form-group">
                            <label for="timestamp_end">Fin <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="timestamp_end" id="timestamp_end" class="form-control" value="<?= $merchant->timestamp_end ?>" <?= $merchant->permanent ? '' : 'required' ?>>
                            <? if (isset(session('validation_errors')['timestamp_end'])) : ?>
                                <small class="text-danger"><?= session('validation_errors')['timestamp_end'] ?></small>
                            <? endif; ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="add-items">Añadir objetos</label>
                            <select class="s2-multi" id="add-items" name="add_items[]" multiple style="width:100%">
                                <? foreach ($all_items as $item) : ?>
                                    <option value='<?= $item->id ?>'><?= $item->name ?></option>
                                <? endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Objeto</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($merchant_items as $item) : ?>
                                <tr>
                                    <td><?= $item->name ?></td>
                                    <td><?= $item->cost ?> PTs</td>
                                    <td class="text-center">
                                        <input type="checkbox" name="rm_items[]" value="<?= $item->merchant_item_id ?>" class="form-check-input">
                                    </td>
                                </tr>
                            <? endforeach; ?>
                            <? if (!$merchant_items) : ?>
                                <tr><td colspan="3" class="text-center"><i>Este mercader no tiene objetos</i></td></tr>
                            <? endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-center">
        <a href="<?= base_url('admin/merchants') ?>" class="btn btn-secondary">Volver</a>
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
    </div>
</form>