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
        'date_created',
        'banned'
	];

	public function getUsers() {
		return $this->db->table('user')->get()->getResult();
	}
	
	public function checkEmailExists($email) {
		$user = $this->where('email', $email)->first();
		return isset($user);
	}

	public function addUser($data) {
		$this->db->table('user')->insert($data);
		return $this->db->affectedRows();
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