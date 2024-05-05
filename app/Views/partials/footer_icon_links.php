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

<div class="links-container">
    <? if (setting('whatsapp')) : ?>
        <a href="<?= setting('whatsapp') ?>" target="_blank"><i class="fab fa-whatsapp fa-2x text-secondary"></i></a>
    <? endif; ?>
    <? if (setting('discord')) : ?>
        <a href="<?= setting('discord') ?>" target="_blank"><i class="fab fa-discord fa-2x text-secondary"></i></a>
    <? endif; ?>
    <? if (setting('instagram')) : ?>
        <a href="<?= setting('instagram') ?>" target="_blank"><i class="fab fa-instagram fa-2x text-secondary"></i></a>
    <? endif; ?>
    <a href="https://github.com/SantiGonzalezLago/LigaDeAventureros" target="_blank"><i class="fab fa-github fa-2x text-secondary"></i></a>
</div>