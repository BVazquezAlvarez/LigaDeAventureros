<?php
// LigaDeAventureros
// Copyright (C) 2025 Santiago González Lago

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

namespace App\Controllers;

class Api extends BaseController {

  public function __construct() {
    $this->db = \Config\Database::connect();
  }

  public function characters() {
    $user = $this->request->getVar('user');
    $setting = $this->request->getVar('setting');

    $builder = $this->db->table('player_character');
    $builder->join('user', 'user.uid = player_character.user_uid');
    $builder->select('player_character.uid AS character_uid, player_character.name AS character_name, player_character.level, player_character.beyond, player_character.user_uid, user.display_name AS user_name');
    if ($user) {
      $builder->where('player_character.user_uid', $user);
    }
    if ($setting) {
      $builder->where('player_character.w_setting_id', $setting);
    }
    $builder->where('player_character.active', 1);
    $characters = $builder->get()->getResultArray();

    $this->_showJSON($characters);
  }

  private function _showJSON($json) {
    header('Content-Type: application/json');
    echo json_encode($json);
    exit;
  }

}
