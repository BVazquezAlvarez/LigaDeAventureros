<?php
// LigaDeAventureros
// Copyright (C) 2026 Santiago González Lago

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

class ResourceModel extends Model {

  protected $table = 'resource';
  protected $primaryKey = 'id';

  protected $allowedFields = [
    'id',
    'title',
    'description',
    'type',
    'location',
    'position',
    'active'
  ];

  public function getResources($start, $limit, $q, $active_only = true) {
    $builder = $this->db->table('resource');
    if ($active_only) {
      $builder->where('active', 1);
    }
    if ($q) {
      $builder->groupStart();
      $builder->like('title', $q);
      $builder->orLike('description', $q);
      $builder->groupEnd();
    }
    $builder->orderBy('position', 'ASC');
    $builder->limit($limit, $start);
    return $builder->get()->getResult();
  }

  public function getTotalResources($q, $active_only = true) {
    $builder = $this->db->table('resource');
    if ($active_only) {
      $builder->where('active', 1);
    }
    if ($q) {
      $builder->groupStart();
      $builder->like('title', $q);
      $builder->orLike('description', $q);
      $builder->groupEnd();
    }
    return $builder->countAllResults();
  }

}