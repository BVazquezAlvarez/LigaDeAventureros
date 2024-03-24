<h1><?= $user->display_name ?> ha cambiado su personaje para tu partida <?= $adventure->name ?></h1>

<p>
    ¡Hola <?= $master->display_name ?>!
</p>

<p>
    Datos de la partida:
</p>
<ul>
    <li><strong>Ubicación:</strong> <?= $session->location ?></li>
    <li><strong>Fecha:</strong> <?= weekday(date('N', strtotime($session->date))) ?> <?= date('d/m/Y', strtotime($session->date)) ?><br/></li>
    <li><strong>Hora:</strong> <?= date('H:i', strtotime($session->time)) ?></li>
    <li><strong>Duración:</strong> <?= $adventure->duration ?></strong> 
</ul>

<p>
    Información del nuevo personaje:
</p>
<ul>
    <li><strong>Nombre:</strong> <?= $character->name ?></li>
    <li><strong>Clase:</strong> <?= $character->class ?></li>
    <li><strong>Nivel:</strong> <?= $character->level ?></li>
</ul>

<? if ($waitlist) : ?>
    <p class="rojo">
        El jugador se encuentra actualmente en lista de espera.
    </p>
<? endif; ?>

<? if ($player_count < $session->players_min) : ?>
    <p class="rojo">
        Actualmente no se cumple el mínimo de jugadores para la partida.
    </p>
<? endif; ?>