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

<div class="modal fade" id="adventure-info-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="loaded-adventure-title" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img class="img-fluid" id="loaded-adventure-image">
                <p><strong id="loaded-aventure-rank"></strong></p>
                <p>
                    <div id="loaded-adventure-duration"><strong>Duración: </strong><span></span></div>
                    <div id="loaded-adventure-themes"><strong>Temas: </strong><span></span></div>
                </p>
                <p id="loaded-adventure-description"><i></i></p>
                <p id="loaded-adventure-rewards"></p>
            </div>
        </div>
    </div>
</div>