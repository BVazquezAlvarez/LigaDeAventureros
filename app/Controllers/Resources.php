<?php
// LigaDeAventureros
// Copyright (C) 2026 Santiago González Lago

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

class Resources extends BaseController {

  public function __construct() {
    $this->ResourceModel = model('ResourceModel');
  }

  public function index($page = 1) {
    $limit = 20;
    $start = $limit * ($page - 1);

    $q = $this->request->getGet('q');

    $resources = $this->ResourceModel->getResources($start, $limit, $q, 1);
    $total = $this->ResourceModel->getTotalResources($q, 1);

    if ($total > 0 && $start >= $total) {
      $redirect_url = '/resources';
      if ($q) {
        $redirect_url .= '?q=' . urlencode($q);
      }
      return redirect()->to($redirect_url);
    }

    $pager = service('pager');
    $pagination = $pager->makeLinks($page, $limit, $total, 'liga', 2);

    foreach ($resources as $resource) {
      if ($resource->type == 'file') {
        $resource->location = base_url('files/' . $resource->location);
      }
    }

    $this->setData('resources', $resources);
    $this->setData('total', $total);
    $this->setData('q', $q);
    $this->setData('pagination', $pagination);
    $this->setTitle('Recursos');
    return $this->loadView('resources/list');
  }

}