<h1>Hay espacio para ti en la partida <?= $adventure->name ?></h1>

<p>
    ¡Hola <?= $user->display_name ?>!
</p>

<p>
    Alguien ha abandonado la partida por lo que se ha abierto un hueco para ti. Si no puedes ir, recuerda cancelar tu inscripción.
</p>

<p>
    Te recordamos la información de la partida:
</p>
<ul>
    <li><strong>Ubicación:</strong> <?= $session->location ?></li>
    <li><strong>Fecha:</strong> <?= weekday(date('N', strtotime($session->date))) ?> <?= date('d/m/Y', strtotime($session->date)) ?><br/></li>
    <li><strong>Hora:</strong> <?= date('H:i', strtotime($session->time)) ?></li>
    <li><strong>Duración:</strong> <?= $adventure->duration ?></strong> 
</ul>

<p>
    Te has anotado con el siguiente personaje:
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