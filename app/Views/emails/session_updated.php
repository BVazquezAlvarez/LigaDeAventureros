<h1>La partida <?= $adventure->name ?> ha sido modificada</h1>

<p>
    ¡Hola <?= $user->display_name ?>!
</p>

<p>
    Te informamos de que una partida en la que estás anotado ha sido modificada. Si a causa de estos cambios no puedes asistir a la partida, recuerda cancelar tu inscripción.
</p>

<p>
    Estos son los nuevos datos de la partida:
</p>
<ul>
    <li><strong>Ubicación:</strong> <?= $session->location ?></li>
    <li><strong>Fecha:</strong> <?= weekday(date('N', strtotime($session->date))) ?> <?= date('d/m/Y', strtotime($session->date)) ?><br/></li>
    <li><strong>Hora:</strong> <?= date('H:i', strtotime($session->time)) ?></li>
    <li><strong>Duración:</strong> <?= $adventure->duration ?></strong> 
</ul>

<p>
    Estás anotado con el siguiente personaje:
</p>
<ul>
    <li><strong>Nombre:</strong> <?= $character->name ?></li>
    <li><strong>Clase:</strong> <?= $character->class ?></li>
    <li><strong>Nivel:</strong> <?= $character->level ?></li>
</ul>

<? if ($waitlist) : ?>
    <p>
        Te recordamos que <span class="rojo">actualmente estás en lista de espera</span>. Se te informará si se abre un espacio para ti, siempre que tengas esa opción activa en <a href="<?= base_url('settings') ?>">tu configuración</a>.
    </p>
<? endif; ?>

<? if ($master_email) : ?>
    <p>
        Si tienes alguna duda, puedes responder a este email para contactar con el Master.
    </p>
<? endif; ?>