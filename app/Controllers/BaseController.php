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

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Libraries\MyEmail;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller {
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['general','uid','setting','rank','upload_log'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        setlocale(LC_TIME, 'es_ES.UTF-8');
        date_default_timezone_set("Europe/Madrid");

        $this->data = array();

        if (setting('maintenance_mode') && !in_array($_SERVER['REMOTE_ADDR'], explode(';',setting('maintenance_mode_ips')))) {
            echo view('maintenance_mode');
            die();
        }

        // Preload any models, libraries, etc, here.
        $this->email = new MyEmail();

        // E.g.: $this->session = \Config\Services::session();
        $this->data['userdata'] = $this->isUserLoggedIn() ? $this->getUserData() : NULL;
    }

    protected function loadView(string $view) {
        if ($this->request->isAJAX()) {
            return view($view, $this->data);
        } else {
            $this->data['view'] = $view;
            return view('container', $this->data);
        }
    }

    protected function setTitle(string $title) {
        $this->data['title'] = $title;
    }

    protected function setData(string $key, $value) {
        $this->data[$key] = $value;
    }

	protected function isUserLoggedIn() {
		return (bool) session('user_uid');
	}

    protected function isMaster() {
        $userdata = $this->getUserData();
        return $userdata && $userdata['master'];
    }

    protected function isAdmin() {
        $userdata = $this->getUserData();
        return $userdata && $userdata['admin'];
    }

    protected function getUserData() {
		if (isset($this->data['userdata'])) {
			return $this->data['userdata'];
		}

        if ($this->isUserLoggedIn()) {
            $userModel = model('UserModel');
            $data = $userModel->getValidUser(session('user_uid'));

            if ($data) {
                return [
                    'uid'          => session('user_uid'),
                    'display_name' => $data->display_name,
                    'confirmed'    => $data->confirmed,
                    'master'       => $data->master || $data->admin,
                    'admin'        => $data->admin,
                ];
            } else {
                log_message('error', 'Error fetching user ' . session('user_uid'));
                session()->destroy();
                return NULL;
            }
        } else {
            return NULL;
        }
	}
}
