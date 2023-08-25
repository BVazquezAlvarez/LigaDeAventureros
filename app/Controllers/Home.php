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

class Home extends BaseController {

    public function __construct() {
        $this->CharacterModel = model('CharacterModel');
        $this->SessionModel = model('SessionModel');
    }

    public function index() {
        setlocale(LC_TIME, 'es_ES');
        $mondayThisWeek = date('c', strtotime('this week monday'));
        $sundayThisWeek = date('c', strtotime('this week sunday'));
        $mondayNextWeek = date('c', strtotime('next week monday'));
        $sundayNextWeek = date('c', strtotime('next week sunday'));
        
        $sessions = [
            'this_week' => $this->SessionModel->getSessions($mondayThisWeek, $sundayThisWeek),
            'next_week' => $this->SessionModel->getSessions($mondayNextWeek, $sundayNextWeek),
        ];

        foreach ($sessions as $week) {
            foreach ($week as $session) {
                $players = $this->SessionModel->getSessionPlayers($session->uid);

                $session->joined = false;
        
                foreach ($players as $player) {
                    if ($player->uid === session('user_uid')) {
                        $session->joined = $player->character_uid;
                        break;
                    }
                }
    
                $session->players = [
                    'playing' => array_pad(array_slice($players, 0, $session->players_max), $session->players_max, NULL),
                    'waitlist' => array_slice($players, $session->players_max),
                ];

                foreach ($session->players['playing'] as $player) {
                    if (!$player) {
                        break;
                    }
                    if (!$session->rank || $session->rank == rank_get($player->level)) {
                        $player->badge_color = 'success';
                    } else if ($session->rank > rank_get($player->level)) {
                        $player->badge_color = 'warning';
                    } else {
                        $player->badge_color = 'danger';
                    }
                }
            }
        }

        $this->setData('sessions_this_week', $sessions['this_week']);
        $this->setData('sessions_next_week', $sessions['next_week']);
        $this->setData('characters', $this->CharacterModel->getPlayerCharacters(session('user_uid')));
        return $this->loadView('home');
    }

}
