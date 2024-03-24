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

<h1>Tu solicitud de eliminación de cuenta en <?= setting('app_name') ?> ha sido cancelada</h1>
<p>
    ¡Hola <?= $user->display_name ?>!
</p>
<p>
    Tu solicitud para eliminar tu cuenta ha sido cancelada con éxito. Tu cuenta seguirá activa y podrás seguir utilizando <?= setting('app_name') ?> como de costumbre.
</p>
<p>
    Si tienes alguna pregunta o necesitas ayuda con cualquier otro asunto, no dudes en ponerte en contacto con nosotros en <a href="mailto:<?= setting('contact_email') ?>">nuestra dirección de correo electrónico</a>.
</p>
<p>
    Apreciamos que hayas decidido seguir siendo parte de nuestra comunidad y esperamos que sigas disfrutando de todos los servicios que ofrecemos.
</p>