/*!
  * LigaDeAventureros
  * Copyright (C) 2023-2024 Santiago González Lago

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

function pad(num, size) {
    num = num.toString();
    while (num.length < size) num = "0" + num;
    return num;
}

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

function preloadJoinSession() {
    $('.js-select-join-session').on('change', function() {
        let session_uid = $(this).data('session-uid');
        let adventure_name = $(this).data('adventure-name');
        let joined = $(this).data('joined');
        let adventure_rank = $(this).data('adventure-rank');

        let char_uid = $(this).val();
        let char_name = $(this).find('option:selected').data('char-name');
        let char_rank = $(this).find('option:selected').data('rank');

        if (char_uid == '__cancel') {
            var modal = '#cancel-inscription-modal';
        } else if (joined) {
            var modal = '#swap-inscription-modal';
        } else {
            var modal = '#join-inscription-modal';
        }

        $(`${modal} #adventure-name`).text(adventure_name);
        $(`${modal} .js-char-name`).text(char_name);
        $(`${modal} #adventure-rank`).text(adventure_rank);
        $(`${modal} #char-rank`).text(char_rank);
        if (adventure_rank == 'Todos' || adventure_rank == char_rank) {
            $(`${modal} .alert`).hide();
        } else {
            $(`${modal} .alert`).show();
        }

        $(`${modal} #session-uid`).val(session_uid);
        $(`${modal} #char-uid`).val(char_uid);

        let element = $(this).attr('id');
        $(modal).modal('show');
        $(modal).on('hidden.bs.modal', function () {
            var option = joined || '__default';
            $(`#${element}`).val(option);
        });

    });
}

$(function() {
    $('[data-toggle="tooltip"]').tooltip();

    $('.js-validate-btn').on('click', function() {
        let uid = $(this).data("uid");
        let name = $(this).data("name");

        $('#validate-sheet-modal #modal-character-name').text(name);
        $('#validate-sheet-modal #modal-uid').val(uid);

        $('#validate-sheet-modal').modal('show');
    });

    $('.js-reject-btn').on('click', function() {
        let uid = $(this).data("uid");
        let name = $(this).data("name");

        $('#reject-sheet-modal #modal-character-name').text(name);
        $('#reject-sheet-modal #modal-uid').val(uid);

        $('#reject-sheet-modal').modal('show');
    });

    $('.js-define-logsheet').on('click', function() {
        let uid = $(this).data("uid");
        let name = $(this).data("name");
        let logsheet = $(this).data("logsheet");

        $('#define-logsheet-modal #modal-character-name').text(name);
        $('#define-logsheet-modal #modal-uid').val(uid);
        $('#define-logsheet-modal #modal-logsheet').val(logsheet);

        $('#define-logsheet-modal').modal('show');
    });

    $('.js-update-character-btn').on('click', function() {
        let character = $(this).data("character");

        $("#modal-character-name").text(character.name);
        $("#update-character-modal #name").val(character.name);
        $("#update-character-modal #uid").val(character.uid);
        $("#update-character-modal #class").val(character.class);
        $("#update-character-modal #level").val(character.level);
        $("#update-character-modal #wiki").val(character.wiki);
        $("#update-character-modal #description").val(character.description);
        if (character.reject_level == 1) {
            $("#update-character-modal #reject_level").prop('checked', true);
        }

        if (character.image) {
            $("#update-character-modal #delete_image_block").show();
        } else {
            $("#update-character-modal #delete_image_block").hide();
        }

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

    preloadJoinSession();

    $('.js-adventure-info').on('click', function() {
        let uid = $(this).data('uid');
        $.ajax({
            method: "POST",
            url: baseUrl + "adventure/data-ajax",
            dataType:'json',
            data: {
                uid: uid,
            },
            success: function(data) {
                if (!data.error) {
                    loadAdventure(data.adventure);
                    $('#adventure-info-modal').modal('show');
                }
            }
        });
    });

    $('.js-setting-input').on('keyup', function() {
        let id = $(this).data('id');
        let btn = `#button-${id}`;
        $(btn).prop('disabled', false);
    });

    $('.js-master-add').on('click', function() {
        let uid = $(this).data("uid");
        let name = $(this).data("name");

        $("#master-add-modal #user-name").text(name);
        $("#master-add-modal #uid").val(uid);

        $('#master-add-modal').modal('show');
    });

    $('.js-master-rm').on('click', function() {
        let uid = $(this).data("uid");
        let name = $(this).data("name");

        $("#master-rm-modal #user-name").text(name);
        $("#master-rm-modal #uid").val(uid);

        $('#master-rm-modal').modal('show');
    });

    $('.js-admin-add').on('click', function() {
        let uid = $(this).data("uid");
        let name = $(this).data("name");

        $("#admin-add-modal #user-name").text(name);
        $("#admin-add-modal #uid").val(uid);

        $('#admin-add-modal').modal('show');
    });

    $('.js-admin-rm').on('click', function() {
        let uid = $(this).data("uid");
        let name = $(this).data("name");

        $("#admin-rm-modal #user-name").text(name);
        $("#admin-rm-modal #uid").val(uid);

        $('#admin-rm-modal').modal('show');
    });

    $('.js-ban').on('click', function() {
        let uid = $(this).data("uid");
        let name = $(this).data("name");

        $("#ban-modal #user-name").text(name);
        $("#ban-modal #uid").val(uid);

        $('#ban-modal').modal('show');
    });

    $('.js-unban').on('click', function() {
        let uid = $(this).data("uid");
        let name = $(this).data("name");

        $("#unban-modal #user-name").text(name);
        $("#unban-modal #uid").val(uid);

        $('#unban-modal').modal('show');
    });

    $('#checkbox-select-all').on('click', function() {
        $('.js-checkbox-select-all').prop('checked', this.checked);
    });

    $('.js-checkbox-select-all').on('click', function() {
        var totalCheckboxes = $('.js-checkbox-select-all').length;
        var checkedCheckboxes = $('.js-checkbox-select-all:checked').length;

        $('#checkbox-select-all').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
        $('#checkbox-select-all').prop('checked', checkedCheckboxes === totalCheckboxes);
    });

    $('.js-session-rm').on('click', function() {
        let uid = $(this).data("uid");
        $("#session-rm-modal #uid").val(uid);
        $('#session-rm-modal').modal('show');
    });

    $('.js-session-kick').on('click', function() {
        let uid = $(this).data("uid");
        let name = $(this).data("name");
        $("#session-kick-modal #player-uid").val(uid);
        $("#session-kick-modal #character-name").text(name);
        $('#session-kick-modal').modal('show');
    });


    $('.js-calendar-load-session').on('click', function() {
        let uid = $(this).data("uid");
        $('#session-data').hide();
        $.ajax({
            method: "GET",
            url: baseUrl + "session/view/" + uid,
            success: function(data) {
                $('#session-data').html(data);
                $('#session-data').show();
                preloadJoinSession();
            }
        });
    });

    function searchAllCharacters() {
        let search = $('#all-characters-search').val().toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        let searchWords = search.split(/\s+/).filter(word => word.trim() !== '');

        let ranks = $('.js-button-rank.active').map(function() {
            return $(this).data('rank');
        }).get();

        $('#no-results').hide();

        if (searchWords.length === 0 && ranks.length === 0) {
            $('.js-all-characters-search').show();
            $('#filtered-results-count').hide();
            return;
        }

        let total = 0;
        $('.js-all-characters-search').each(function() {
            let query = $(this).data('query').normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            let queryWords = query.split(/\s+/).filter(word => word.trim() !== '');
            let rank = $(this).data('rank');

            let rankValid = ranks.includes(rank) || ranks.length === 0;
            let matchFound = true;
            if (searchWords.length > 0) {
                matchFound = false;
                for (let i = 0; i < searchWords.length; i++) {
                    for (let j = 0; j < queryWords.length; j++) {
                        if (queryWords[j].includes(searchWords[i])) {
                            matchFound = true;
                            break;
                        }
                    }
                    if (matchFound) {
                        break;
                    }
                }
            }

            if (matchFound && rankValid) {
                $(this).show();
                total++;
            } else {
                $(this).hide();
            }
        });

        $('#filtered-results-count').show();
        $('#filtered-results-count span').html(total);
        if (total == 0) {
            $('#no-results').show();
        }
    }

    $('#all-characters-search').on('keyup', function() {
        searchAllCharacters();
    });

    $('.js-button-rank').on('click', function() {
        $(this).toggleClass('active');
        searchAllCharacters();
    });

    let intervalRunning = false;
    $('#delete-character-modal').on('show.bs.modal', function () {
        var submitBtn = $('#delete-character-modal button[type="submit"]');
        var originalText = submitBtn.html();

        var countDown = 3;

        function startInterval() {
            intervalRunning = true;
            submitBtn.prop('disabled', true).html(`${countDown}...`);
            var interval = setInterval(function () {
                countDown--;
                if (countDown > 0) {
                    submitBtn.html(`${countDown}...`);
                } else {
                    clearInterval(interval);
                    intervalRunning = false;
                    submitBtn.prop('disabled', false).html(originalText);
                }
            }, 1000);
        }

        if (!intervalRunning) {
            startInterval();
        }
    });

    $('.js-select-class').on('click', function(e) {
        e.preventDefault();
        let cclass = $(this).data('class');
        $('#class').val(cclass).trigger('input');
    });

    $('.js-btn-continue').on('click', function() {
        let section = $(this).data('section');
        let input = $(this).data('input');

        if (!$(input).val()) {
            $(input).addClass('input-error');
            $(input).focus();
            return;
        }

        $(this).hide();
        $(section).fadeIn(1000);

        $([document.documentElement, document.body]).animate({
            scrollTop: $(section).offset().top
        }, 2000);
    });

    $(document).on('input', '.input-error', function() {
        $(this).removeClass('input-error');
    });

    $(".s2-multi").select2({
        allowClear: true
    });

    $(".s2-simple").select2();

    $('#logsheet-visual-control').on('change', function() {
        let val = $(this).val();
        if (val) {
            $('.logsheet-row').hide();
            $(`.${val}`).show();
        } else {
            $('.logsheet-row').show();
        }
    });

    $('#merchant-permanent').on('change', function() {
        if ($(this).prop('checked')) {
            $('.js-merchant-permanent').hide();
            $('.js-merchant-permanent input').prop('required', false);
        } else {
            $('.js-merchant-permanent').show();
            $('.js-merchant-permanent input').prop('required', true);
        }
    });

    $('.js-delete-merchant').on('click', function() {
        let id = $(this).data("id");
        let name = $(this).data("name");

        $("#delete-merchant-modal #merchant-name").text(name);
        $("#delete-merchant-modal #id").val(id);

        $('#delete-merchant-modal').modal('show');
    });

    $('.js-toggle-automatic-merchant').on('change', function() {
        let id = $(this).data("id");
        let active = $(this).prop('checked') ? 1 : 0;
        console.log(id,active);
        $.ajax({
            method: "POST",
            url: baseUrl + "admin/toggle-automatic-merchant",
            dataType:'json',
            data: {
                id: id,
                active: active
            }
        });
    });

    $('.js-edit-automatic-merchant').on('click', function() {
        let merchant = $(this).data("merchant");
        $("#edit-automatic-merchant-modal #id").val(merchant.id);
        $("#edit-automatic-merchant-modal #name").val(merchant.name);
        $("#edit-automatic-merchant-modal #timestamp_start").val(merchant.timestamp_start);
        $("#edit-automatic-merchant-modal #frequency_days").val(merchant.frequency_days);
        $("#edit-automatic-merchant-modal #common").val(merchant.common);
        $("#edit-automatic-merchant-modal #uncommon").val(merchant.uncommon);
        $("#edit-automatic-merchant-modal #rare").val(merchant.rare);
        $("#edit-automatic-merchant-modal #very_rare").val(merchant.very_rare);
        $("#edit-automatic-merchant-modal #legendary").val(merchant.legendary);
        $('#edit-automatic-merchant-modal').modal('show');
    });

    $('.js-delete-automatic-merchant').on('click', function() {
        let id = $(this).data("id");
        let name = $(this).data("name");

        $("#delete-automatic-merchant-modal #merchant-name").text(name);
        $("#delete-automatic-merchant-modal #id").val(id);

        $('#delete-automatic-merchant-modal').modal('show');
    });

    $('.js-item-description-toggle').on('click', function() {
        $(this).find('span').toggle();
    });

    $('#marketplace-change-character').on('click', function() {
        let active = $('input[name="active_character"]:checked').val();
        $.ajax({
            method: "POST",
            url: baseUrl + "marketplace/change-active-character",
            dataType:'json',
            data: {
                active: active,
            },
            success: function(data) {
                window.location.reload();
            }
        });
    });

    $('.js-btn-buy').on('click', function() {
        let item_id = $(this).data('item');
        let merchant_id = $(this).data('merchant');
        let character_uid = $('#active-character-uid').val();

        let form = $('<form>').attr({
            method: 'POST',
            action: 'marketplace/buy'
        });
        form.append(
            $('<input>').attr({
                type: 'hidden',
                name: 'item_id',
                value: item_id
            }),
            $('<input>').attr({
                type: 'hidden',
                name: 'merchant_id',
                value: merchant_id
            }),
            $('<input>').attr({
                type: 'hidden',
                name: 'character_uid',
                value: character_uid
            })
        );
        $('body').append(form);
        form.submit();
    });

    function updateTimers() {
        $(".js-time-remaining").each(function() {
            var timestampEnd = new Date($(this).data("time")).getTime();
            var now = new Date().getTime();
            var timeRemaining = timestampEnd - now;

            var daysRemaining = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
            var hoursRemaining = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutesRemaining = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
            var secondsRemaining = Math.floor((timeRemaining % (1000 * 60)) / 1000);
            var timeRemainingText = "";
            if (daysRemaining > 1) {
                timeRemainingText += `${daysRemaining} días, `;
            } else if (daysRemaining > 0) {
                timeRemainingText += `${daysRemaining} día, `;
            }
            timeRemainingText += `${pad(hoursRemaining,2)}:${pad(minutesRemaining,2)}:${pad(secondsRemaining,2)}`;
            if (timeRemaining <= 0) {
                timeRemainingText = '00:00:00';
            }
            $(this).find('.js-timer').text(timeRemainingText);

            if (daysRemaining <= 0) {
                $(this).removeClass('alert-primary').addClass('alert-danger');
                if (hoursRemaining < 2) {
                    $(this).addClass('merchant-ending');
                }
            }
        });
    }

    if ($(".js-time-remaining").length > 0) {
        setInterval(updateTimers, 1000);
        updateTimers();
    }
});