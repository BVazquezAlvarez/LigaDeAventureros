<?php
// LigaDeAventureros
// Copyright (C) 2026 Santiago González Lago

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

<? foreach (links_menu() as $link) : ?>
  <? if ($link->children) : ?>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="dropdown_<?= $link->link_menu_id ?>" role="button" data-toggle="dropdown">
        <?= $link->text ?>
      </a>
      <ul class="dropdown-menu">
        <? foreach ($link->children as $child) : ?>
          <?= view('partials/menu/item', ['link' => $child]) ?>
        <? endforeach; ?>
      </ul>
    </li>
  <? else : ?>
    <li class="nav-item"><a class="nav-link" href="<?= $link->url ?>" <?= $link->new_tab ? 'target="_blank"' : '' ?>><?= $link->text ?></a></li>
  <? endif; ?>
<? endforeach; ?>