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

class UserModel extends Model {

	protected $table = 'user';
	protected $primaryKey = 'uid';

	protected $allowedFields = [
		'uid',
		'email',
		'display_name',
		'confirmed',
        'master',
		'admin',
		'password',
        'date_created',
        'banned',
		'delete_on'
	];

	public function getUsers($offset = NULL, $limit = NULL, $q = NULL) {
		$builder = $this->db->table('user');
		if ($limit) {
			$builder->limit($limit, $offset);
		}
		if ($q) {
			$keywords = array_filter(explode(' ', $q));
			$builder->groupStart();
			foreach ($keywords as $keyword) {
				$builder->orLike('uid', $keyword);
				$builder->orLike('display_name', $keyword);
			}
			$builder->groupEnd();
		}
		return $builder->get()->getResult();
	}

	public function getTotalUsers($q = NULL) {
		$builder = $this->db->table('user');
		if ($q) {
			$keywords = array_filter(explode(' ', $q));
			$builder->groupStart();
			foreach ($keywords as $keyword) {
				$builder->orLike('uid', $keyword);
				$builder->orLike('display_name', $keyword);
			}
			$builder->groupEnd();
		}
        return $builder->get()->getNumRows();
	}

	public function getTotalUsersConfirmed() {
		$builder = $this->db->table('user');
        $builder->where('banned', 0);
        $builder->where('confirmed', 1);
        return $builder->get()->getNumRows();
	}

	public function getTotalUsersUnconfirmed() {
		$builder = $this->db->table('user');
        $builder->where('banned', 0);
        $builder->where('confirmed', 0);
        return $builder->get()->getNumRows();
	}

	public function getTotalUsersBanned() {
		$builder = $this->db->table('user');
        $builder->where('banned', 1);
        return $builder->get()->getNumRows();
	}

	public function getMasters() {
		$builder = $this->db->table('user');
        $builder->where('master', 1);
        return $builder->get()->getResult();
	}
	
	public function checkEmailExists($email) {
		$user = $this->where('email', $email)->first();
		return isset($user);
	}

	public function addUser($data) {
		$this->db->table('user')->insert($data);
		return $this->db->affectedRows();
	}

	public function updateUser($uid, $data) {
		$builder = $this->db->table('user');
		$builder->where('uid', $uid);
    	$builder->update($data);
	}

	public function getUser($uid) {
		$builder = $this->db->table('user');
        $builder->where('uid', $uid);
        return $builder->get()->getRow();
	}

    public function getValidUser($uid) {
        $builder = $this->db->table('user');
        $builder->where('uid', $uid);
        $builder->where('banned', 0);
        return $builder->get()->getRow();
    }

	public function getUserByEmail($email) {
        $builder = $this->db->table('user');
        $builder->where('email', $email);
        return $builder->get()->getRow();
	}

}