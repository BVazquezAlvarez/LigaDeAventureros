<?php
// LigaDeAventureros
// Copyright (C) 2024 Santiago González Lago

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

class Character extends BaseController {

    public function __construct() {
        $this->UserModel = model('UserModel');
        $this->EmailSettingModel = model('EmailSettingModel');
        $this->CharacterModel = model('CharacterModel');
    }

    public function index($uid) {
        $character = $this->CharacterModel->getCharacter($uid);

        if (!$character) {
            session()->setFlashdata('error', 'No se ha encontrado el personaje.');
            return redirect()->to(base_url());
        }

        $player = $this->UserModel->getUser($character->user_uid);

        $this->setData('character', $character);
        $this->setData('player', $player);
        $this->setData('isOwner', $player->uid == session('user_uid'));

        $this->setTitle($character->name);
        return $this->loadView('character/view');
    }

    public function all_characters() {
        $characters = $this->CharacterModel->getAllActiveCharacters();
        $total = $this->CharacterModel->countAllActiveCharacters();;

        $this->setData('characters',$characters);
        $this->setData('total',$total);

        $this->setTitle('Todos los personajes');
        return $this->loadView('character/all_characters');
    }

    public function new_character() {
        $validation = \Config\Services::validation();
        $validation->setRule('name', 'nombre', 'trim|required');
        $validation->setRule('class', 'clase', 'trim|required');
        $validation->setRule('level', 'Nivel', 'trim|required|greater_than_equal_to[1]|less_than_equal_to[20]');
        $validation->setRule('character_sheet', 'Hoja de personaje', 'uploaded[character_sheet]|ext_in[character_sheet,pdf]|max_size[character_sheet,5120]');

        if ($validation->withRequest($this->request)->run()) {
            $uid = uid_generate_unique('player_character');
            $data = array(
                'uid'            => $uid,
                'user_uid'       => session('user_uid'),
                'name'           => $this->request->getVar('name'),
                'class'          => $this->request->getVar('class'),
                'level'          => $this->request->getVar('level'),
                'uploaded_sheet' => $uid . '_' . $this->request->getVar('level') . '_' . date('YmdHis') . '.pdf',
                'date_uploaded'  => date('c'),
                'active'         => 1,
            );

            $characterSheet = $this->request->getFile('character_sheet');
            $characterSheet->move(ROOTPATH . 'public/character_sheets', $data['uploaded_sheet']);
            upload_log('public/character_sheets', $data['uploaded_sheet']);

            $this->CharacterModel->addCharacter($data);
            session()->setFlashdata('success', 'Personaje creado correctamente.');
            return redirect()->to('profile/'.session('user_uid'));
        } else {
            session()->setFlashdata('error', 'No se ha podido crear el personaje.');
            session()->setFlashdata('validation_errors', $validation->getErrors());
            return redirect()->back();
        }
    }

    public function update_character() {
        $uid = $this->request->getVar('uid');
        $character = $this->CharacterModel->getCharacter($uid);

        if (!$character) {
            session()->setFlashdata('error', 'No se ha encontrado el personaje.');
            return redirect()->back();
        }

        if ($character->user_uid != session('user_uid') && !$userdata['admin']) {
            session()->setFlashdata('error', 'Ese personaje no te pertenece.');
            return redirect()->back();
        }

        $validation = \Config\Services::validation();
        $validation->setRule('name', 'nombre', 'trim|required');
        $validation->setRule('class', 'clase', 'trim|required');
        $validation->setRule('level', 'Nivel', 'trim|required|greater_than_equal_to[1]|less_than_equal_to[20]');

        if (!$validation->withRequest($this->request)->run()) {    
            session()->setFlashdata('error', 'No se ha podido actualizar el personaje.');
            session()->setFlashdata('validation_errors', $validation->getErrors());
            return redirect()->back();
        }
    
        $data = array(
            'name'           => $this->request->getVar('name'),
            'class'          => $this->request->getVar('class'),
            'level'          => $this->request->getVar('level'),
            'date_uploaded'  => date('c'),
            'active'         => 1,
            'wiki'           => $this->request->getVar('wiki'),
            'description'    => $this->request->getVar('description'),
        );

        if ($this->request->getFile('character_sheet')->isValid() && $this->request->getFile('character_sheet')->getSize() > 0) {
            $characterSheet = $this->request->getFile('character_sheet');
            $data['uploaded_sheet'] = $uid . '_' . $this->request->getVar('level') . '_' . date('YmdHis') . '.pdf';
            $characterSheet->move(ROOTPATH . 'public/character_sheets', $data['uploaded_sheet']);
            upload_log('public/character_sheets', $data['uploaded_sheet']);
        }

        if ($this->request->getVar('delete_image')) {
            $data['image'] = NULL;
        } else if ($this->request->getFile('character_image')->isValid() && $this->request->getFile('character_image')->getSize() > 0) {
            $characterImg = $this->request->getFile('character_image');
            $extension = pathinfo($characterImg->getName(), PATHINFO_EXTENSION);
            $data['image'] = "$uid.$extension";
            $characterImg->move(ROOTPATH . 'public/img/characters', $data['image']);
            upload_log('public/img/characters', $data['image']);
        }

        $this->CharacterModel->updateCharacter($uid, $data);
        session()->setFlashdata('success', 'Se ha actualizado el personaje ' . $data['name'] . '.');
        return redirect()->to('character/'.$uid);
    }

    public function enable($uid) {
        $character = $this->CharacterModel->getCharacter($uid);

        if (!$character) {
            session()->setFlashdata('error', 'No se ha encontrado el personaje.');
            return redirect()->back();
        }

        if ($character->user_uid != session('user_uid') && !$userdata['admin']) {
            session()->setFlashdata('error', 'Ese personaje no te pertenece.');
            return redirect()->back();
        }

        $data = array(
            'active' => 1,
        );
        $this->CharacterModel->updateCharacter($uid, $data);
        session()->setFlashdata('success', 'Se ha reactivado el personaje.');
        return redirect()->to('character/'.$uid);
    }

    public function disable($uid) {
        $character = $this->CharacterModel->getCharacter($uid);

        if (!$character) {
            session()->setFlashdata('error', 'No se ha encontrado el personaje.');
            return redirect()->back();
        }

        if ($character->user_uid != session('user_uid') && !$userdata['admin']) {
            session()->setFlashdata('error', 'Ese personaje no te pertenece.');
            return redirect()->back();
        }

        $data = array(
            'active' => 0,
        );
        $this->CharacterModel->updateCharacter($uid, $data);
        session()->setFlashdata('success', 'Se ha desactivado el personaje.');
        return redirect()->to('character/'.$uid);
    }

    public function delete() {
        $uid = $this->request->getVar('uid');
        $character = $this->CharacterModel->getCharacter($uid);

        if (!$character) {
            session()->setFlashdata('error', 'No se ha encontrado el personaje.');
            return redirect()->back();
        }

        if ($character->user_uid != session('user_uid') && !$userdata['admin']) {
            session()->setFlashdata('error', 'Ese personaje no te pertenece.');
            return redirect()->back();
        }

        $this->CharacterModel->deleteCharacter($uid);
        return redirect()->to('profile');
    }

}