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

<form class="row mb-3">
    <div class="col-md-6 offset-md-6">
        <input type="text" class="form-control" name="q" value="<?= $q ?>" placeholder="Búsqueda...">
    </div>
</form>

<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th colspan="2" scope="col" class="text-center">Usuario</th>
                <th scope="col" class="text-center">Fecha de registro</th>
                <th scope="col" class="text-center">Confirmado</th>
                <th scope="col" class="text-center">Master</th>
                <th scope="col" class="text-center">Administrador</th>
                <th scope="col" class="text-center">Bloqueado</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($users as $user) : ?>
                <tr>
                    <th class="align-middle text-right" scope="row"><a href="<?= base_url('profile') ?>/<?= $user->uid ?>" target="_blank"><?= $user->uid ?></a></th>
                    <td class="align-middle">
                        <?= $user->display_name ?>
                        <? if ($user->uid != session('user_uid') && !$user->banned) : ?>
                            <br/><a href="<?= base_url('admin/user_login') ?>/<?= $user->uid ?>">Suplantar</a>
                        <? endif; ?>
                    </td>
                    <td class="align-middle text-center"><?= date('d/m/Y H:i:s', strtotime($user->date_created)) ?></a></td>
                    <td class="align-middle text-center">
                        <? if ($user->confirmed) : ?>
                            <span class="badge badge-lg badge-success">Sí</span>
                        <? else : ?>
                            <span class="badge badge-lg badge-warning">No</span>
                        <? endif; ?>
                    </td>
                    <td class="align-middle text-center">
                        <? if ($user->master) : ?>
                            <button class="btn badge badge-lg badge-primary js-master-rm" data-uid="<?= $user->uid ?>" data-name="<?= $user->display_name ?>">Sí</span>
                        <? else : ?>
                            <? if (!$user->confirmed || $user->banned) : ?>
                                <span class="badge badge-lg badge-secondary">No</span>
                            <? else : ?>
                                <button class="btn badge badge-lg badge-secondary js-master-add" data-uid="<?= $user->uid ?>" data-name="<?= $user->display_name ?>">No</span>
                            <? endif; ?>
                        <? endif; ?>
                    </td>
                    <td class="align-middle text-center">
                        <? if ($user->admin) : ?>
                            <button class="btn badge badge-lg badge-primary js-admin-rm" data-uid="<?= $user->uid ?>" data-name="<?= $user->display_name ?>">Sí</span>
                        <? else : ?>
                            <? if (!$user->confirmed || $user->banned) : ?>
                                <span class="badge badge-lg badge-secondary">No</span>
                            <? else : ?>
                                <button class="btn badge badge-lg badge-secondary js-admin-add" data-uid="<?= $user->uid ?>" data-name="<?= $user->display_name ?>">No</span>
                            <? endif; ?>
                        <? endif; ?>
                    </td>
                    <td class="align-middle text-center">
                        <? if ($user->banned) : ?>
                            <button class="btn badge badge-lg badge-danger js-unban" data-uid="<?= $user->uid ?>" data-name="<?= $user->display_name ?>">Sí</span>
                        <? else : ?>
                            <button class="btn badge badge-lg badge-secondary js-ban" data-uid="<?= $user->uid ?>" data-name="<?= $user->display_name ?>">No</span>
                        <? endif; ?>
                    </td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
</div>

<div class="text-right text-muted">
    Mostrando <?= count($users) ?> de <?= $total ?> resultados
</div>

<?= $pagination ?>

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