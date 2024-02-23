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

function weekday($day) {
    if ($day == 1) return 'Lunes';
    if ($day == 2) return 'Martes';
    if ($day == 3) return 'Miércoles';
    if ($day == 4) return 'Jueves';
    if ($day == 5) return 'Viernes';
    if ($day == 6) return 'Sábado';
    if ($day == 7) return 'Domingo';
    return '';
}

function safe_text_links($text) {
    $regex = '/\b(?:https?|ftp):\/\/\S+|www\.\S+\b/i';
    return preg_replace($regex, '<a href="$0" target="_blank">$0</a>', strip_tags($text));
}