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

<div class="modal fade" id="new-merchant-modal" tabindex="-1">
    <form class="modal-dialog modal-dialog-centered" method="post" action="<?= base_url('admin/new-merchant') ?>" enctype="multipart/form-data">
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
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" id="merchant-permanent" name="permanent" class="form-check-input">
                            <label class="form-check-label" for="merchant-permanent">Permanente</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 js-merchant-permanent">
                    <div class="form-group">
                        <label for="timestamp_start">Inicio <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="timestamp_start" id="timestamp_start" class="form-control" required>
                        <? if (isset(session('validation_errors')['timestamp_start'])) : ?>
                            <small class="text-danger"><?= session('validation_errors')['timestamp_start'] ?></small>
                        <? endif; ?>
                    </div>
                </div>
                <div class="col-md-6 js-merchant-permanent">
                    <div class="form-group">
                        <label for="timestamp_end">Fin <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="timestamp_end" id="timestamp_end" class="form-control" required>
                        <? if (isset(session('validation_errors')['timestamp_end'])) : ?>
                            <small class="text-danger"><?= session('validation_errors')['timestamp_end'] ?></small>
                        <? endif; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
            </div>
        </div>
    </form>
</div>