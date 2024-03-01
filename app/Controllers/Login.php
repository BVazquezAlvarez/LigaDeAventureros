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

use Google_Client;
use Google_Service_Oauth2;

class Login extends BaseController {

    public function __construct() {
        $this->UserModel = model('UserModel');
    }

    public function login() {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $this->UserModel->getUserByEmail($email);

        if ($user && $user->password && password_verify($password, $user->password)) {
            $this->_process_login($user);
        } else {
            session()->setFlashdata('error', 'El usuario introducido no existe o la contraseña no es correcta.');
            session()->set(['email_login' => $email]);
        }

        return redirect()->to('/');
    }

    public function google() {
        $client = new Google_Client();
        $client->setClientId(setting('google_client_id'));
        $client->setClientSecret(setting('google_secret'));

        $client->setRedirectUri(base_url('login/google'));
        $client->setScopes('email profile');

        if (!$this->request->getGet('code')) { 
            return redirect()->to($client->createAuthUrl());
        } else {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token['access_token']);

            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();
            $email =  $google_account_info->email;

            $user = $this->UserModel->getUserByEmail($email);
            if (!$user) {
                $this->UserModel->addUser([
                    'uid' => uid_generate_unique('user'),
                    'email' => $email,
                    'display_name' => $google_account_info->givenName,
                ]);
                $user = $this->UserModel->getUserByEmail($email);
            }
            $this->_process_login($user);

            return redirect()->to('/');
        }
    }

    public function onetap() {
        if ($_COOKIE['g_csrf_token'] !== $this->request->getPost('g_csrf_token')) {
            // Invalid CSRF token
            return back();
        }
        
        $idToken = $this->request->getPost('credential'); 
            
        $client = new Google_Client([
            'client_id' => setting('google_client_id')
        ]);
        
        $payload = $client->verifyIdToken($idToken);

        if ($payload) {
            $email = $payload['email'];
            $user = $this->UserModel->getUserByEmail($email);
            if (!$user) {
                $this->UserModel->addUser([
                    'uid' => uid_generate_unique('user'),
                    'email' => $email,
                    'display_name' => $payload['given_name'],
                ]);
                $user = $this->UserModel->getUserByEmail($email);
            }
            $this->_process_login($user);
        }

        return redirect()->to('/');
    }

    private function _process_login($user) {
        if ($user->banned) {
            session()->setFlashdata('error', 'El usuario con el que intenta iniciar sesión ha sido bloqueado. Si cree que se trata de un error, póngase en contacto con los administradores.');
        } else {
            session()->set(['user_uid' => $user->uid]);
        }
        if ($user->delete_on) {
            $this->UserModel->updateUser($user->uid, [
                'delete_on' => NULL,
            ]);
        }
    }

    public function logout() {
        session()->destroy();
		return redirect()->to('/');
    }

    public function return_to_real_user() {
        if (session('real_user')) {
            session()->set(['user_uid' => session('real_user')['uid']]);
            session()->remove('real_user');
        }
		return redirect()->to('/');
    }

}
