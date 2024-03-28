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

<div class="d-flex justify-content-between align-items-center">
  <a href="<?= base_url("calendar/$prev_month") ?>" class="btn btn-primary"><i class="fa-solid fa-backward"></i> <?= $prev_month_name ?></a>
  <h1 class="d-none d-md-block"><?= $header_title ?></h1>
  <a href="<?= base_url("calendar/$next_month") ?>" class="btn btn-primary"><?= $next_month_name ?> <i class="fa-solid fa-forward"></i></a>
</div>

<h1 class="d-block d-md-none text-center"><?= $header_title_mobile ?></h1>

<div class="table-responsive d-none d-md-block">
    <table class="table table-bordered table-calendar">
        <thead class="thead-light text-center">
            <tr>
                <th class="col-1">Lunes</th>
                <th class="col-1">Martes</th>
                <th class="col-1">Miércoles</th>
                <th class="col-1">Jueves</th>
                <th class="col-1">Viernes</th>
                <th class="col-1">Sábado</th>
                <th class="col-1">Domingo</th>
            </tr>
        </thead>
        <tbody>
            <? $first_week = true ?>
            <? foreach ($weeks as $week) : ?>
                <tr>
                    <? if ($first_week && count($week) < 7) : ?>
                        <? for ($i = count($week); $i < 7; $i++) : ?>
                            <td class="table-secondary"></td>
                        <? endfor; ?>
                    <? endif; ?>
                    <? foreach ($week as $day => $data) : ?>
                        <td class="day-row" style="<?= $data['background'] ? "background-image:url('".base_url('img/adventures')."/".$data['background']."')" : '' ?>">
                            <div class="text-right text-secondary table-top-right">
                                <small class="day-row-number"><?= $day ?></small>
                            </div>
                            <div class="table-sessions">
                                <? foreach ($data['sessions'] as $session) : ?>
                                    <a href="#" data-uid="<?= $session->uid ?>" class="js-calendar-load-session badge badge-primary w-100 text-left" data-toggle="tooltip" data-placement="bottom" title="<?= $session->adventure_name ?>">
                                        <?= date("H:i", strtotime($session->time)) ?> <?= rank_name($session->rank) ?><br/>
                                        <?= substr($session->adventure_name, 0, 10) ?>...
                                    </a>
                                <? endforeach; ?>
                            </div>
                        </td>
                    <? endforeach; ?>
                    <? if (!$first_week && count($week) < 7) : ?>
                        <? for ($i = count($week); $i < 7; $i++) : ?>
                            <td class="table-secondary"></td>
                        <? endfor; ?>
                    <? endif; ?>
                </tr>
                <? $first_week = false ?>
            <? endforeach; ?>
        </tbody>
    </table>
</div>

<div class="d-block d-md-none mb-3">
    <? if ($total_sessions) : ?>
        <? foreach ($sessions_by_date as $date => $sessions) : ?>
            <? if ($sessions) : ?>
                <h2 class="h4 text-secondary text-center mt-1 mb-0"><?= weekday(date('N', strtotime($date))) ?> <?= date('j', strtotime($date)) ?></h2>
                <? foreach ($sessions as $session) : ?>
                    <a href="#" data-uid="<?= $session->uid ?>" class="js-calendar-load-session badge badge-primary w-100">
                        <?= date("H:i", strtotime($session->time)) ?> <?= rank_name($session->rank) ?><br/>
                        <?= $session->adventure_name ?>
                    </a>
                <? endforeach; ?>
            <? endif; ?>
        <? endforeach; ?>
    <? else : ?>
        <h2 class="h4 text-secondary text-center">No hay sesiones</h2>
    <? endif; ?>
</div>

<div id="session-data">
</div>

<? if (session('session_updated')) : ?>
    <script>
        $(function() {
            $('.js-calendar-load-session[data-uid="<?= session('session_updated') ?>"]').trigger('click');
        });
    </script>
<? endif; ?>