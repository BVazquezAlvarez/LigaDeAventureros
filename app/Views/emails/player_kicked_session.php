<h1>Has sido expulsado de la partida <?= $adventure->name ?></h1>

<p>
    ¡Hola <?= $user->display_name ?>!
</p>

<p>
    Lamentamos informarte que has sido expulsado de la siguiente partida:
</p>
<ul>
    <li><strong>Ubicación:</strong> <?= $session->location ?></li>
    <li><strong>Fecha:</strong> <?= weekday(date('N', strtotime($session->date))) ?> <?= date('d/m/Y', strtotime($session->date)) ?><br/></li>
    <li><strong>Hora:</strong> <?= date('H:i', strtotime($session->time)) ?></li>
    <li><strong>Duración:</strong> <?= $adventure->duration ?></li>
</ul>

<? if ($master_email) : ?>
    <p>
        Si tienes alguna pregunta o inquietud sobre tu expulsión, puedes responder a este correo electrónico para ponerte en contacto con el Master.
    </p>
<? endif; ?>