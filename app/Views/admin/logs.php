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

<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Usuario</th>
                <th scope="col">Fichero</th>
                <th scope="col">REMOTE_ADDR</th>
                <th scope="col">HTTP_X_FORWARDED_FOR</th>
                <th scope="col">Fecha</th>
                <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($logs as $log) : ?>
                <tr>
                    <td class="align-middle"><a href="<?= base_url('profile') ?>/<?= $log->user_uid ?>" target="_blank"><?= $log->display_name ?></a></td>
                    <td class="align-middle"><a href="<?= base_url($log->base_url) ?>/<?= $log->file ?>" target="_blank"><?= $log->file ?></a></td>
                    <td class="align-middle"><?= $log->remote_addr ?></td>
                    <td class="align-middle"><?= $log->http_x_forwarded_for ?></td>
                    <td class="align-middle"><?= date('d/m/Y H:i:s', strtotime($log->timestamp)) ?></td>
                    <td class="align-middle">
                        <? if ($log->is_deleted) : ?>
                            <span class="badge badge-danger">Eliminado</span>
                        <? else : ?>
                            <span class="badge badge-success">Fichero existente</span>
                        <? endif; ?>
                    </td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
</div>

<div class="text-right text-muted">
    Mostrando <?= count($logs) ?> de <?= $total ?> resultados
</div>

<?= $pagination ?>