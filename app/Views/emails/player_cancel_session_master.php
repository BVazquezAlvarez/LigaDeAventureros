<h1><?= $user->display_name ?> se ha anotado a tu partida <?= $adventure->name ?></h1>

<p>
    ¡Hola <?= $master->display_name ?>!
</p>

<p>
    El jugador ha cancelado la inscripción a la siguiente partida
</p>
<ul>
    <li><strong>Ubicación:</strong> <?= $session->location ?></li>
    <li><strong>Fecha:</strong> <?= weekday(date('N', strtotime($session->date))) ?> <?= date('d/m/Y', strtotime($session->date)) ?><br/></li>
    <li><strong>Hora:</strong> <?= date('H:i', strtotime($session->time)) ?></li>
    <li><strong>Duración:</strong> <?= $adventure->duration ?></strong> 
</ul>

<? if ($player_count < $session->players_min) : ?>
    <p class="rojo">
        Actualmente no se cumple el mínimo de jugadores para la partida.
    </p>
<? endif; ?>