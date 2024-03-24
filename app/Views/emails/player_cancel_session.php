<h1>Has cancelado tu inscripción a la partida <?= $adventure->name ?></h1>

<p>
    ¡Hola <?= $user->display_name ?>!
</p>

<p>
    Te informamos de que se ha cancelado su inscripción a la siguiente partida:
</p>
<ul>
    <li><strong>Ubicación:</strong> <?= $session->location ?></li>
    <li><strong>Fecha:</strong> <?= weekday(date('N', strtotime($session->date))) ?> <?= date('d/m/Y', strtotime($session->date)) ?><br/></li>
    <li><strong>Hora:</strong> <?= date('H:i', strtotime($session->time)) ?></li>
    <li><strong>Duración:</strong> <?= $adventure->duration ?></strong> 
</ul>

<? if ($master_email) : ?>
    <p>
        Si tienes alguna duda, puedes responder a este email para contactar con el Master.
    </p>
<? endif; ?>

<p>
    Lamentamos que no puedas participar en esta ocasión y esperamos verte en futuras partidas.
</p>