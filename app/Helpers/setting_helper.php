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

function setting($id): string {
    global $settings;
    if (isset($settings[$id])) {
        return $settings[$id];
    }
    $db = \Config\Database::connect();
    $builder = $db->table('settings');
    $builder->where('id',$id);
    $result = $builder->get()->getRow();
    if ($result) {
        $settings[$id] = $result->value;
        return $result->value;
    } else {
        return '';
    }    
}