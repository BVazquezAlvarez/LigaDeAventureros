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

<div class="mb-3">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new-merchant-modal"><i class="fa-solid fa-plus"></i> Nuevo</button>
    <a href="<?= base_url('admin/merchants-auto') ?>" class="btn btn-primary"><i class="fa-solid fa-gears"></i> Mercaderes automatizados</a>
</div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Mercader</th>
                <th scope="col">Fecha de inicio</th>
                <th scope="col">Fecha de fin</th>
                <th scope="col">Tipo</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($merchants as $merchant) : ?>
                <tr>
                    <th scope="row" class="align-middle"><?= $merchant->name ?></th>
                    <? if ($merchant->permanent) : ?>
                        <td colspan="2" class="text-center align-middle">Permanentemente activo</td>
                    <? else : ?>
                        <td class="align-middle"><?= date('d/m/Y H:i', strtotime($merchant->timestamp_start)) ?></td>
                        <td class="align-middle"><?= date('d/m/Y H:i', strtotime($merchant->timestamp_end)) ?></td>
                    <? endif; ?>
                    <td class="align-middle">
                        <?= $merchant->automatic_merchant_id ? 'Automático' : 'Manual' ?>
                    </td>
                    <td class="align-middle">
                        <a href="<?= base_url('admin/edit-merchant') ?>/<?= $merchant->id ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i> Editar</a>
                        <button type="button" class="btn btn-danger js-delete-merchant" data-id="<?= $merchant->id ?>" data-name="<?= $merchant->name ?>"><i class="fa-solid fa-trash"></i> Eliminar</button>
                    </td>
                </tr>
            <? endforeach;?>
        </tbody>
    </table>
</div>

<div class="text-right text-muted">
    Mostrando <?= count($merchants) ?> de <?= $total ?> resultados
</div>

<?= $pagination ?>

<?= view('partials/modals/new_merchant') ?>
<?= view('partials/modals/delete_merchant') ?>