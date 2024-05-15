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

class Admin extends BaseController {

    public function __construct() {
        if (!$this->isAdmin()) {
            header("Location: /");
            exit();
        }
        $this->UserModel = model('UserModel');
        $this->UploadLogModel = model('UploadLogModel');
        $this->MerchantModel = model('MerchantModel');
        $this->AutomaticMerchantModel = model('AutomaticMerchantModel');
        $this->ItemModel = model('ItemModel');
    }

    protected function setTitle(string $title) {
        parent::setTitle($title . ' - Área de administración');
    }

    public function index() {
        $this->setData('users_confirmed', $this->UserModel->getTotalUsersConfirmed());
        $this->setData('users_unconfirmed', $this->UserModel->getTotalUsersUnconfirmed());
        $this->setData('users_banned', $this->UserModel->getTotalUsersBanned());
        $this->setData('logs', $this->UploadLogModel->getTotalLogs());
        $this->setTitle('Panel de control');
        return $this->loadView('admin/index');
    }

    public function users($page = 1) {
        $limit = 20;
        $start = $limit * ($page - 1);

        $q = $this->request->getGet('q');

        $users = $this->UserModel->getUsers($start, $limit, $q);
        $total = $this->UserModel->getTotalUsers($q);

        $pager = service('pager');
        $pagination = $pager->makeLinks($page, $limit, $total, 'liga', 3);

        $this->setData('users',$users);
        $this->setData('total',$total);
        $this->setData('q',$q);
        $this->setData('pagination',$pagination);
        $this->setTitle('Administrar usuarios');
        return $this->loadView('admin/users');
    }

    public function user_login($uid) {
        if (session('real_user')) {
            if (session('real_user')['uid'] == $uid) {
                session()->set(['user_uid' => $uid]);
                session()->remove('real_user');
            } else {
                session()->set(['user_uid' => $uid]);
            }
        } else {
            session()->set([
                'user_uid' => $uid,
                'real_user' => $this->getUserData(),
            ]);
        }
        return redirect()->to('/');
    }

    public function user_toggle_master() {
        $uid = $this->request->getVar('uid');
        $data = [
            'master' => $this->request->getVar('master'),
        ];
        $this->UserModel->updateUser($uid, $data);
        return redirect()->back();
    }

    public function user_toggle_admin() {
        $uid = $this->request->getVar('uid');
        $data = [
            'admin' => $this->request->getVar('admin'),
        ];
        $this->UserModel->updateUser($uid, $data);
        return redirect()->back();
    }

    public function user_ban() {
        $uid = $this->request->getVar('uid');
        $data = [
            'master' => 0,
            'admin' => 0,
            'banned' => 1,
        ];
        $this->UserModel->updateUser($uid, $data);
        return redirect()->back();
    }

    public function user_unban() {
        $uid = $this->request->getVar('uid');
        $data = [
            'banned' => 0,
        ];
        $this->UserModel->updateUser($uid, $data);
        return redirect()->back();
    }

    public function logs($page = 1) {
        $limit = 20;
        $start = $limit * ($page - 1);

        $logs = $this->UploadLogModel->getLogs($start, $limit);
        foreach ($logs as $log) {
            $filePath = ROOTPATH . $log->directory . '/' . $log->file;
            $log->is_deleted = !file_exists($filePath);
            $log->base_url = str_replace("public/", "", $log->directory);
        }
        $total = $this->UploadLogModel->getTotalLogs();

        $pager = service('pager');
        $pagination = $pager->makeLinks($page, $limit, $total, 'liga', 3);

        $this->setData('logs',$logs);
        $this->setData('total',$total);
        $this->setData('pagination',$pagination);
        $this->setTitle('Logs de subidas de ficheros');
        return $this->loadView('admin/logs');
    }

    public function settings() {
        $this->setData('settings', setting_all());
        $this->setTitle('Configuraciones del servidor');
        return $this->loadView('admin/settings');
    }

    public function settings_post() {
        $id = $this->request->getVar('id');
        $value = $this->request->getVar('value');
        setting_update($id, $value);

        session()->setFlashdata('success', "Se ha actualizado la configuración $id.");
        return redirect()->to('admin/settings');
    }

    public function merchants($page = 1) {
        $limit = 20;
        $start = $limit * ($page - 1);

        $merchants = $this->MerchantModel->getMerchants($start, $limit);
        $total = $this->MerchantModel->getTotalMerchants();

        $pager = service('pager');
        $pagination = $pager->makeLinks($page, $limit, $total, 'liga', 3);

        $this->setData('merchants', $merchants);
        $this->setData('total', $total);
        $this->setData('pagination',$pagination);
        $this->setTitle('Administrar mercaderes');
        return $this->loadView('admin/merchants');
    }

    public function new_merchant() {
        $validation = \Config\Services::validation();
        $permanent = $this->request->getVar('permanent') ? 1 : 0;
        $validation->setRule('name', 'nombre', 'trim|required');
        if (!$permanent) {
            $validation->setRule('timestamp_start', 'inicio', 'trim|required|valid_date');
            $validation->setRule('timestamp_end', 'fin', 'trim|required|valid_date');
        }

        if ($validation->withRequest($this->request)->run()) {
            $data = array(
                'name' => $this->request->getVar('name'),
                'permanent' => $permanent,
                'timestamp_start' => $permanent ? NULL : $this->request->getVar('timestamp_start'),
                'timestamp_end' => $permanent ? NULL : $this->request->getVar('timestamp_end'),
            );
            $merchant_id = $this->MerchantModel->addMerchant($data);
            session()->setFlashdata('success', 'Mercader creado correctamente.');
            return redirect()->to('admin/edit-merchant/'.$merchant_id);
        } else {
            session()->setFlashdata('error', 'No se ha podido crear el mercader.');
            session()->setFlashdata('validation_errors', $validation->getErrors());
            return redirect()->back();
        }
    }

    public function edit_merchant($id) {
        $merchant = $this->MerchantModel->getMerchant($id);
        $this->setData('merchant', $merchant);
        $this->setData('all_items', $this->ItemModel->getItems());
        $this->setData('merchant_items', $this->MerchantModel->getMerchantItems($id));
        $this->setTitle('Editar mercader ' . $merchant->name);
        return $this->loadView('admin/edit_merchant');
    }

    public function edit_merchant_post($id) {
        $validation = \Config\Services::validation();
        $permanent = $this->request->getVar('permanent') ? 1 : 0;
        $validation->setRule('name', 'nombre', 'trim|required');
        if (!$permanent) {
            $validation->setRule('timestamp_start', 'inicio', 'trim|required|valid_date');
            $validation->setRule('timestamp_end', 'fin', 'trim|required|valid_date');
        }

        if ($validation->withRequest($this->request)->run()) {
            $data = array(
                'name' => $this->request->getVar('name'),
                'permanent' => $permanent,
                'timestamp_start' => $permanent ? NULL : $this->request->getVar('timestamp_start'),
                'timestamp_end' => $permanent ? NULL : $this->request->getVar('timestamp_end'),
            );
            if ($permanent) {
                $data['automatic_merchant_id'] = NULL;
            }
            $merchant_id = $this->MerchantModel->updateMerchant($id, $data);

            $add_items = $this->request->getVar('add_items') ?? array();
            if ($add_items) {
                $data_items = array();
                foreach ($add_items as $item) {
                    $data_items[] = array(
                        'merchant_id' => $id,
                        'item_id' => $item
                    );
                }
                $this->MerchantModel->addItems($data_items);
            }

            $rm_items = $this->request->getVar('rm_items') ?? array();
            if ($rm_items) {
                $this->MerchantModel->rmItems($rm_items);
            }

            session()->setFlashdata('success', 'Mercader actualizado con éxito.');
            return redirect()->to('admin/merchants');
        } else {
            session()->setFlashdata('error', 'No se ha podido editar el mercader.');
            session()->setFlashdata('validation_errors', $validation->getErrors());
            return redirect()->back();
        }
    }

    public function delete_merchant() {
        $id = $this->request->getVar('id');
        $this->MerchantModel->deleteMerchant($id);
        return redirect()->to('admin/merchants');
    }

    public function merchants_auto($page = 1) {
        $limit = 20;
        $start = $limit * ($page - 1);

        $merchants = $this->AutomaticMerchantModel->getMerchants($start, $limit);
        $total = $this->AutomaticMerchantModel->getTotalMerchants();

        $pager = service('pager');
        $pagination = $pager->makeLinks($page, $limit, $total, 'liga', 3);

        $this->setData('merchants', $merchants);
        $this->setData('total', $total);
        $this->setData('pagination',$pagination);
        $this->setTitle('Administrar mercaderes automatizados');
        return $this->loadView('admin/automatic_merchants');
    }

    public function new_automatic_merchant() {
        $validation = \Config\Services::validation();
        $validation->setRule('name', 'nombre', 'trim|required');
        $validation->setRule('timestamp_start', 'inicio', 'trim|required|valid_date');
        $validation->setRule('frequency_days', 'frecuencia (en días)', 'trim|required|greater_than[0]');

        if ($validation->withRequest($this->request)->run()) {
            $data = array(
                'name' => $this->request->getVar('name'),
                'timestamp_start' => $this->request->getVar('timestamp_start'),
                'frequency_days' => $this->request->getVar('frequency_days'),
                'active' => 1,
                'common' => $this->request->getVar('common') ?: 0,
                'uncommon' => $this->request->getVar('uncommon') ?: 0,
                'rare' => $this->request->getVar('rare') ?: 0,
                'very_rare' => $this->request->getVar('very_rare') ?: 0,
                'legendary' => $this->request->getVar('legendary') ?: 0,
            );
            $this->AutomaticMerchantModel->addMerchant($data);
            session()->setFlashdata('success', 'Automatización de mercader creada correctamente.');
            return redirect()->to('admin/merchants-auto');
        } else {
            session()->setFlashdata('error', 'No se ha podido crear la automatización.');
            session()->setFlashdata('validation_errors', $validation->getErrors());
            return redirect()->back();
        }
    }

    public function toggle_automatic_merchant() {
        $id = $this->request->getVar('id');
        $active = $this->request->getVar('active');
        $this->AutomaticMerchantModel->updateMerchant($id, ['active' => $active]);
    }

    public function edit_automatic_merchant() {
        $validation = \Config\Services::validation();
        $validation->setRule('id', 'id', 'trim|required');
        $validation->setRule('name', 'nombre', 'trim|required');
        $validation->setRule('timestamp_start', 'inicio', 'trim|required|valid_date');
        $validation->setRule('frequency_days', 'frecuencia (en días)', 'trim|required|greater_than[0]');

        if ($validation->withRequest($this->request)->run()) {
            $id = $this->request->getVar('id');
            $data = array(
                'name' => $this->request->getVar('name'),
                'timestamp_start' => $this->request->getVar('timestamp_start'),
                'frequency_days' => $this->request->getVar('frequency_days'),
                'active' => 1,
                'common' => $this->request->getVar('common') ?: 0,
                'uncommon' => $this->request->getVar('uncommon') ?: 0,
                'rare' => $this->request->getVar('rare') ?: 0,
                'very_rare' => $this->request->getVar('very_rare') ?: 0,
                'legendary' => $this->request->getVar('legendary') ?: 0,
            );
            $this->AutomaticMerchantModel->updateMerchant($id, $data);
            session()->setFlashdata('success', 'Automatización de mercader actualizada correctamente.');
            return redirect()->to('admin/merchants-auto');
        } else {
            session()->setFlashdata('error', 'No se ha podido actualizar la automatización.');
            session()->setFlashdata('validation_errors', $validation->getErrors());
            return redirect()->back();
        }
    }

    public function delete_automatic_merchant() {
        $id = $this->request->getVar('id');
        $this->AutomaticMerchantModel->deleteMerchant($id);
        return redirect()->to('admin/merchants-auto');
    }

}