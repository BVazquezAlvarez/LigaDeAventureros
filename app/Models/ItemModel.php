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

namespace App\Models;
use CodeIgniter\Model;

class ItemModel extends Model {

    protected $table = 'item';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'source',
        'page',
        'rarity',
        'type',
        'attunement',
        'full_description',
    ];

    public function getItems() {
        $builder = $this->db->table('item');
        return $builder->get()->getResult();
    }

}