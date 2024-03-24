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

<? if ($sessions_today) : ?>
    <div class="card mt-3 mb-3">
        <div class="card-header text-center">
            <h2 class="d-inline-block mb-0">¡Hoy!</h1>
        </div>
        <div class="card-body">
            <div class="row">
                <? foreach ($sessions_today as $session) : ?>
                    <?= view('partials/join_session', ['session' => $session]) ?>
                <? endforeach; ?>
            </div>
        </div>
    </div>
<? endif; ?>

<div class="text-center">
    <a href="<?= base_url('calendar') ?>" class="btn btn-primary btn-lg">Ver calendario</a>
</div>

<div class="card mt-3">
    <div class="card-header text-center">
        <h2 class="d-inline-block mb-0">Próximas partidas</h1>
    </div>
    <div class="card-body">
        <div class="row">
            <? foreach ($sessions_upcoming as $session) : ?>
                <?= view('partials/join_session', ['session' => $session]) ?>
            <? endforeach; ?>
            <? if (!$sessions_upcoming) : ?>
                <div class="col-12 text-center">Todavía no hay partidas programadas para los próximos días...</div>
            <? endif; ?>
        </div>
    </div>
<div>

<?= view('partials/modals/session_inscription') ?>
<?= view('partials/modals/adventure_info') ?>