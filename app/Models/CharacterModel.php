<?php
// LigaDeAventureros
// Copyright (C) 2023-2024 Santiago González Lago

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
        'image',
        'wiki',
        'logsheet',
        'description',
        'gold',
        'treasure_points',
        'reject_level'
    ];

    public function getCharacter($uid) {
        $builder = $this->db->table('player_character');
        $builder->where('uid', $uid);
        return $builder->get()->getRow();
    }

    public function getPlayerCharacters($user_uid, $activeOnly = false) {
        $builder = $this->db->table('player_character');
        $builder->where('user_uid', $user_uid);
        $builder->orderBy('active', 'DESC');
        $builder->orderBy('level', 'DESC');
        if ($activeOnly) {
            $builder->where('active', 1);
        }
        return $builder->get()->getResult();
    }

    public function addCharacter($data) {
		$this->db->table('player_character')->insert($data);
		return $this->db->affectedRows();
	}

    public function updateCharacter($uid, $data) {
        $builder = $this->db->table('player_character');
        $builder->where('uid', $uid);
        $builder->update($data);
    }

    public function getCharactersValidationPending() {
        $builder = $this->db->table('player_character');
        $builder->select('player_character.*, user.display_name, user.confirmed');
        $builder->join('user', 'player_character.user_uid = user.uid', 'left');
        $builder->groupStart();
        $builder->where('player_character.uploaded_sheet != player_character.validated_sheet');
        $builder->orWhere('player_character.validated_sheet IS NULL');
        $builder->groupEnd();
        $builder->where('user.banned', 0);
        $builder->where('player_character.active', 1);
        $builder->orderBy('user.confirmed', 'ASC');
        $builder->orderBy('player_character.date_uploaded', 'ASC');
        return $builder->get()->getResult();
    }

    public function getCharactersValidationPendingCount() {
        $builder = $this->db->table('player_character');
        $builder->select('player_character.*, user.display_name, user.confirmed');
        $builder->join('user', 'player_character.user_uid = user.uid', 'left');
        $builder->groupStart();
        $builder->where('player_character.uploaded_sheet != player_character.validated_sheet');
        $builder->orWhere('player_character.validated_sheet IS NULL');
        $builder->groupEnd();
        $builder->where('user.banned', 0);
        $builder->where('player_character.active', 1);
        return $builder->countAllResults();
    }

    public function getAllActiveCharacters($offset = NULL, $limit = NULL, $q = NULL) {
        $builder = $this->db->table('player_character');
        $builder->select('player_character.*, user.display_name');
        $builder->join('user', 'player_character.user_uid = user.uid', 'left');
        $builder->where('player_character.active', 1);
        $builder->where('user.banned', 0);
        $builder->where('player_character.validated_sheet IS NOT NULL');
        if ($q) {
            $builder->like('player_character.name', $q);
			$builder->orLike('player_character.class', $q);
			$builder->orLike('user.display_name', $q);
        }
        $builder->orderBy('player_character.level', 'DESC');
		if ($limit) {
			$builder->limit($limit, $offset);
		}
        return $builder->get()->getResult();
    }

    public function countAllActiveCharacters($q = NULL) {
        $builder = $this->db->table('player_character');
        $builder->join('user', 'player_character.user_uid = user.uid', 'left');
        $builder->where('player_character.active', 1);
        $builder->where('user.banned', 0);
        $builder->where('player_character.validated_sheet IS NOT NULL');
        if ($q) {
            $builder->like('player_character.name', $q);
            $builder->orLike('player_character.class', $q);
            $builder->orLike('user.display_name', $q);
        }
        return $builder->countAllResults();
    }

    public function deleteCharacter($uid) {
        $builder = $this->db->table('player_character');
        $builder->where('uid', $uid);
        $builder->delete();
    }

    public function addItems($items) {
        if (!empty($items)) {
            $this->db->table('character_item')->insertBatch($items);
        }
    }

    public function rmItems($items) {
        if (!empty($items)) {
            $builder = $this->db->table('character_item');
            $builder->whereIn('id', $items);
            $builder->delete();
        }
    }

    public function getCharacterItems($character_uid) {
        $builder = $this->db->table('character_item');
        $builder->select('item.*, character_item.id AS unique_item_id');
        $builder->join('item', 'character_item.item_id = item.id', 'left');
        $builder->where('character_item.player_character_uid', $character_uid);
        return $builder->get()->getResult();
    }

    public function createLogsheetEntry($character_uid, $session_uid = NULL, $master = NULL, $notes = NULL, $death = 0) {
        $character = $this->getCharacter($character_uid);
        $items = array();
        foreach ($this->getCharacterItems($character_uid) as $i) {
            $items[] = $i->name;
        }
        $data = array(
            'character_uid' => $character_uid,
            'session_uid' => $session_uid,
            'master' => $master,
            'level' => $character->level,
            'gold' => $character->gold,
            'treasure_points' => $character->treasure_points,
            'total_items' => count($items),
            'items' => implode(', ',$items),
            'notes' => $notes,
            'death' => $death,
        );
        $this->db->table('logsheet')->insert($data);
    }

    public function getLogsheet($character_uid) {
        $builder = $this->db->table('logsheet');
        $builder->select('logsheet.*, user.display_name AS master_name, adventure.name AS adventure');
        $builder->join('user', 'logsheet.master = user.uid', 'left');
        $builder->join('session', 'logsheet.session_uid = session.uid', 'left');
        $builder->join('adventure', 'session.adventure_uid = adventure.uid', 'left');
        $builder->where('logsheet.character_uid', $character_uid);
        $builder->orderBy('logsheet.date', 'DESC');
        return $builder->get()->getResult();
    }

}