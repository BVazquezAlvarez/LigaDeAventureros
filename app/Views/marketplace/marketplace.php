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

<div class="d-flex justify-content-between">
    <div class="d-flex align-items-center">
        <div class="character-image-all-characters">
            <div class="image-box image-box-circle">
                <img src="<?= $active_character->image ? (base_url('img/characters').'/'.$active_character->image) : base_url('img/placeholder.png') ?>">
            </div>
        </div>
        <strong><?= $active_character->name ?></strong>
        <input type="hidden" id="active-character-uid" value="<?= $active_character->uid ?>">
        <? if (count($my_characters) > 1) : ?>
            <button type="button" class="btn btn-outline-primary btn-sm ml-2" data-toggle="modal" data-target="#change-character-modal"><i class="fa-solid fa-rotate"></i></button>
        <? endif; ?>
    </div>
    <div class="pt-box d-flex align-items-center">
        <i class="fa-solid fa-coins"></i>
        <strong id="treasure-points-total"><?= $active_character->treasure_points ?></strong>
    </div>
</div>

<? if (!$merchants) : ?>
    <div class="text-center mt-3">
        <h1>No hay mercaderes activos</h1>
    </div>
<? else : ?>
    <nav class="mb-3 mt-3">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <? foreach ($merchants as $idx => $merchant) : ?>
                <a class="nav-item nav-link <?= $idx == 0 ? 'active' : '' ?>" id="nav-<?= $merchant->id ?>-tab" data-toggle="tab" href="#nav-<?= $merchant->id ?>" role="tab"><?= $merchant->name ?></a>
            <? endforeach; ?>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <? foreach ($merchants as $idx => $merchant) : ?>
            <div class="tab-pane fade <?= $idx == 0 ? 'show active' : '' ?>" id="nav-<?= $merchant->id ?>" role="tabpanel">
                <? if (!$merchant->permanent) : ?>
                    <p class="merchant-ends text-center">Este mercader se irá el <?= date('d/m/Y', strtotime($merchant->timestamp_end)) ?> a las <?= date('H:i', strtotime($merchant->timestamp_end)) ?></p>
                <? endif; ?>
                <div class="row">
                    <? foreach ($merchant->items as $item) : ?>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-header bg-rarity-<?= str_replace(' ', '-', $item->rarity) ?>">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="d-inline h5 mb-0"><?= $item->name ?></h3>
                                    <button type="button" class="btn btn-<?= $item->cost > $active_character->treasure_points ? 'secondary' : 'light' ?> js-btn-buy text-nowrap ml-2" data-item="<?= $item->id ?>" data-merchant="<?= $merchant->id ?>" <?= $item->cost > $active_character->treasure_points ? 'disabled' : '' ?>><?= $item->cost ?><i class="fa-solid fa-coins ml-2"></i></button>
                                </div>
                                </div>
                                <div class="card-body">
                                    <p>
                                        <?= ucfirst($item->type) ?>,
                                        <strong class="text-primary"><?= $item->rarity ?></strong><? if ($item->attunement) : ?>, <? endif; ?>
                                        <?= $item->attunement ?>
                                    </p>
                                    <p class="js-item-description-toggle">
                                        <span><?= trim(substr($item->full_description, 0, 100)) ?>...</span>
                                        <span style="display:none"><?= $item->full_description ?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        <? endforeach; ?>
    </div>
<? endif; ?>

<?= view('partials/modals/marketplace_change_character', ['characters' => $my_characters, 'active_character' => $active_character]) ?>