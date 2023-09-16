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
        $this->AdventureModel = model('AdventureModel');
        $this->SessionModel = model('SessionModel');
    }

    protected function setTitle(string $title) {
        parent::setTitle($title . ' - Área de masters');
    }

    public function index() {
        $upcomingSessions = $this->SessionModel->getSessions(date('c', strtotime('today')), NULL, session('user_uid'));
        foreach ($upcomingSessions as $session) {
            $players = $this->SessionModel->getSessionPlayers($session->uid);
    
            foreach ($players as $player) {
                if (!$session->rank || $session->rank == rank_get($player->level)) {
                    $player->badge_color = 'success';
                } else if ($session->rank > rank_get($player->level)) {
                    $player->badge_color = 'warning';
                } else {
                    $player->badge_color = 'danger';
                }
            }

            $session->players = [
                'playing' => array_slice($players, 0, $session->players_max),
                'waitlist' => array_slice($players, $session->players_max),
            ];
        }

        $this->setData('upcoming_sessions', $upcomingSessions);
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

    public function reject_sheet() {
        $uid = $this->request->getVar('uid');
        $character = $this->CharacterModel->getCharacter($uid);

        if ($character->validated_sheet) {
            $data = [
                'uploaded_sheet' => $character->validated_sheet
            ];
            $this->CharacterModel->updateCharacter($uid, $data);
        } else {
            $this->CharacterModel->where('uid', $uid)->delete();
        }

        session()->setFlashdata('success', 'Se ha rechazado la ficha de '.$character->name);
        return redirect()->to('master/sheets');
    }

    public function adventures() {
        $filters = [
            'q'        => session('adventures.filters.q'),
            'rank'     => session('adventures.filters.rank'),
            'my_games' => session('adventures.filters.my_games'),
            'unplayed' => session('adventures.filters.unplayed'),
        ];

        $this->setData('filters', $filters);
        $this->setData('adventures', $this->AdventureModel->getAdventuresWithSessionData($filters));
        $this->setTitle('Aventuras y sesiones');
        return $this->loadView('master/adventures');
    }

    public function adventures_post() {
        session()->set('adventures.filters.q',        $this->request->getPost('q'));
        session()->set('adventures.filters.rank',     $this->request->getPost('rank'));
        session()->set('adventures.filters.my_games', $this->request->getPost('my_games'));
        session()->set('adventures.filters.unplayed', $this->request->getPost('unplayed'));
        return redirect()->to('master/adventures');
    }

    public function adventure($uid) {
        session()->setFlashdata('error', 'La página de aventura todavía no está disponible.');
        return redirect()->to('master/adventures');
    }

    public function new_session() {
        $this->setData('adventures', $this->AdventureModel->getAdventureList());
        $this->setData('masters', $this->UserModel->getMasters());
        $this->setData('locations', $this->SessionModel->getLocations());
        $this->setTitle('Nueva sesión');
        return $this->loadView('master/newsession');
    }

    public function new_session_post() {
        $isNewAdventure = ($this->request->getVar('adventure') == '__new');
    
        $validation = \Config\Services::validation();
        $validation->setRule('adventure', 'aventura', 'trim|required');
        if ($isNewAdventure) {
            $validation->setRule('adventure_name', 'nombre', 'trim|required');
            $validation->setRule('adventure_rank', 'rango', 'trim');
            $validation->setRule('adventure_players_min_recommended', 'mínimo de jugadores recomendado', 'trim|required');
            $validation->setRule('adventure_players_max_recommended', 'máximo de jugadores recomendado', 'trim|required');
            $validation->setRule('adventure_duration', 'duración', 'trim|required');
            $validation->setRule('adventure_themes', 'temas', 'trim');
            $validation->setRule('adventure_description', 'descripción', 'trim|required');
            $validation->setRule('adventure_rewards', 'recompensas', 'trim');
            if ($_FILES['adventure_thumbnail']['name']) {
                $validation->setRule('adventure_thumbnail', 'imagen', 'uploaded[adventure_thumbnail]|mime_in[adventure_thumbnail,image/jpeg,image/png]|max_size[adventure_thumbnail,51200]');
            }
        }
        $validation->setRule('session_master', 'master', 'trim|required');
        $validation->setRule('session_date', 'fecha', 'trim|required');
        $validation->setRule('session_time', 'hora', 'trim|required');
        $validation->setRule('location', 'ubicación', 'trim|required');
        $validation->setRule('session_min_players', 'mínimo de jugadores', 'trim|required');
        $validation->setRule('session_max_players', 'máximo de jugadores', 'trim|required');

        if (!$validation->withRequest($this->request)->run()) {    
            session()->setFlashdata('error', 'Se ha producido un error al crear la sesión.');
            session()->setFlashdata('validation_errors', $validation->getErrors());
            return redirect()->back();
        }

        if ($isNewAdventure) {
            $adventureUid = uid_generate_unique('adventure');

            if ($_FILES['adventure_thumbnail']['name']) {
                $thumbnail = $this->request->getFile('adventure_thumbnail');
                $thumbnailExtension = pathinfo($thumbnail->getName(), PATHINFO_EXTENSION);
                $thumbnailName = "adv_$adventureUid.$thumbnailExtension";
                $thumbnail->move(ROOTPATH . 'public/img/adventures', $thumbnailName);
                upload_log('public/img/adventures', $thumbnailName);
            } else {
                $thumbnailName = NULL;
            }

            $this->AdventureModel->addAdventure([
                'uid' => $adventureUid,
                'name' => $this->request->getVar('adventure_name'),
                'rank' => $this->request->getVar('adventure_rank') ?: NULL,
                'players_min_recommended' => $this->request->getVar('adventure_players_min_recommended'),
                'players_max_recommended' => $this->request->getVar('adventure_players_max_recommended'),
                'duration' => $this->request->getVar('adventure_duration'),
                'themes' => $this->request->getVar('adventure_themes') ?: NULL,
                'description' => $this->request->getVar('adventure_description'),
                'rewards' => $this->request->getVar('adventure_rewards') ?: NULL,
                'thumbnail' => $thumbnailName,
            ]);
        } else {
            $adventureUid = $this->request->getVar('adventure');
        }

        $this->SessionModel->addSession([
            'uid' => uid_generate_unique('session'),
            'adventure_uid' => $adventureUid,
            'master_uid' => $this->request->getVar('session_master'),
            'date' => $this->request->getVar('session_date'),
            'time' => $this->request->getVar('session_time'),
            'location' => $this->request->getVar('location'),
            'players_min' => $this->request->getVar('session_min_players'),
            'players_max' => $this->request->getVar('session_max_players'),
        ]);

        session()->setFlashdata('success', 'Se ha creado una nueva sesión.');
        return redirect()->to('master/publish');
    }

    public function publish() {
        $this->setData('sessions', $this->SessionModel->getUnpublishedSessions());
        $this->setTitle('Publicar sesiones');
        return $this->loadView('master/publish');
    }

    public function publish_post() {
        $sessions = $this->request->getVar('session');
        $this->SessionModel->publishSessions($sessions);
        session()->setFlashdata('success', 'Se han publicado las sesiones seleccionadas.');
        return redirect()->to('master/publish');
    }

    public function kick($session_uid, $user_uid) {
        $this->SessionModel->deletePlayerSession($session_uid, $user_uid);
        session()->setFlashdata('success', 'Se han eliminado al jugador de la sesión.');
        return redirect()->to('master');
    }

}