<?php
// LigaDeAventureros
// Copyright (C) 2023 Santiago González Lago

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

<?php

use CodeIgniter\Pager\PagerRenderer;


$pager->setSurroundCount(2);
?>

<? if ($pager->getPageCount() > 1) : ?>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($pager->hasPrevious()) : ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $pager->getFirst() ?>" aria-label="Primero">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Primera página</span>
                    </a>
                </li>
            <?php endif ?>

            <?php foreach ($pager->links() as $link): ?>
                <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                    <a class="page-link" href="<?= $link['uri'] ?>">
                        <?= $link['title'] ?>
                    </a>
                </li>
            <?php endforeach ?>

            <?php if ($pager->hasNext()) : ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $pager->getLast() ?>" aria-label="Último">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Última página</span>
                    </a>
                </li>
            <?php endif ?>
        </ul>
    </nav>
<? endif; ?>