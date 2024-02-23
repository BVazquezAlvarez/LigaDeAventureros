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
    if (!isset($settings[$id])) {
        $db = \Config\Database::connect();
        $builder = $db->table('settings');
        $builder->where('id',$id);
        $result = $builder->get()->getRow();
        $settings[$id] = $result ? $result->value : 'NULL';
    }
    return $settings[$id];
}

function setting_all() {
    $db = \Config\Database::connect();
    $builder = $db->table('settings');
    return $builder->get()->getResult();
}

function setting_update($id, $value) {
    $db = \Config\Database::connect();
    $builder = $db->table('settings');
    $builder->where('id', $id)->update(['value' => $value]);
    global $settings;
    $settings[$id] = $value;
}