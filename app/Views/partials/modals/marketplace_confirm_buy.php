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

<div class="modal fade" id="confirm-buy-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="post" action="<?= base_url('marketplace/buy') ?>">
            <div class="modal-body">
                <h5>¿Quieres comprar <strong id="item-name"></strong> por <span id="item-cost"></span> Puntos de Tesoro?</h5>
                <input type="hidden" id="item_id" name="item_id">
                <input type="hidden" id="merchant_id" name="merchant_id">
                <input type="hidden" id="character_uid" name="character_uid">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Sí</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </form>
    </div>
</div>