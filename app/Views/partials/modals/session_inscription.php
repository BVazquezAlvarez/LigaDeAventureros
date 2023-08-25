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

<div class="modal fade" id="join-inscription-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="post" action="<?= base_url('session/join') ?>">
            <div class="modal-body">
                <div class="text-center">¿Estás seguro de que quieres inscribirte a <strong id="adventure-name"></strong> con <strong class="js-char-name"></strong>?</div>
                <div class="alert alert-warning text-center mt-3 mb-0" id="modal-alert" role="alert">
                    ¡Alerta! La aventura es de rango <strong id="adventure-rank"></strong> y <strong class="js-char-name"></strong> es de rango <strong id="char-rank"></strong>.
                </div>
                <input type="hidden" id="session-uid" name="session-uid">
                <input type="hidden" id="char-uid" name="character-uid">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Sí</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="swap-inscription-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="post" action="<?= base_url('session/swap') ?>">
            <div class="modal-body">
                <div class="text-center">¿Estás seguro de que quieres cambiar tu inscripción en <strong id="adventure-name"></strong> a <strong class="js-char-name"></strong>?</div>
                <div class="alert alert-warning text-center mt-3 mb-0" id="modal-alert" role="alert">
                    ¡Alerta! La aventura es de rango <strong id="adventure-rank"></strong> y <strong class="js-char-name"></strong> es de rango <strong id="char-rank"></strong>.
                </div>
                <input type="hidden" id="session-uid" name="session-uid">
                <input type="hidden" id="char-uid" name="character-uid">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Sí</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="cancel-inscription-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="post" action="<?= base_url('session/cancel') ?>">
            <div class="modal-body">
                <div class="text-center">¿Estás seguro de que quieres cancelar tu inscripción a <strong id="adventure-name"></strong>?</div>
                <input type="hidden" id="session-uid" name="session-uid">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Sí</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </form>
    </div>
</div>