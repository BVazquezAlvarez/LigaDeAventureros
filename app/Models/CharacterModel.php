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
        'w_setting_id',
        'beyond'
    ];

    public function getCharacter($uid) {
        $builder = $this->db->table('player_character');
        $builder->select('player_character.*, world_setting.name AS w_setting_name, world_setting.timeline');
        $builder->join('world_setting', 'player_character.w_setting_id = world_setting.id', 'left');
        $builder->where('uid', $uid);
        return $builder->get()->getRow();
    }

    public function getPlayerCharacters($user_uid, $activeOnly = false, $w_setting_id = null) {
        $builder = $this->db->table('player_character');
        $builder->select('player_character.*, world_setting.name AS w_setting_name, world_setting.timeline');
        $builder->join('world_setting', 'player_character.w_setting_id = world_setting.id', 'left');
        $builder->where('user_uid', $user_uid);
        $builder->orderBy('player_character.active', 'DESC');
        $builder->orderBy('level', 'DESC');
        if ($activeOnly) {
            $builder->where('player_character.active', 1);
        }
        if($w_setting_id && $w_setting_id != 0){
            $builder->where('w_setting_id', $w_setting_id);
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
        $builder->select('player_character.*, user.display_name, user.confirmed, world_setting.name AS w_setting_name, world_setting.timeline');
        $builder->join('user', 'player_character.user_uid = user.uid', 'left');
        $builder->join('world_setting', 'player_character.w_setting_id = world_setting.id', 'left');
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
        $builder->select('player_character.*, user.display_name, world_setting.name AS w_setting_name, world_setting.timeline');
        $builder->join('user', 'player_character.user_uid = user.uid', 'left');
        $builder->join('world_setting', 'player_character.w_setting_id = world_setting.id', 'left');
        $builder->where('world_setting.active', 1);
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
        $builder->join('world_setting', 'player_character.w_setting_id = world_setting.id', 'left');
        $builder->where('player_character.active', 1);
        $builder->where('world_setting.active', 1);
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

}