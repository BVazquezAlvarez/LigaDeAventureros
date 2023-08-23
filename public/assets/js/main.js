/*!
  * LigaDeAventureros
  * Copyright (C) 2023 Santiago González Lago

  * This program is free software: you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation, either version 3 of the License, or
  * (at your option) any later version.

  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.

  * You should have received a copy of the GNU General Public License
  * along with this program.  If not, see <https://www.gnu.org/licenses/>.
  */

$(function() {
    $('.js-validate-btn').on('click', function() {
        let uid = $(this).data("uid");
        let name = $(this).data("name");
        
        $("#modal-character-name").text(name);
        $("#modal-uid").val(uid);

        $('#validate-sheet-modal').modal('show');
    });

    $('.js-update-character-btn').on('click', function() {
        let uid = $(this).data("uid");
        let name = $(this).data("name");
        let cclass = $(this).data("class");
        let level = $(this).data("level");
        
        $("#modal-character-name").text(name);
        $("#update-character-modal #uid").val(uid);
        $("#update-character-modal #class").val(cclass);
        $("#update-character-modal #level").val(level);

        $('#update-character-modal').modal('show');
    });
});
