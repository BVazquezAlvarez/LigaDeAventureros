<?php
// LigaDeAventureros
// Copyright (C) 2023-2024 Santiago González Lago

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

<? if ($userdata && !$userdata['confirmed']) : ?>
    <?= view('partials/new_player_banner' , ['character_count' => count($characters)]) ?>
<? endif; ?>

<div class="row">
    <div class="col-md-6 offset-md-3 mb-3 buttons-ranks">
        <? foreach ($world_settings as $setting) : ?>
            <button class="js-button-wsetting-home <?= $setting->visible_default ? 'active' : '' ?>" data-wsetting="<?= $setting->id ?>"><?= $setting->name ?></button>
        <? endforeach; ?>
    </div>
</div>

<div class="card mt-3 mb-3 js-sessions-today <?= $visible_today ? '' : 'd-none' ?>">
    <div class="card-header text-center">
        <h2 class="d-inline-block mb-0">¡Hoy!</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <? foreach ($sessions_today as $session) : ?>
                <?= view('partials/join_session', ['session' => $session, 'visible' => in_array($session->w_setting_id, $visible_world_settings)]) ?>
            <? endforeach; ?>
        </div>
    </div>
</div>

<div class="text-center">
    <a href="<?= base_url('calendar') ?>" class="btn btn-primary btn-lg"><i class="fa-solid fa-calendar"></i> Calendario</a>
</div>

<div class="card mt-3 js-sessions-upcoming">
    <div class="card-header text-center">
        <h2 class="d-inline-block mb-0">Próximas partidas</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <? foreach ($sessions_upcoming as $session) : ?>
                <?= view('partials/join_session', ['session' => $session, 'visible' => in_array($session->w_setting_id, $visible_world_settings)]) ?>
            <? endforeach; ?>
            <div class="col-12 text-center js-no-upcoming <?= $visible_upcoming ? 'd-none' : '' ?>">Todavía no hay partidas programadas para los próximos días...</div>
        </div>
    </div>
</div>

<?= view('partials/modals/session_inscription') ?>
<?= view('partials/modals/adventure_info') ?>