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

<? if ($sheets) : ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Personaje</th>
                    <th scope="col">Clase y nivel</th>
                    <th scope="col">Jugador</th>
                    <th scope="col">Nueva hoja</th>
                    <th scope="col">Última hoja validada</th>
                    <th scope="col" colspan="2"></th>
                </tr>
            </thead>
            <tbody>
                <? foreach ($sheets as $sheet) : ?>
                    <tr>
                        <th class="align-middle" scope="row"><?= $sheet->name ?></th>
                        <td class="align-middle"><?= $sheet->class ?> <strong><?= $sheet->level ?></strong> (<?= rank_name(rank_get($sheet->level)) ?>)</td>
                        <td class="align-middle"><a href="<?= base_url('profile') ?>/<?= $sheet->user_uid ?>" target="_blank"><?= $sheet->display_name ?></a></td>
                        <td class="align-middle"><a href="<?= base_url('character_sheets') ?>/<?= $sheet->uploaded_sheet ?>" target="_blank">Ver</a></td>
                        <td class="align-middle">
                            <? if ($sheet->validated_sheet) : ?>
                                <a href="<?= base_url('character_sheets') ?>/<?= $sheet->validated_sheet ?>" target="_blank">Ver</a>
                            <? else : ?>
                                <span class="text-danger">No hay una hoja anterior</span>
                            <? endif; ?>
                        </td>
                        <td class="align-middle">
                            <button class="btn btn-primary js-validate-btn" data-uid="<?= $sheet->uid ?>" data-name="<?= $sheet->name ?>">Validar</button>
                            <button class="btn btn-danger js-reject-btn" data-uid="<?= $sheet->uid ?>" data-name="<?= $sheet->name ?>">Rechazar</button>
                        </td>
                        <td class="align-middle">
                            <? if (!$sheet->confirmed) : ?>
                                <span class="text-success">¡Jugador nuevo!</span>
                            <? endif; ?>
                        </td>
                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>
    </div>
<? else : ?>
    <h3>No hay fichas pendientes de validar.</h3>
<? endif; ?>

<?= view('partials/modals/validate_sheets') ?>