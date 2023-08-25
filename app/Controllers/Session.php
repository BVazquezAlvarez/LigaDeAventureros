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

class Session extends BaseController {

    public function __construct() {
        $this->SessionModel = model('SessionModel');
    }

    public function join() {
        $session_uid = $this->request->getVar('session-uid');
        $player_uid = session('user_uid');
        $character_uid = $this->request->getVar('character-uid');

        $this->SessionModel->addPlayerSession([
            'session_uid' => $session_uid,
            'player_uid' => $player_uid,
            'player_character_uid' => $character_uid,
        ]);

        session()->setFlashdata('success', 'Te has anotado a una partida');
        return redirect()->to('/');
    }

    public function swap() {
        $session_uid = $this->request->getVar('session-uid');
        $player_uid = session('user_uid');
        $character_uid = $this->request->getVar('character-uid');

        $this->SessionModel->updatePlayerSession($session_uid, $player_uid, [
            'player_character_uid' => $character_uid,
        ]);

        session()->setFlashdata('success', 'Se ha cambiado el personaje con el que estabas anotado');
        return redirect()->to('/');

    }

    public function cancel() {
        $session_uid = $this->request->getVar('session-uid');
        $player_uid = session('user_uid');

        $this->SessionModel->deletePlayerSession($session_uid, $player_uid);

        session()->setFlashdata('success', 'Se ha cancelado tu inscripción.');
        return redirect()->to('/');
    }

}