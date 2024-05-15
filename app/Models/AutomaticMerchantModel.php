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

class AutomaticMerchantModel extends Model {

    protected $table = 'automatic_merchant';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'timestamp_start',
        'frequency_days',
        'active',
        'common',
        'uncommon',
        'rare',
        'very_rare',
        'legendary',
    ];

    public function getMerchant($id) {
        $builder = $this->db->table('automatic_merchant');
        $builder->where('id', $id);
        return $builder->get()->getRow();
    }

    public function getMerchants($offset = NULL, $limit = NULL, $activeOnly = false) {
        $builder = $this->db->table('automatic_merchant');
		if ($limit) {
			$builder->limit($limit, $offset);
		}
        if ($activeOnly) {
            $this->db->where('active', 1);
        }
        return $builder->get()->getResult();
    }

    public function getTotalMerchants($activeOnly = false) {
        $builder = $this->db->table('automatic_merchant');
        if ($activeOnly) {
            $this->db->where('active', 1);
        }
        return $builder->get()->getNumRows();
    }

    public function addMerchant($data) {
		$this->db->table('automatic_merchant')->insert($data);
		return $this->db->insertID();
	}

    public function updateMerchant($id, $data) {
        $builder = $this->db->table('automatic_merchant');
        $builder->where('id', $id);
        $builder->update($data);
    }

    public function deleteMerchant($id) {
        $builder = $this->db->table('automatic_merchant');
        $builder->where('id', $id);
        $builder->delete();
    }
}