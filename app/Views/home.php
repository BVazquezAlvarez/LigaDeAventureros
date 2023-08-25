<div class="card mt-3">
    <div class="card-header text-center">
        <h2 class="d-inline-block mb-0">Partidas de esta semana</h1>
    </div>
    <div class="card-body">
        <div class="row">
            <? foreach ($sessions_this_week as $session) : ?>
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card card-join-session h-100">
                        <div class="card-header text-center">
                            <h3 class="d-inline-block mb-0"><?= $session->adventure_name ?></h1>
                        </div>
                        <div class="card-body py-0">
                            <div class="row h-100">
                                <div class="col-sm-6 border-right text-center p-2">
                                    <p><strong><?= rank_full_text($session->rank) ?></strong></p>
                                    <p>
                                        <?= date('d/m/Y', strtotime($session->date)) ?><br/>
                                        <?= date('H:i', strtotime($session->time)) ?>
                                    </p>
                                    <p><?= $session->master ?></p>
                                    <p><button type="button" class="btn btn-primary js-adventure-info" data-uid="<?= $session->adventure_uid ?>">Más informacion</button></p>
                                </div>
                                <div class="col-sm-6 text-center p-2">
                                    <? foreach ($session->players['playing'] as $player) : ?>
                                        <? if ($player) : ?>
                                            <div class="d-none d-md-block">
                                                <span class="badge badge-<?= $player->badge_color ?> badge-player">
                                                    <div><a href="<?= base_url('character_sheets') ?>/<?= $player->uploaded_sheet ?>" target="_blank"><?= $player->name ?></a></div>
                                                    <div>(<a href="<?= base_url('profile') ?>/<?= $player->uid ?>"><?= $player->display_name ?></a>)</div>
                                                </span>
                                            </div>
                                            <div class="d-md-none">
                                                <a href="<?= base_url('character_sheets') ?>/<?= $player->uploaded_sheet ?>" target="_blank" class="btn btn-<?= $player->badge_color ?> badge badge-player">
                                                    <div><?= $player->name ?></div>
                                                    <div>(<?= $player->display_name ?>)</div>
                                                </a>
                                            </div>
                                        <? else : ?>
                                            <span class="badge badge-secondary badge-player">------</span>
                                        <? endif; ?>
                                    <? endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <? if ($userdata) : ?>
                            <div class="card-footer">
                                <? if (strtotime($session->date . ' ' . $session->time) <= time()) : ?>
                                    <div class="text-center text-secondary">Ya no te puedes anotar a esta partida</div>
                                <? elseif (!$characters) : ?>
                                    <div class="text-center text-secondary"><a href="<?= base_url('profile') ?>">¡Crea un personaje!</a></div>
                                <? elseif (!$userdata['confirmed']) : ?>
                                    <div class="text-center text-secondary">Necesitas verificación por parte de un master para poder anotarte.</div>
                                <? else : ?>
                                    <select id="select-session-<?= $session->uid ?>" data-session-uid="<?= $session->uid ?>" data-adventure-name="<?= $session->adventure_name ?>" data-joined="<?= $session->joined ?>" data-adventure-rank="<?= rank_name($session->rank) ?>" class="js-select-join-session form-control">
                                        <? if (!$session->joined) : ?>
                                            <option selected disabled value="__default">¡Anótate!</option>
                                        <? endif; ?>
                                        <? foreach ($characters as $char) : ?>
                                            <option value="<?= $char->uid ?>" data-rank="<?= rank_name(rank_get($char->level)) ?>" <?= $char->uid == $session->joined ? 'selected disabled' : '' ?>><?= $session->joined ? ($char->uid == $session->joined ? 'Anotado con ' : 'Cambiar a ') : '' ?><?= $char->name ?></option>
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
            <? endforeach; ?>
            <? if (!$sessions_this_week) : ?>
                <div class="col-12 text-center">No hay partidas programadas esta semana.</div>
            <? endif; ?>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header text-center">
        <h2 class="d-inline-block mb-0">Partidas de la próxima semana</h1>
    </div>
    <div class="card-body">
        <div class="row">
            <? foreach ($sessions_next_week as $session) : ?>
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card card-join-session h-100">
                        <div class="card-header text-center">
                            <h3 class="d-inline-block mb-0"><?= $session->adventure_name ?></h1>
                        </div>
                        <div class="card-body py-0">
                            <div class="row h-100">
                                <div class="col-sm-6 border-right text-center p-2">
                                    <p><strong><?= rank_full_text($session->rank) ?></strong></p>
                                    <p>
                                        <?= date('d/m/Y', strtotime($session->date)) ?><br/>
                                        <?= date('H:i', strtotime($session->time)) ?>
                                    </p>
                                    <p><?= $session->master ?></p>
                                    <p><button type="button" class="btn btn-primary js-adventure-info" data-uid="<?= $session->adventure_uid ?>">Más informacion</button></p>
                                </div>
                                <div class="col-sm-6 text-center p-2">
                                    <? foreach ($session->players['playing'] as $player) : ?>
                                        <? if ($player) : ?>
                                            <div class="d-none d-md-block">
                                                <span class="badge badge-<?= $player->badge_color ?> badge-player">
                                                    <div><a href="<?= base_url('character_sheets') ?>/<?= $player->uploaded_sheet ?>" target="_blank"><?= $player->name ?></a></div>
                                                    <div>(<a href="<?= base_url('profile') ?>/<?= $player->uid ?>"><?= $player->display_name ?></a>)</div>
                                                </span>
                                            </div>
                                            <div class="d-md-none">
                                                <a href="<?= base_url('character_sheets') ?>/<?= $player->uploaded_sheet ?>" target="_blank" class="btn btn-<?= $player->badge_color ?> badge badge-player">
                                                    <div><?= $player->name ?></div>
                                                    <div>(<?= $player->display_name ?>)</div>
                                                </a>
                                            </div>
                                        <? else : ?>
                                            <span class="badge badge-secondary badge-player">------</span>
                                        <? endif; ?>
                                    <? endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <? if ($userdata) : ?>
                            <div class="card-footer">
                                <? if (strtotime($session->date . ' ' . $session->time) <= time()) : ?>
                                    <div class="text-center text-secondary">Ya no te puedes anotar a esta partida</div>
                                <? elseif (!$characters) : ?>
                                    <div class="text-center text-secondary"><a href="<?= base_url('profile') ?>">¡Crea un personaje!</a></div>
                                <? elseif (!$userdata['confirmed']) : ?>
                                    <div class="text-center text-secondary">Necesitas verificación por parte de un master para poder anotarte.</div>
                                <? else : ?>
                                    <select id="select-session-<?= $session->uid ?>" data-session-uid="<?= $session->uid ?>" data-adventure-name="<?= $session->adventure_name ?>" data-joined="<?= $session->joined ?>" data-adventure-rank="<?= rank_name($session->rank) ?>" class="js-select-join-session form-control">
                                        <? if (!$session->joined) : ?>
                                            <option selected disabled value="__default">¡Anótate!</option>
                                        <? endif; ?>
                                        <? foreach ($characters as $char) : ?>
                                            <option value="<?= $char->uid ?>" data-rank="<?= rank_name(rank_get($char->level)) ?>" <?= $char->uid == $session->joined ? 'selected disabled' : '' ?>><?= $session->joined ? ($char->uid == $session->joined ? 'Anotado con ' : 'Cambiar a ') : '' ?><?= $char->name ?></option>
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
            <? endforeach; ?>
            <? if (!$sessions_next_week) : ?>
                <div class="col-12 text-center">Todavía no hay partidas programadas para la próxima semana.</div>
            <? endif; ?>
        </div>
    </div>
<div>

<?= view('partials/modals/session_inscription') ?>
<?= view('partials/modals/adventure_info') ?>