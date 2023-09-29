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

class Login extends BaseController {

    public function __construct() {
        $this->UserModel = model('UserModel');
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

        return redirect()->to('/');
    }

    public function logout() {
        session()->destroy();
		return redirect()->to('/');
    }

}
