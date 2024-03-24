<h1>¡Bienvenido a <?= setting('app_name') ?>!</h1>
<p>
    ¡Hola <?= $user->display_name ?>!
</p>
<p>
    Te damos la bienvenida a esta comunidad, esperemos que te sientas como en casa.
</p>
<p>
    Queremos que sepas que respetamos tu privacidad. En <?= setting('app_name') ?>, todos los envíos de correo electrónico son opcionales. No recibirás ningún otro correo electrónico de nuestra parte a menos que lo actives en tu configuración.
</p>
<p>
    Si tienes alguna duda o necesitas ayuda para comenzar, puedes contactar con nosotros en <a href="mailto:<?= setting('contact_email') ?>">nuesta dirección de correo electrónico</a>.
</p>
<p>
    ¡Esperamos que te diviertas y hagas nuevos amigos!
</p>
<a class="button" href="<?= base_url() ?>">¡Comienza tu aventura!</a>