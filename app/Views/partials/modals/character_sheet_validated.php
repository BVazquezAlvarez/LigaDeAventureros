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

<div class="modal fade" id="character-sheet-validated-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-character-sheet" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Última hoja de personaje validada</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe src="<?= base_url('character_sheets') ?>/<?= $character->validated_sheet ?>"></iframe>
      </div>
    </div>
  </div>
</div>