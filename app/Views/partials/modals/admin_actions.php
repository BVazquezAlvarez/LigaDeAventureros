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

<div class="modal fade" id="master-add-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="post" action="<?= base_url('admin/user-toggle-master') ?>">
            <div class="modal-body">
                <h5>¿Quieres que <span id="user-name"></span> sea <strong>master</strong>?</h5>
                <input type="hidden" id="uid" name="uid">
                <input type="hidden" name="master" value="1">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Sí</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="master-rm-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="post" action="<?= base_url('admin/user-toggle-master') ?>">
            <div class="modal-body">
                <h5>¿Quieres que <span id="user-name"></span> deje de ser <strong>master</strong>?</h5>
                <input type="hidden" id="uid" name="uid">
                <input type="hidden" name="master" value="0">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Sí</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="admin-add-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="post" action="<?= base_url('admin/user-toggle-admin') ?>">
            <div class="modal-body">
                <h5>¿Quieres que <span id="user-name"></span> sea <strong>administrador</strong>?</h5>
                <input type="hidden" id="uid" name="uid">
                <input type="hidden" name="admin" value="1">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Sí</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="admin-rm-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="post" action="<?= base_url('admin/user-toggle-admin') ?>">
            <div class="modal-body">
                <h5>¿Quieres que <span id="user-name"></span> deje de ser <strong>administrador</strong>?</h5>
                <input type="hidden" id="uid" name="uid">
                <input type="hidden" name="admin" value="0">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Sí</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="ban-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="post" action="<?= base_url('admin/user-ban') ?>">
            <div class="modal-body">
                <h5>¿Quieres que <strong class="text-danger">BLOQUEAR</strong> al usuario <span id="user-name"></span>?</h5>
                <input type="hidden" id="uid" name="uid">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Sí</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="unban-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="post" action="<?= base_url('admin/user-unban') ?>">
            <div class="modal-body">
                <h5>¿Quieres que <strong class="text-danger">DESBLOQUEAR</strong> al usuario <span id="user-name"></span>?</h5>
                <input type="hidden" id="uid" name="uid">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Sí</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </form>
    </div>
</div>