<div class="card mt-3">
    <div class="card-header text-center">
        <h2 class="d-inline-block mb-0">Partidas de esta semana</h1>
    </div>
    <div class="card-body">
        <div class="row">
            <? foreach ($sessions_this_week as $session) : ?>
                <?= view('partials/join_session', ['session' => $session]) ?>
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
                <?= view('partials/join_session', ['session' => $session]) ?>
            <? endforeach; ?>
            <? if (!$sessions_next_week) : ?>
                <div class="col-12 text-center">Todavía no hay partidas programadas para la próxima semana.</div>
            <? endif; ?>
        </div>
    </div>
<div>

<?= view('partials/modals/session_inscription') ?>
<?= view('partials/modals/adventure_info') ?>