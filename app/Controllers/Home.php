<?php
// LigaDeAventureros
// Copyright (C) 2023-2024 Santiago González Lago

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
        $this->UserModel = model('UserModel');
    }

    public function index() {
        setlocale(LC_TIME, 'es_ES');
        
        $sessions = [
            'today' => $this->SessionModel->getSessions(date('Y-m-d'), date('Y-m-d')),
            'upcoming' => $this->SessionModel->getSessions(date('Y-m-d', strtotime('tomorrow')), date('Y-m-d', strtotime('+20 days'))),
        ];

        foreach ($sessions as $session_block) {
            foreach ($session_block as $session) {
                $players = $this->SessionModel->getSessionPlayers($session->uid);

                $session->joined = false;
        
                foreach ($players as $player) {
                    if ($player->uid === session('user_uid')) {
                        $session->joined = $player->character_uid;
                    }

                    if (!$session->rank || $session->rank == rank_get($player->level)) {
                        $player->badge_color = 'success';
                    } else if ($session->rank > rank_get($player->level)) {
                        $player->badge_color = 'warning';
                    } else {
                        $player->badge_color = 'danger';
                    }
                }
    
                $session->players = [
                    'playing' => array_pad(array_slice($players, 0, $session->players_max), $session->players_max, NULL),
                    'waitlist' => array_slice($players, $session->players_max),
                ];
                $session->player_characters = $this->CharacterModel->getPlayerCharacters(session('user_uid'), true, $session->w_setting_id, true);
            }
        }

        $this->setData('sessions_today', $sessions['today']);
        $this->setData('sessions_upcoming', $sessions['upcoming']);
        $this->setData('characters', $this->CharacterModel->getPlayerCharacters(session('user_uid'), true));
        return $this->loadView('home');
    }

    public function privacy() {
        $this->setTitle('Política de privacidad');
        return $this->loadView('privacy');
    }

    public function contact() {
        $this->setTitle('Contacto');

        if ($this->isUserLoggedIn()) {
            $user = $this->UserModel->getUser($this->getUserData()['uid']);
            $this->setData('name', $user->display_name);
            $this->setData('email', $user->email);
        } else {
            $this->setData('name', NULL);
            $this->setData('email', NULL);
        }

        return $this->loadView('contact');       
    }


    public function contact_post() {
        $validation = \Config\Services::validation();
        $validation->setRule('name', 'nombre', 'trim|required');
        $validation->setRule('email', 'dirección de correo electrónico', 'trim|required|valid_email');
        $validation->setRule('subject', 'asunto', 'trim|required');
        $validation->setRule('msg', 'mensaje', 'trim|required');

        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('error', 'No se ha enviado el formulario de contacto.');
            session()->setFlashdata('validation_errors', $validation->getErrors());
            return redirect()->back();
        }

        $data = [
            'name'    => $this->request->getVar('name'),
            'email'   => $this->request->getVar('email'),
            'subject' => $this->request->getVar('subject'),
            'msg'     => $this->request->getVar('msg'),
            'main'    => 'emails/contact',
        ];

        $email = \Config\Services::email();
        $email->setTo(setting('contact_email'));
        $email->setFrom(setting('no_reply_email'), $data['name']);
        $email->setReplyTo($data['email'], $data['name']);
        $email->setSubject($data['subject']);
        $email->setMessage(view('emails/template', $data));
        $email->setMailType('html');
        $email->send();

        $this->setTitle('Contacto enviado');
        return $this->loadView('contact_sent');  
    }
}
