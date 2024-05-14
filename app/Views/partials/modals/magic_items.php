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

<div class="modal fade" id="magic-items-modal" tabindex="-1">
    <div class="modal-dialog <?= ($userdata && $userdata['confirmed']) ? 'modal-xl' : '' ?> modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Objetos mágicos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Objeto</th>
                                <th scope="col">Manual</th>
                                <? if ($userdata && $userdata['confirmed']) : ?>
                                    <th scope="col">Descripción </th>
                                <? endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($items as $item) : ?>
                                <tr>
                                    <th scope="row"><?= $item->name ?></th>
                                    <td><?= $item->source ?><? if($item->page) : ?>:<?= $item->page ?><? endif; ?></td>
                                    <? if ($userdata && $userdata['confirmed']) : ?>
                                        <td>
                                            <p>
                                                <?= ucfirst($item->type) ?>,
                                                <strong class="text-primary"><?= $item->rarity ?></strong><? if ($item->attunement) : ?>, <? endif; ?>
                                                <?= $item->attunement ?>
                                            </p>
                                            <p><?= $item->full_description ?></p>
                                        </td>
                                    <? endif; ?>
                                </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>