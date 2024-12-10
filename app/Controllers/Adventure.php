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

namespace App\Controllers;

class Adventure extends BaseController {

    public function __construct() {
        $this->AdventureModel = model('AdventureModel');
        $this->WorldSettingModel = model('WorldSettingModel');
        $this->AdventureTypeModel = model('AdventureTypeModel');

    }

    public function data_ajax() {
        $uid = $this->request->getVar('uid');
        $adventure = $this->AdventureModel->getAdventure($uid);
        $world_settings = $this->WorldSettingModel->getWorldSettingList();
        $adventure_type = $this->AdventureTypeModel->getAdventureTypeList();

        if ($adventure) {
            $adventure->rank_text = rank_full_text($adventure->rank);
        }
        
        echo json_encode([
            'error' => !$adventure,
            'adventure' => $adventure,
            'world_settings' => $world_settings,
            'adventure_type' => $adventure_type
        ]);
    }

}