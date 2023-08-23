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

namespace App\Models;  
use CodeIgniter\Model;

class CharacterModel extends Model {

	protected $table = 'player_character';
	protected $primaryKey = 'uid';

	protected $allowedFields = [
		'uid',
		'user_uid',
		'display_name',
		'name',
        'class',
        'level',
		'uploaded_sheet',
        'date_uploaded',
        'validated_sheet',
        'active',
	];

    public function getPlayerCharacters($user_uid) {
        $builder = $this->db->table('player_character');
        $builder->where('user_uid', $user_uid);
        $builder->orderBy('active', 'DESC');
        $builder->orderBy('level', 'DESC');
        return $builder->get()->getResult();
    }

    public function addCharacter($data) {
		$this->db->table('player_character')->insert($data);
		return $this->db->affectedRows();
	}

}