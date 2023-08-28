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

class UploadLogModel extends Model {

    protected $table = 'upload_log';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id',
        'user_uid',
        'directory',
        'file',
        'remote_addr',
        'http_x_forwarded_for',
        'timestamp',
    ];

    function getLogs($offset, $limit) {
        $builder = $this->db->table('upload_log');
        $builder->select('upload_log.*, user.display_name');
        $builder->join('user', 'upload_log.user_uid = user.uid', 'left');
        $builder->limit($limit, $offset);
        $builder->orderBy('upload_log.timestamp','DESC');
        return $builder->get()->getResult();
    }

    function getTotalLogs() {
        $builder = $this->db->table('upload_log');
        return $builder->get()->getNumRows();
    }

}