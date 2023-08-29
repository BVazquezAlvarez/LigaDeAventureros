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

<div class="row">
    <div class="col-md-6 mb-3">
        <a href="<?= base_url('master/sheets') ?>" class="btn btn-primary btn-lg btn-block">
            Validar hojas de personaje
            <span class="badge badge-light"><?= $sheets_pending_count ?></span>
        </a>
        <a href="<?= base_url('master/adventures') ?>" class="btn btn-primary btn-lg btn-block">
            Aventuras y sesiones
        </a>
        <a href="<?= base_url('master/new-session') ?>" class="btn btn-primary btn-lg btn-block">
            Nueva sesión
        </a>
        <a href="<?= base_url('master/publish') ?>" class="btn btn-primary btn-lg btn-block">
            Publicar sesiones
        </a>
    </div>
    <div class="col-md-6">
        <h2 class="text-center">Mis próximas sesiones</h2>
        <? if ($upcoming_sessions) : ?>
            <div class="row">
                <? foreach ($upcoming_sessions as $session) : ?>
                    <div class="col-sm-6 mb-2">
                        <div class="card h-100">
                            <div class="card-header text-center">
                                <h6 class="d-inline-block mb-0"><?= $session->adventure_name ?></h6>
                            </div>
                            <div class="card-body text-center">
                                <p><strong><?= rank_full_text($session->rank) ?></strong></p>
                                <p>
                                    <?= date('d/m/Y', strtotime($session->date)) ?><br/>
                                    <?= date('H:i', strtotime($session->time)) ?>
                                </p>
                                <p><button type="button" class="btn btn-primary js-adventure-info" data-uid="<?= $session->adventure_uid ?>">Más informacion</button></p>
                            </div>
                            <? if ($session->players['playing']) : ?>
                                <div class="card-footer">
                                    <h6 class="text-center">Jugadores</h6>
                                    <? foreach ($session->players['playing'] as $player) : ?>
                                        <div class="btn-group w-100">
                                            <a href="<?= base_url('character_sheets') ?>/<?= $player->uploaded_sheet ?>" target="_blank" class="btn btn-<?= $player->badge_color ?> text-small">
                                                <div><?= $player->name ?></div>
                                                <div>(<?= $player->display_name ?>)</div>
                                            </a>
                                            <a href="<?= base_url('master/kick') ?>/<?= $session->uid ?>/<?= $player->uid ?>" class="btn btn-danger" type="button"><strong>X</strong></a>
                                        </div>
                                    <? endforeach; ?>
                                    <? if ($session->players['waitlist']) : ?>
                                        <h6 class="mt-2 text-secondary">Lista de espera</h6>
                                        <? foreach ($session->players['waitlist'] as $player) : ?>
                                            <div class="btn-group w-100">
                                                <a href="<?= base_url('character_sheets') ?>/<?= $player->uploaded_sheet ?>" target="_blank" class="btn btn-<?= $player->badge_color ?> text-small">
                                                    <div><?= $player->name ?></div>
                                                    <div>(<?= $player->display_name ?>)</div>
                                                </a>
                                                <a href="<?= base_url('master/kick') ?>/<?= $session->uid ?>/<?= $player->uid ?>" class="btn btn-danger" type="button"><strong>X</strong></a>
                                            </div>
                                        <? endforeach; ?>                                           
                                    <? endif; ?>
                                </div>
                            <? endif; ?>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
        <? else : ?>
            <div class="text-center">No tienes ninguna sesión futura publicada</div>
        <? endif; ?>
    </div>
</div>

<?= view('partials/modals/adventure_info') ?>