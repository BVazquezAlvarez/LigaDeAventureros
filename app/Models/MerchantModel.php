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

class MerchantModel extends Model {

    protected $table = 'merchant';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'permanent',
        'timestamp_start',
        'timestamp_end',
        'automatic_merchant_id',
    ];

    public function getMerchant($id) {
        $builder = $this->db->table('merchant');
        $builder->where('id', $id);
        return $builder->get()->getRow();
    }

    public function getMerchants($offset = NULL, $limit = NULL, $activeOnly = false) {
        $builder = $this->db->table('merchant');
		if ($limit) {
			$builder->limit($limit, $offset);
		}
        if ($activeOnly) {
            $builder->where('permanent', 1);
            $builder->orGroupStart();
            $builder->where('timestamp_start <=', date('Y-m-d H:i:s'));
            $builder->where('timestamp_end >=', date('Y-m-d H:i:s'));
            $builder->groupEnd();
        }
        $builder->orderBy('ISNULL(automatic_merchant_id)', 'DESC');
        $builder->orderBy('permanent', 'DESC');
        $builder->orderBy('timestamp_start', 'ASC');
        return $builder->get()->getResult();
    }

    public function getTotalMerchants($activeOnly = false) {
        $builder = $this->db->table('merchant');
        if ($activeOnly) {
            $builder->where('permanent', 1);
            $builder->orGroupStart();
            $builder->where('timestamp_start <=', date('Y-m-d H:i:s'));
            $builder->where('timestamp_end >', date('Y-m-d H:i:s'));
            $builder->groupEnd();
        }
        return $builder->get()->getNumRows();
    }

    public function addMerchant($data) {
		$this->db->table('merchant')->insert($data);
		return $this->db->insertID();
	}

    public function updateMerchant($id, $data) {
        $builder = $this->db->table('merchant');
        $builder->where('id', $id);
        $builder->update($data);
    }

    public function addItems($items) {
        if (!empty($items)) {
            $this->db->table('merchant_item')->insertBatch($items);
        }
    }

    public function rmItems($items) {
        if (!empty($items)) {
            $builder = $this->db->table('merchant_item');
            $builder->whereIn('merchant_item_id', $items);
            $builder->delete();
        }
    }

    public function getMerchantItems($merchant_id) {
        $builder = $this->db->table('merchant_item');
        $builder->select('item.*, merchant_item.merchant_item_id');
        $builder->join('item', 'merchant_item.item_id = item.id', 'left');
        $builder->where('merchant_item.merchant_id', $merchant_id);
        $builder->orderBy('cost', 'DESC');
        return $builder->get()->getResult();
    }

    public function deleteMerchant($id) {
        $builder = $this->db->table('merchant');
        $builder->where('id', $id);
        $builder->delete();
    }

    public function checkMerchantHasItem($item_id, $merchant_id) {
        $builder = $this->db->table('merchant_item');
        $builder->where('item_id', $item_id);
        $builder->where('merchant_id', $merchant_id);
        $row = $builder->get()->getRow();
        return !!$row;
    }
}