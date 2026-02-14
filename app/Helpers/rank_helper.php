<?php
// LigaDeAventureros
// Copyright (C) 2023-2026 Santiago González Lago

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

function rank_get($level, $setting = 'dnd'): int {
    if ($setting == 'dnd') {
        if ($level <= 4) return 1;
        if ($level <= 10) return 2;
        if ($level <= 16) return 3;
        return 4;
    }
    if ($setting == 'daggerheart') {
        if ($level <= 1) return 1;
        if ($level <= 4) return 2;
        if ($level <= 7) return 3;
        return 4;
    }
    return 0;
}

function rank_name($tier, $setting = 'dnd') : string {
    $tiers = [
        'dnd' => [
            1 => 'Bronce',
            2 => 'Plata',
            3 => 'Oro',
            4 => 'Mithril'
        ],
        'daggerheart' => [
            1 => 'Tier 1',
            2 => 'Tier 2',
            3 => 'Tier 3',
            4 => 'Tier 4'
        ],
    ];
    if (isset($tiers[$setting])) {
        return $tiers[$setting][$tier] ?? 'Todos';
    }
    return 'Error';
}

function rank_full_text($tier, $setting = 'dnd') : string {
    $tiers = [
        'dnd' => [
            1 => 'Bronce (1-4)',
            2 => 'Plata (5-10)',
            3 => 'Oro (11-16)',
            4 => 'Mithril (17-20)'
        ],
        'daggerheart' => [
            1 => 'Tier 1 (1)',
            2 => 'Tier 2 (2-4)',
            3 => 'Tier 3 (5-7)',
            4 => 'Tier 4 (8-10)'
        ],
    ];
    if (isset($tiers[$setting])) {
        return $tiers[$setting][$tier] ?? 'Todos los rangos';
    }
    return 'Error';
}