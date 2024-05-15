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

$rarities = array(
    'common' => 'common',
    'uncommon' => 'uncommon',
    'rare' => 'rare',
    'very_rare' => 'very rare',
    'legendary' => 'legendary',
);
?>

<div class="modal fade" id="new-automatic-merchant-modal" tabindex="-1">
    <form class="modal-dialog modal-dialog-centered" method="post" action="<?= base_url('admin/new-automatic-merchant') ?>" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo mercader</h5>
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="timestamp_start">Inicio <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="timestamp_start" id="timestamp_start" class="form-control" required>
                        <? if (isset(session('validation_errors')['timestamp_start'])) : ?>
                            <small class="text-danger"><?= session('validation_errors')['timestamp_start'] ?></small>
                        <? endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="frequency_days">Frecuencia (en días) <span class="text-danger">*</span></label>
                        <input type="number" name="frequency_days" id="frequency_days" class="form-control" required>
                        <? if (isset(session('validation_errors')['frequency_days'])) : ?>
                            <small class="text-danger"><?= session('validation_errors')['frequency_days'] ?></small>
                        <? endif; ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr><th scope="col" colspan="2">Objetos por rareza</th></tr>
                        </thead>
                        <tbody>
                            <? foreach ($rarities as $r_key => $r_name) : ?>
                                <tr>
                                    <th scope="row"><?= $r_name ?></th>
                                    <td><input type="number" class="form-control" name="<?= $r_key ?>" id="<?= $r_key ?>"></td>
                                </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
            </div>
        </div>
    </form>
</div>