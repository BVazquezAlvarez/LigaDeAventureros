<h1>La partida <?= $adventure->name ?> ha sido cancelada</h1>

<p>
    ¡Hola <?= $user->display_name ?>!
</p>

<p>
    Lamentamos informarte de que una partida a la que estabas anotado ha sido <strong class="rojo">cancelada</span>:
</p>
<ul>
    <li><strong>Ubicación:</strong> <?= $session->location ?></li>
    <li><strong>Fecha:</strong> <?= weekday(date('N', strtotime($session->date))) ?> <?= date('d/m/Y', strtotime($session->date)) ?><br/></li>
    <li><strong>Hora:</strong> <?= date('H:i', strtotime($session->time)) ?></li>
    <li><strong>Duración:</strong> <?= $adventure->duration ?></strong> 
</ul>

<p>
    Estabas anotado con el siguiente personaje:
</p>
<ul>
    <li><strong>Nombre:</strong> <?= $character->name ?></li>
    <li><strong>Clase:</strong> <?= $character->class ?></li>
    <li><strong>Nivel:</strong> <?= $character->level ?></li>
</ul>

<? if ($master_email) : ?>
    <p>
        Si tienes alguna duda, puedes responder a este email para contactar con el Master.
    </p>
<? endif; ?>

<p>
    Lamentamos que no puedas participar en esta ocasión y esperamos verte en futuras partidas.
</p>