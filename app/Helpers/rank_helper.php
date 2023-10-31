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

function rank_get($level): int {
    if ($level <= 4) return 1;
    if ($level <= 10) return 2;
    if ($level <= 16) return 3;
    return 4;
}

function rank_name($rank) : string {
    if ($rank == 1) return 'Bronce';
    if ($rank == 2) return 'Plata';
    if ($rank == 3) return 'Oro';
    if ($rank == 4) return 'Mithril';
    return 'Todos';
}

function rank_full_text($rank) : string {
    if ($rank == 1) return 'Bronce (1-4)';
    if ($rank == 2) return 'Plata (5-10)';
    if ($rank == 3) return 'Oro (11-16)';
    if ($rank == 4) return 'Mithril (17-20)';
    return 'Todos los rangos';
}