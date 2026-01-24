<?php
// LigaDeAventureros
// Copyright (C) 2024-2026 Santiago González Lago

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

<div class="col-md-6 col-lg-4 mb-3 js-wsetting-home-show <?= $visible ? '' : 'd-none' ?>" data-wsetting="<?= $session->w_setting_id ?>">
    <div class="card card-join-session h-100" style="box-shadow: 2px 2px 2px <?= $session->w_setting_color ?: 'rgba(0,0,0,.125)' ?>;">
        <div class="card-header text-center">
        <? if ($userdata && $session->priority_avaliable != 0) : ?>
        <span class="position-absolute translate-middle badge rounded-pill bg-success" style="
            top: -6px;
            left: 38%;
            color: white;
            "><i class="fas fa-arrow-up"></i> Disponible</span>
        <? endif; ?>
            <h3 class="d-inline-block mb-0"><?= $session->adventure_name ?></h3>
            <h6 class="d-inline-block mb-0"><span style="color:<?= $session->w_setting_color ?: 'black' ?>"><?= ($session->w_setting_id != 0) ? $session->w_setting_name : 'Todas las modalidades' ?></span> · <?= $session->type_name ?></h6>
        </div>
        <div class="card-body py-0 card-session" style="<?= $session->thumbnail ? "background-image:url('".base_url('img/adventures')."/".$session->thumbnail."')" : '' ?>">
            <div class="row h-100">
                <div class="col-sm-6 text-center p-2 session-flex">
                    <div class="session-info">
                        <p><strong><?= rank_full_text($session->rank) ?></strong></p>
                        <p>
                            <?= weekday(date('N', strtotime($session->date))) ?> <?= date('j', strtotime($session->date)) ?> <span class="text-muted"><?= date('H:i', strtotime($session->time)) ?><br/></span>
                            <? if (is_mobile()) : ?>
                                <a href="<?= base_url('session/add-to-calendar')?>/<?= $session->uid ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-calendar"></i> Añadir</a>
                            <? else : ?>
                                <span class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="calendarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa-solid fa-calendar"></i> Añadir
                                    </button>
                                    <span class="dropdown-menu" aria-labelledby="calendarDropdown">
                                        <a class="dropdown-item" href="<?= base_url('session/add-to-calendar')?>/<?= $session->uid ?>/google">Google Calendar</a>
                                        <a class="dropdown-item" href="<?= base_url('session/add-to-calendar')?>/<?= $session->uid ?>/outlook">Outlook</a>
                                        <a class="dropdown-item" href="<?= base_url('session/add-to-calendar')?>/<?= $session->uid ?>/ical">iCalendar</a>
                                    </span>
                                </span>
                            <? endif; ?>
                            <br/>
                            <?= $session->location ?><br/>
                            <span class="<?= count(array_filter($session->players['playing'], function($element) { return $element !== NULL; })) >= $session->players_min ? 'text-secondary' : 'text-danger' ?>"><?= $session->players_min ?>-<?= $session->players_max ?> jugadores</span>
                        </p>
                        <p class="mb-0">
                            <a href="<?= base_url('profile') ?>/<?= $session->master_uid ?>"><?= $session->master ?></a>
                        </p>
                    </div>
                    <button type="button" class="btn btn-primary js-adventure-info" data-uid="<?= $session->adventure_uid ?>">Más informacion</button>
                </div>
                <div class="col-sm-6 text-center p-2">
                    <div class="registered-players-block">
                        <? foreach ($session->players['playing'] as $player) : ?>
                            <? if ($player) : ?>
                                <?= view('partials/user_badge', ['player' => $player]) ?>
                            <? else : ?>
                                <span class="badge badge-secondary badge-player">------</span>
                            <? endif; ?>
                        <? endforeach; ?>
                        <? if ($session->players['waitlist']) : ?>
                            <h6 class="mt-2 text-secondary">Lista de espera</h6>
                            <? foreach ($session->players['waitlist'] as $player) : ?>
                                <?= view('partials/user_badge', ['player' => $player]) ?>
                            <? endforeach; ?>
                        <? endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <? if ($userdata) : ?>
            <div class="card-footer">
                <? if (strtotime($session->date . ' ' . $session->time) <= time()) : ?>
                    <div class="text-center text-secondary">Ya no te puedes anotar a esta partida</div>
                <? elseif ($session->w_setting_id == 0 && !$session->player_characters) : ?>
                    <div class="text-center text-secondary"><a href="<?= base_url('new-player-help') ?>">¡Crea un personaje!</a></div>
                <? elseif (!$session->player_characters) : ?>
                    <div class="text-center text-secondary"><a href="<?= base_url('new-player-help') ?>">¡Crea un personaje en <?= $session->w_setting_name ?> (<?=$session->timeline?>)!</a></div>
                <? elseif (!$userdata['confirmed']) : ?>
                    <div class="text-center text-secondary">Necesitas verificación por parte de un master para poder anotarte.</div>
                <? else : ?>
                    <select id="select-session-<?= $session->uid ?>" data-session-uid="<?= $session->uid ?>" data-adventure-name="<?= $session->adventure_name ?>" data-joined="<?= $session->joined ?>" data-adventure-rank="<?= rank_name($session->rank) ?>" data-priority-avaliable="<?= $session->priority_avaliable ?>" class="js-select-join-session form-control">
                        <? if (!$session->joined) : ?>
                            <option selected disabled value="__default">¡Anótate!</option>
                        <? endif; ?>
                        <? foreach ($session->player_characters as $char) : ?>
                            <option value="<?= $char->uid ?>" data-rank="<?= rank_name(rank_get($char->level)) ?>" data-char-name="<?= $char->name ?>" <?= $char->uid == $session->joined ? 'selected disabled' : '' ?>><?= $session->joined ? ($char->uid == $session->joined ? 'Anotado con ' : 'Cambiar a ') : '' ?><?= $char->name ?></option>
                        <? endforeach; ?>
                        <? if ($session->joined) : ?>
                            <option value="__cancel">CANCELAR INSCRIPCIÓN</option>
                        <? endif; ?>
                    </select>
                <? endif; ?>
            </div>
        <? endif; ?>
    </div>
</div>