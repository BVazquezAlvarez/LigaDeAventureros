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

namespace App\Libraries;

class MyEmail {

    public function __construct() {
        $this->EmailSettingModel = model('EmailSettingModel');
        $this->UserModel = model('UserModel');
        $this->CharacterModel = model('CharacterModel');
        $this->SessionModel = model('SessionModel');
        $this->AdventureModel = model('AdventureModel');
    }

    public function confirm_registration($user_uid) {
        $user = $this->UserModel->getUser($user_uid);

        $data = array(
            'main'  => 'emails/confirm_registration',
            'user'  => $user,
        );

        $email = \Config\Services::email();
    
        $email->setTo($user->email);
        if (setting('bcc_email')) {
            $email->setBCC(setting('bcc_email'));
        }
        $email->setFrom(setting('no_reply_email'), setting('app_name'));
        $email->setSubject('Te has registrado con éxito en ' . setting('app_name'));
        $email->setMessage(view('emails/template', $data));
        $email->setMailType('html');

        if ($email->send()) {
            return true;
        } else {
            return false;
        }
    }

    public function confirm_delete_account($user_uid) {
        $user = $this->UserModel->getUser($user_uid);

        $data = array(
            'main'  => 'emails/confirm_delete_account',
            'user'  => $user,
        );

        $email = \Config\Services::email();
    
        $email->setTo($user->email);
        if (setting('bcc_email')) {
            $email->setBCC(setting('bcc_email'));
        }
        $email->setFrom(setting('no_reply_email'), setting('app_name'));
        $email->setSubject('Has solicitado que se borre tu cuenta en ' . setting('app_name'));
        $email->setMessage(view('emails/template', $data));
        $email->setMailType('html');

        if ($email->send()) {
            return true;
        } else {
            return false;
        }
    }

    public function notify_cancel_deletion($user_uid) {
        $user = $this->UserModel->getUser($user_uid);

        $data = array(
            'main'  => 'emails/notify_cancel_deletion',
            'user'  => $user,
        );

        $email = \Config\Services::email();
    
        $email->setTo($user->email);
        if (setting('bcc_email')) {
            $email->setBCC(setting('bcc_email'));
        }
        $email->setFrom(setting('no_reply_email'), setting('app_name'));
        $email->setSubject('Se ha cancelado el borrado de cuenta en ' . setting('app_name'));
        $email->setMessage(view('emails/template', $data));
        $email->setMailType('html');

        if ($email->send()) {
            return true;
        } else {
            return false;
        }
    }

    public function player_join_session($user_uid, $session_uid, $character_uid) {
        $user = $this->UserModel->getUser($user_uid);
        $session = $this->SessionModel->getSession($session_uid);

        $user_send_email = $this->EmailSettingModel->checkUserSetting($user_uid, 'confirmation_session_join');
        $master_send_email = $this->EmailSettingModel->checkUserSetting($session->master_uid, 'master_player_join');

        if (!$user_send_email && !$master_send_email) {
            return;
        }

        $master = $this->UserModel->getUser($session->master_uid);
        $adventure = $this->AdventureModel->getAdventure($session->adventure_uid);
        $session_players = $this->SessionModel->getSessionPlayers($session_uid);
        $character = $this->CharacterModel->getCharacter($character_uid);
        if ($this->EmailSettingModel->checkUserSetting($session->master_uid, 'master_send_emails')) {
            $master_email = true;
        } else {
            $master_email = false;
        }

        if ($session->players_max >= count($session_players)) {
            $waitlist = false;
        } else {
            $waitlist = true;
            for ($i = 0; $i < $session->players_max; $i++) {
                if ($session_players[$i]->uid == $user->uid) {
                    $waitlist = false;
                    break;
                }
            }
        }

        $data = [
            'user'         => $user,
            'master'       => $master,
            'session'      => $session,
            'adventure'    => $adventure,
            'character'    => $character,
            'player_count' => count($session_players),
            'master_email' => $master_email,
            'waitlist'     => $waitlist,
        ];

        $email = \Config\Services::email();

        if ($user_send_email) {
            $data['main'] = 'emails/player_join_session';
            $email->clear();

            $email->setTo($user->email);
            if (setting('bcc_email')) {
                $email->setBCC(setting('bcc_email'));
            }
            if ($master_email) {
                $email->setReplyTo($master->email, $master->display_name);
            }
            $email->setFrom(setting('no_reply_email'), setting('app_name'));
            $email->setSubject("Se ha confirmando tu inscripción en la partida $adventure->name");
            $email->setMessage(view('emails/template', $data));
            $email->setMailType('html');
            $email->send();
        }

        if ($master_send_email) {
            $data['main'] = 'emails/player_join_session_master';
            $email->clear();

            $email->setTo($master->email);
            if (setting('bcc_email')) {
                $email->setBCC(setting('bcc_email'));
            }
            $email->setFrom(setting('no_reply_email'), setting('app_name'));
            $email->setSubject("$user->display_name se ha anotado a tu partida $adventure->name");
            $email->setMessage(view('emails/template', $data));
            $email->setMailType('html');
            $email->send();
        }
    }

    public function player_swap_session($user_uid, $session_uid, $character_uid) {
        $user = $this->UserModel->getUser($user_uid);
        $session = $this->SessionModel->getSession($session_uid);
        $adventure = $this->AdventureModel->getAdventure($session->adventure_uid);
        $character = $this->CharacterModel->getCharacter($uid);
        if ($this->EmailSettingModel->checkUserSetting($session->master_uid, 'master_send_emails')) {
            $master_email = $this->UserModel->getUser($session->master_uid)->email;
        } else {
            $master_email = false;
        }

        $data = [
            'user'      => $user,
            'session'   => $session,
            'adventure' => $adventure,
            'character' => $character,
        ];

        if ($this->EmailSettingModel->checkUserSetting($user_uid, 'confirmation_session_swap')) {
            // TODO Enviar a jugador
        }

        if ($this->EmailSettingModel->checkUserSetting($session->master_uid, 'master_player_swap')) {
            // TODO Enviar a master
        }
    }

    public function player_cancel_session($user_uid, $session_uid) {
        $user = $this->UserModel->getUser($user_uid);
        $session = $this->SessionModel->getSession($session_uid);
        $adventure = $this->AdventureModel->getAdventure($session->adventure_uid);
        if ($this->EmailSettingModel->checkUserSetting($session->master_uid, 'master_send_emails')) {
            $master_email = $this->UserModel->getUser($session->master_uid)->email;
        } else {
            $master_email = false;
        }

        $data = [
            'user'      => $user,
            'session'   => $session,
            'adventure' => $adventure,
        ];

        if ($this->EmailSettingModel->checkUserSetting($user_uid, 'confirmation_session_cancel')) {
            // TODO Enviar a jugador
        }

        if ($this->EmailSettingModel->checkUserSetting($session->master_uid, 'master_player_cancel')) {
            // TODO Enviar a master
        }

        // TODO Buscar jugador que abandona lista de espera y enviarle email
    }

    public function player_kicked_session($user_uid, $session_uid) {
        $user = $this->UserModel->getUser($user_uid);
        $session = $this->SessionModel->getSession($session_uid);
        $adventure = $this->AdventureModel->getAdventure($session->adventure_uid);
        if ($this->EmailSettingModel->checkUserSetting($session->master_uid, 'master_send_emails')) {
            $master_email = $this->UserModel->getUser($session->master_uid)->email;
        } else {
            $master_email = false;
        }

        $data = [
            'user'      => $user,
            'session'   => $session,
            'adventure' => $adventure,
        ];

        if ($this->EmailSettingModel->checkUserSetting($user_uid, 'notification_session_kicked')) {
            // TODO Enviar a jugador
        }

        // TODO Buscar jugador que abandona lista de espera y enviarle email
    }

    public function session_updated($session_uid) {
        $session = $this->SessionModel->getSession($session_uid);
        $adventure = $this->AdventureModel->getAdventure($session->adventure_uid);
        if ($this->EmailSettingModel->checkUserSetting($session->master_uid, 'master_send_emails')) {
            $master_email = $this->UserModel->getUser($session->master_uid)->email;
        } else {
            $master_email = false;
        }

        $data = [
            'session'   => $session,
            'adventure' => $adventure,
        ];

        $users = $this->SessionModel->getSessionPlayers($session_uid);
        foreach ($users as $user) {
            if ($this->EmailSettingModel->checkUserSetting($user->uid, 'notification_session_modified')) {
                $data['user'] = $user;
                // TODO Enviar a jugador
            }
        }
    }

    public function session_canceled($session_uid) {
        $session = $this->SessionModel->getSession($session_uid);
        $adventure = $this->AdventureModel->getAdventure($session->adventure_uid);
        if ($this->EmailSettingModel->checkUserSetting($session->master_uid, 'master_send_emails')) {
            $master_email = $this->UserModel->getUser($session->master_uid)->email;
        } else {
            $master_email = false;
        }

        $data = [
            'session'   => $session,
            'adventure' => $adventure,
        ];

        $users = $this->SessionModel->getSessionPlayers($session_uid);
        foreach ($users as $user) {
            if ($this->EmailSettingModel->checkUserSetting($user->uid, 'notification_session_canceled')) {
                $data['user'] = $user;
                // TODO Enviar a jugador
            }
        }
    }

}