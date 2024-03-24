<h1>Hemos recibido tu solicitud de eliminación de cuenta en <?= setting('app_name') ?></h1>
<p>
    ¡Hola <?= $user->display_name ?>!
</p>
<p>
    Queremos informarte que tu solicitud para eliminar tu cuenta ha sido recibida. La eliminación de tu cuenta será efectiva dentro de 14 días a partir de hoy.
</p>
<p>
    Si has cambiado de opinión o necesitas acceder a tu cuenta nuevamente, puedes cancelar la eliminación de la cuenta en cualquier momento durante estos 14 días iniciando sesión en <?= setting('app_name') ?>. No es necesario hacer nada si deseas continuar con la eliminación.
</p>
<p>
    Si tienes alguna pregunta o necesitas ayuda con este proceso, no dudes en ponerte en contacto con nosotros en <a href="mailto:<?= setting('contact_email') ?>">nuestra dirección de correo electrónico</a>.
</p>
<a class="button" href="<?= base_url() ?>">Inicia sesión para cancelar el proceso de borrado</a>