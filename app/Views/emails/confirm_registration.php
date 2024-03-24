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