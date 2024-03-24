<?php
// LigaDeAventureros
// Copyright (C) 2024 Santiago González Lago

// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.

// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <https://www.gnu.org/licenses/>.
?>

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