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

        $user_send_email = $this->EmailSettingModel->checkUserSetting($user_uid, 'confirmation_session_swap');
        $master_send_email = $this->EmailSettingModel->checkUserSetting($session->master_uid, 'master_player_swap');

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
            $data['main'] = 'emails/player_swap_session';
            $email->clear();

            $email->setTo($user->email);
            if (setting('bcc_email')) {
                $email->setBCC(setting('bcc_email'));
            }
            if ($master_email) {
                $email->setReplyTo($master->email, $master->display_name);
            }
            $email->setFrom(setting('no_reply_email'), setting('app_name'));
            $email->setSubject("Has cambiado tu personaje para la partida $adventure->name");
            $email->setMessage(view('emails/template', $data));
            $email->setMailType('html');
            $email->send();
        }

        if ($master_send_email) {
            $data['main'] = 'emails/player_swap_session_master';
            $email->clear();

            $email->setTo($master->email);
            if (setting('bcc_email')) {
                $email->setBCC(setting('bcc_email'));
            }
            $email->setFrom(setting('no_reply_email'), setting('app_name'));
            $email->setSubject("$user->display_name ha cambiado su personaje para tu partida $adventure->name");
            $email->setMessage(view('emails/template', $data));
            $email->setMailType('html');
            $email->send();
        }
    }

    public function player_cancel_session($user_uid, $session_uid) {
        $user = $this->UserModel->getUser($user_uid);
        $session = $this->SessionModel->getSession($session_uid);

        $user_send_email = $this->EmailSettingModel->checkUserSetting($user_uid, 'confirmation_session_cancel');
        $master_send_email = $this->EmailSettingModel->checkUserSetting($session->master_uid, 'master_player_cancel');

        $master = $this->UserModel->getUser($session->master_uid);
        $adventure = $this->AdventureModel->getAdventure($session->adventure_uid);
        $session_players = $this->SessionModel->getSessionPlayers($session_uid);
        if ($this->EmailSettingModel->checkUserSetting($session->master_uid, 'master_send_emails')) {
            $master_email = true;
        } else {
            $master_email = false;
        }

        $data = [
            'user'         => $user,
            'master'       => $master,
            'session'      => $session,
            'adventure'    => $adventure,
            'player_count' => count($session_players),
            'master_email' => $master_email,
        ];

        $email = \Config\Services::email();

        if ($user_send_email) {
            $data['main'] = 'emails/player_cancel_session';
            $email->clear();

            $email->setTo($user->email);
            if (setting('bcc_email')) {
                $email->setBCC(setting('bcc_email'));
            }
            if ($master_email) {
                $email->setReplyTo($master->email, $master->display_name);
            }
            $email->setFrom(setting('no_reply_email'), setting('app_name'));
            $email->setSubject("Has cancelado tu inscripción a la partida $adventure->name");
            $email->setMessage(view('emails/template', $data));
            $email->setMailType('html');
            $email->send();
        }

        if ($master_send_email) {
            $data['main'] = 'emails/player_cancel_session_master';
            $email->clear();

            $email->setTo($master->email);
            if (setting('bcc_email')) {
                $email->setBCC(setting('bcc_email'));
            }
            $email->setFrom(setting('no_reply_email'), setting('app_name'));
            $email->setSubject("$user->display_name ha cancelado su inscripción a tu partida $adventure->name");
            $email->setMessage(view('emails/template', $data));
            $email->setMailType('html');
            $email->send();
        }

        if ($session->players_max <= count($session_players)) {
            $next_user = $session_players[($session->players_max - 1)];
            $this->next_in_waitlist($next_user->uid, $session_uid, $next_user->character_uid);
        }
    }

    public function player_kicked_session($user_uid, $session_uid) {
        $user = $this->UserModel->getUser($user_uid);
        $session = $this->SessionModel->getSession($session_uid);

        $user_send_email = $this->EmailSettingModel->checkUserSetting($user_uid, 'notification_session_kicked');

        $master = $this->UserModel->getUser($session->master_uid);
        $adventure = $this->AdventureModel->getAdventure($session->adventure_uid);
        $session_players = $this->SessionModel->getSessionPlayers($session_uid);
        if ($this->EmailSettingModel->checkUserSetting($session->master_uid, 'master_send_emails')) {
            $master_email = true;
        } else {
            $master_email = false;
        }

        $data = [
            'user'         => $user,
            'master'       => $master,
            'session'      => $session,
            'adventure'    => $adventure,
            'player_count' => count($session_players),
            'master_email' => $master_email,
        ];

        $email = \Config\Services::email();

        if ($user_send_email) {
            $data['main'] = 'emails/player_kicked_session';
            $email->clear();

            $email->setTo($user->email);
            if (setting('bcc_email')) {
                $email->setBCC(setting('bcc_email'));
            }
            if ($master_email) {
                $email->setReplyTo($master->email, $master->display_name);
            }
            $email->setFrom(setting('no_reply_email'), setting('app_name'));
            $email->setSubject("Has sido expulsado de la partida $adventure->name");
            $email->setMessage(view('emails/template', $data));
            $email->setMailType('html');
            $email->send();
        }

        if ($session->players_max <= count($session_players)) {
            $next_user = $session_players[($session->players_max - 1)];
            $this->next_in_waitlist($next_user->uid, $session_uid, $next_user->character_uid);
        }
    }

    private function next_in_waitlist($user_uid, $session_uid, $character_uid) {
        $user = $this->UserModel->getUser($user_uid);
        $session = $this->SessionModel->getSession($session_uid);
    
        $user_send_email = $this->EmailSettingModel->checkUserSetting($user_uid, 'notification_session_waitlist');

        if (!$user_send_email) {
            return;
        }

        $master = $this->UserModel->getUser($session->master_uid);
        $adventure = $this->AdventureModel->getAdventure($session->adventure_uid);
        $character = $this->CharacterModel->getCharacter($character_uid);
        if ($this->EmailSettingModel->checkUserSetting($session->master_uid, 'master_send_emails')) {
            $master_email = true;
        } else {
            $master_email = false;
        }

        $data = [
            'user'         => $user,
            'master'       => $master,
            'session'      => $session,
            'adventure'    => $adventure,
            'character'    => $character,
            'master_email' => $master_email,
        ];

        $email = \Config\Services::email();

        $data['main'] = 'emails/next_in_waitlist';
        $email->clear();

        $email->setTo($user->email);
        if (setting('bcc_email')) {
            $email->setBCC(setting('bcc_email'));
        }
        if ($master_email) {
            $email->setReplyTo($master->email, $master->display_name);
        }
        $email->setFrom(setting('no_reply_email'), setting('app_name'));
        $email->setSubject("Hay espacio para ti en la partida $adventure->name");
        $email->setMessage(view('emails/template', $data));
        $email->setMailType('html');
        $email->send();
    }

    public function session_updated($session_uid) {
        $session = $this->SessionModel->getSession($session_uid);
        $adventure = $this->AdventureModel->getAdventure($session->adventure_uid);
        $master = $this->UserModel->getUser($session->master_uid);
        $session_players = $this->SessionModel->getSessionPlayers($session_uid);
        if ($this->EmailSettingModel->checkUserSetting($session->master_uid, 'master_send_emails')) {
            $master_email = true;
        } else {
            $master_email = false;
        }

        $data = [
            'session'      => $session,
            'adventure'    => $adventure,
            'player_count' => count($session_players),
            'master'       => $master,
            'master_email' => $master_email,
        ];

        $email = \Config\Services::email();

        $users = $this->SessionModel->getSessionPlayers($session_uid);
        foreach ($users as $user) {
            if ($this->EmailSettingModel->checkUserSetting($user->uid, 'notification_session_modified')) {
                $data['user'] = $this->UserModel->getUser($user->uid);
                $data['character'] = $this->CharacterModel->getCharacter($user->character_uid);
                if ($session->players_max >= count($session_players)) {
                    $data['waitlist'] = false;
                } else {
                    $data['waitlist'] = true;
                    for ($i = 0; $i < $session->players_max; $i++) {
                        if ($session_players[$i]->uid == $user->uid) {
                            $data['waitlist'] = false;
                            break;
                        }
                    }
                }

                $data['main'] = 'emails/session_updated';
                $email->clear();
    
                $email->setTo($data['user']->email);
                if (setting('bcc_email')) {
                    $email->setBCC(setting('bcc_email'));
                }
                if ($master_email) {
                    $email->setReplyTo($master->email, $master->display_name);
                }
                $email->setFrom(setting('no_reply_email'), setting('app_name'));
                $email->setSubject("La partida $adventure->name ha sido modificada");
                $email->setMessage(view('emails/template', $data));
                $email->setMailType('html');
                $email->send();
            }
        }
    }

    public function session_canceled($session_uid) {
        $session = $this->SessionModel->getSession($session_uid);
        $adventure = $this->AdventureModel->getAdventure($session->adventure_uid);
        $master = $this->UserModel->getUser($session->master_uid);
        $session_players = $this->SessionModel->getSessionPlayers($session_uid);
        if ($this->EmailSettingModel->checkUserSetting($session->master_uid, 'master_send_emails')) {
            $master_email = true;
        } else {
            $master_email = false;
        }

        $data = [
            'session'      => $session,
            'adventure'    => $adventure,
            'player_count' => count($session_players),
            'master'       => $master,
            'master_email' => $master_email,
        ];

        $email = \Config\Services::email();

        $users = $this->SessionModel->getSessionPlayers($session_uid);
        foreach ($users as $user) {
            if ($this->EmailSettingModel->checkUserSetting($user->uid, 'notification_session_canceled')) {
                $data['user'] = $this->UserModel->getUser($user->uid);
                $data['character'] = $this->CharacterModel->getCharacter($user->character_uid);

                $data['main'] = 'emails/session_canceled';
                $email->clear();
    
                $email->setTo($data['user']->email);
                if (setting('bcc_email')) {
                    $email->setBCC(setting('bcc_email'));
                }
                if ($master_email) {
                    $email->setReplyTo($master->email, $master->display_name);
                }
                $email->setFrom(setting('no_reply_email'), setting('app_name'));
                $email->setSubject("La partida $adventure->name ha sido cancelada");
                $email->setMessage(view('emails/template', $data));
                $email->setMailType('html');
                $email->send();
            }
        }
    }

}