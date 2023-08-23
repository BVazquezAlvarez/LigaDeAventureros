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

class Master extends BaseController {

    public function __construct() {
        if (!$this->isMaster()) {
            header("Location: /");
            exit();
        }
        $this->UserModel = model('UserModel');
        $this->CharacterModel = model('CharacterModel');
    }

    protected function setTitle(string $title) {
        parent::setTitle($title . ' - Área de masters');
    }

    public function index() {
        $this->setData('sheets_pending_count', $this->CharacterModel->getCharactersValidationPendingCount());
        $this->setTitle('Panel de control');
        return $this->loadView('master/index');
    }

    public function sheets() {
        $this->setData('sheets', $this->CharacterModel->getCharactersValidationPending());
        $this->setTitle('Validar hojas de personaje');
        return $this->loadView('master/sheets');
    }

    public function validate_sheet() {
        $uid = $this->request->getVar('uid');
        $character = $this->CharacterModel->getCharacter($uid);
        $data = [
            'validated_sheet' => $character->uploaded_sheet
        ];
        $this->CharacterModel->updateCharacter($uid, $data);

        $user = $this->UserModel->getUser($character->user_uid);
        if (!$user->confirmed) {
            $data = [
                'confirmed' => 1
            ];
            $this->UserModel->updateUser($character->user_uid, $data);
        }

        session()->setFlashdata('success', 'Se ha validado la ficha de '.$character->name);
        return redirect()->to('master/sheets');
    }

    public function adventures() {
        $this->setTitle('Aventuras y sesiones');
        return $this->loadView('master/adventures');
    }

    public function new_session() {
        $this->setTitle('Nueva sesión');
        return $this->loadView('master/newsession');
    }

}