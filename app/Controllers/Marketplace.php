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

class Marketplace extends BaseController {

    public function __construct() {
        if (!$this->isUserLoggedIn() || !$this->getUserData()['confirmed']) {
            session()->setFlashdata('error', 'Necesitas iniciar sesión y ser verificado para acceder a los mercaderes.');
            header("Location: /");
            exit();
        }
        $this->MerchantModel = model('MerchantModel');
        $this->CharacterModel = model('CharacterModel');
        $this->ItemModel = model('ItemModel');
    }

    public function index() {
        $characters = $this->CharacterModel->getPlayerCharacters(session('user_uid'), true);
        if (!$characters) {
            session()->setFlashdata('error', 'Necesitas crear un personaje para acceder a los mercaderes.');
            return redirect()->to('/');
        }

        $active_character = $characters[0];
        $active_character_uid = session()->get('marketplace_active_character');
        if ($active_character_uid) {
            foreach ($characters as $char) {
                if ($char->uid == $active_character_uid) {
                    $active_character = $char;
                    break;
                }
            }
        }

        $merchants = $this->MerchantModel->getMerchants(NULL, NULL, true);
        foreach ($merchants as $m) {
            $m->items = $this->MerchantModel->getMerchantItems($m->id);
        }

        $this->setData('my_characters', $characters);
        $this->setData('active_character', $active_character);
        $this->setData('merchants', $merchants);
        $this->setTitle('Mercaderes');
        return $this->loadView('marketplace/marketplace');
    }

    public function change_active_character() {
        $active = $this->request->getVar('active');
        session()->set(['marketplace_active_character' => $active]);
        echo '1';
    }

    public function buy() {
        $character_uid = $this->request->getVar('character_uid');
        $item_id = $this->request->getVar('item_id');
        $merchant_id = $this->request->getVar('merchant_id');

        $character = $this->CharacterModel->getCharacter($character_uid);
        $item = $this->ItemModel->getItem($item_id);
        $merchant = $this->MerchantModel->getMerchant($merchant_id);

        if ($character->treasure_points >= $item->cost && $this->MerchantModel->checkMerchantHasItem($item_id, $merchant_id)) {
            $this->CharacterModel->updateCharacter($character_uid, array(
                'treasure_points' => $character->treasure_points - $item->cost
            ));

            $items[] = array(
                'player_character_uid' => $character_uid,
                'item_id' => $item_id
            );
            $this->CharacterModel->addItems($items);

            $item_name = $item->name;
            $item_cost = $item->cost;
            $merchant_name = $merchant->name;
            $note = "Compra $item_name al mercader $merchant_name por $item_cost PTs";
            $this->CharacterModel->createLogsheetEntry($character_uid, NULL, NULL, $note);

            session()->setFlashdata('success', "Se ha comprado $item_name.");
            return redirect()->to("character/$character_uid");
        } else {
            session()->setFlashdata('error', 'No se ha podido finalizar la transacción.');
            return redirect()->to('marketplace');
        }
    }

}