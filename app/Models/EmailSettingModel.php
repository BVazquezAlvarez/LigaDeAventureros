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

class EmailSettingModel extends Model {

	protected $table = 'email_setting';

	protected $allowedFields = [
		'user_uid',
		'setting',
	];

    public function getUserSettings($user_uid) {
        $builder = $this->db->table('email_setting');
        $builder->where('user_uid', $user_uid);
        $results = $builder->get()->getResultArray();
        return array_column($results, 'setting');
    }

    public function addSettings($user_uid, $settings) {
        if (!empty($settings)) {
            $data = [];
            foreach ($settings as $setting) {
                $data[] = [
                    'user_uid' => $user_uid,
                    'setting' => $setting,
                ];
            }
    
            $builder = $this->db->table('email_setting');
            $builder->insertBatch($data);
            return $this->db->affectedRows();
        }
        return 0;
    }

    public function deleteSettings($user_uid, $settings) {
        if (!empty($settings)) {
            $builder = $this->db->table('email_setting');
            $builder->where('user_uid', $user_uid);
            $builder->whereIn('setting', $settings);
            $builder->delete();
            return $this->db->affectedRows();
        }
        return 0;
    }

    public function checkUserSetting($user_uid, $setting) {
        $builder = $this->db->table('email_setting');
        $builder->select('setting');
        $builder->where('user_uid', $user_uid);
        $builder->where('setting', $setting);
        $result = $builder->get()->getRow();

        return !!$result;
    }

}