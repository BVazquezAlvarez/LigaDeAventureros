<div class="col-md-6 col-lg-4 mb-3">
    <div class="card card-join-session h-100">
        <div class="card-header text-center">
            <h3 class="d-inline-block mb-0"><?= $session->adventure_name ?></h1>
        </div>
        <div class="card-body py-0 card-session" style="<?= $session->thumbnail ? "background-image:url('".base_url('img/adventures')."/".$session->thumbnail."')" : '' ?>">
            <div class="row h-100">
                <div class="col-sm-6 text-center p-2 session-flex">
                    <div class="session-info">
                        <p><strong><?= rank_full_text($session->rank) ?></strong></p>
                        <p>
                            <?= weekday(date('N', strtotime($session->date))) ?> <?= date('j', strtotime($session->date)) ?><br/>
                            <?= date('H:i', strtotime($session->time)) ?><br/>
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
                <? elseif (!$characters) : ?>
                    <div class="text-center text-secondary"><a href="<?= base_url('new-player-help') ?>">¡Crea un personaje!</a></div>
                <? elseif (!$userdata['confirmed']) : ?>
                    <div class="text-center text-secondary">Necesitas verificación por parte de un master para poder anotarte.</div>
                <? else : ?>
                    <select id="select-session-<?= $session->uid ?>" data-session-uid="<?= $session->uid ?>" data-adventure-name="<?= $session->adventure_name ?>" data-joined="<?= $session->joined ?>" data-adventure-rank="<?= rank_name($session->rank) ?>" class="js-select-join-session form-control">
                        <? if (!$session->joined) : ?>
                            <option selected disabled value="__default">¡Anótate!</option>
                        <? endif; ?>
                        <? foreach ($characters as $char) : ?>
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