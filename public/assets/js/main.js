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

function loadAdventure(adventure) {
    if (adventure.thumbnail) {
        $('#loaded-adventure-image').attr('src', baseUrl + "img/adventures/" + adventure.thumbnail);
        $('#loaded-adventure-image').attr('alt', adventure.name);
        $('#loaded-adventure-image').show(); 
    } else {
        $('#loaded-adventure-image').hide();
    }
    $('#loaded-adventure-title').text(adventure.name);
    $('#loaded-aventure-rank').text(adventure.rank_text);
    $('#loaded-adventure-players #min').text(adventure.players_min_recommended);
    $('#session_min_players').val(adventure.players_min_recommended);
    $('#loaded-adventure-players #max').text(adventure.players_max_recommended);
    $('#session_max_players').val(adventure.players_max_recommended);
    $('#loaded-adventure-duration span').text(adventure.duration);
    if (adventure.themes) {
        $('#loaded-adventure-themes span').text(adventure.themes);
        $('#loaded-adventure-themes').show(); 
    } else {
        $('#loaded-adventure-themes').hide();
    }
    $('#loaded-adventure-description i').html(adventure.description.replace(/\r\n/g, '<br>'));
    if (adventure.rewards) {
        $('#loaded-adventure-rewards').html(adventure.rewards.replace(/\r\n/g, '<br>'));
        $('#loaded-adventure-rewards').show(); 
    } else {
        $('#loaded-adventure-rewards').hide();
    }
}

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

    $('#new-session-adventure').on('change', function() {
        let uid = $(this).val();
        if (uid == '__new') {
            $('.js-required').prop('required', true);
            $('#adventure-data').hide();
            $('#adventure-form').show();
        } else {
            $('.js-required').prop('required', false);
            $('#adventure-form').hide();
            $.ajax({
                method: "POST",
                url: baseUrl + "adventure/data-ajax",
                dataType:'json',
                data: {
                    uid: uid,
                },
                success: function(data) {
                    if (data.error) {
                        alert('Se ha producido un error al cargar la aventura seleccionada.');
                        $('#new-session-adventure').val('__new').trigger('change');
                    } else {
                        loadAdventure(data.adventure);
                        $('#adventure-data').show();
                    }
                }  
            });
        }
    });

    $('#adventure_players_min_recommended').on('keyup', function() {
        $('#session_min_players').val($(this).val());
    });

    $('#adventure_players_max_recommended').on('keyup', function() {
        $('#session_max_players').val($(this).val());
    });
});
