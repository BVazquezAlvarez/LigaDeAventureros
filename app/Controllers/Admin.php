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

class Admin extends BaseController {

    public function __construct() {
        if (!$this->isAdmin()) {
            header("Location: /");
            exit();
        }
        $this->UserModel = model('UserModel');
        $this->UploadLogModel = model('UploadLogModel');
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
        return redirect()->to('admin/users');
    }

    public function user_toggle_admin() {
        $uid = $this->request->getVar('uid');
        $data = [
            'admin' => $this->request->getVar('admin'),
        ];
        $this->UserModel->updateUser($uid, $data);
        return redirect()->to('admin/users');
    }

    public function user_ban() {
        $uid = $this->request->getVar('uid');
        $data = [
            'master' => 0,
            'admin' => 0,
            'banned' => 1,
        ];
        $this->UserModel->updateUser($uid, $data);
        return redirect()->to('admin/users');
    }

    public function user_unban() {
        $uid = $this->request->getVar('uid');
        $data = [
            'banned' => 0,
        ];
        $this->UserModel->updateUser($uid, $data);
        return redirect()->to('admin/users');
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

}