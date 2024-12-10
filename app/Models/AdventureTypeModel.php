<?php
// LigaDeAventureros
// Copyright (C) 2024 Borja Vázquez Álvarez

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

class AdventureTypeModel extends Model {

	protected $table = 'adventure_type';
	protected $primaryKey = 'id';

	protected $allowedFields = [
		'id',
        'name',
        'active'
	];

    public function getAdventureTypeList() {
        $builder = $this->db->table('adventure_type');
        return $builder->get()->getResult();
    }


}