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

class Cron extends BaseController {

    public function delete_sheets() {
        $db = \Config\Database::connect();
        $builder = $db->table('player_character');
        $builder->select('uploaded_sheet,validated_sheet');
        $chars = $builder->get()->getResult();

        $sheets = array();
        foreach ($chars as $char) {
            $sheets[] = $char->uploaded_sheet;
            $sheets[] = $char->validated_sheet;
        }
        $sheets = array_unique(array_filter($sheets, function($sheet) {
            return $sheet !== null;
        }));

        $folderPath = ROOTPATH . 'public_html/character_sheets';
        $filesInFolder = array_filter(scandir($folderPath), function($fileInFolder) {
            return (strpos($fileInFolder, '.') !== 0);
        });
        $filesToDelete = array_diff($filesInFolder, $sheets);

        $count = 0;
        foreach ($filesToDelete as $fileToDelete) {
            $filePathToDelete = $folderPath . DIRECTORY_SEPARATOR . $fileToDelete;
            if (file_exists($filePathToDelete)) {
                unlink($filePathToDelete);
                echo "Eliminado: $fileToDelete.".PHP_EOL;
                $count++;
            }
        }
        echo "$count hojas de personaje eliminadas.";
    }

    public function delete_adventure_thumbnails() {
        $db = \Config\Database::connect();
        $builder = $db->table('adventure');
        $builder->select('thumbnail');
        $advs = $builder->get()->getResult();

        $thumbnails = array();
        foreach ($advs as $adv) {
            $thumbnails[] = $adv->thumbnail;
        }
        $thumbnails = array_unique(array_filter($thumbnails, function($thumbnail) {
            return $thumbnail !== null;
        }));

        $folderPath = ROOTPATH . 'public_html/img/adventures';
        $filesInFolder = array_filter(scandir($folderPath), function($fileInFolder) {
            return (strpos($fileInFolder, '.') !== 0);
        });
        $filesToDelete = array_diff($filesInFolder, $thumbnails);

        $count = 0;
        foreach ($filesToDelete as $fileToDelete) {
            $filePathToDelete = $folderPath . DIRECTORY_SEPARATOR . $fileToDelete;
            if (file_exists($filePathToDelete)) {
                unlink($filePathToDelete);
                echo "Eliminado: $fileToDelete.".PHP_EOL;
                $count++;
            }
        }
        echo "$count thumbnails eliminados.";
    }

    public function delete_character_images() {
        $db = \Config\Database::connect();
        $builder = $db->table('player_character');
        $builder->select('image');
        $chars = $builder->get()->getResult();

        $images = array();
        foreach ($chars as $char) {
            $images[] = $char->image;
        }
        $images = array_unique(array_filter($images, function($img) {
            return $img !== null;
        }));

        $folderPath = ROOTPATH . 'public_html/img/characters';
        $filesInFolder = array_filter(scandir($folderPath), function($fileInFolder) {
            return (strpos($fileInFolder, '.') !== 0);
        });
        $filesToDelete = array_diff($filesInFolder, $images);

        $count = 0;
        foreach ($filesToDelete as $fileToDelete) {
            $filePathToDelete = $folderPath . DIRECTORY_SEPARATOR . $fileToDelete;
            if (file_exists($filePathToDelete)) {
                unlink($filePathToDelete);
                echo "Eliminado: $fileToDelete.".PHP_EOL;
                $count++;
            }
        }
        echo "$count imágenes eliminadas.";
    }

    public function delete_accounts_requested() {
        $db = \Config\Database::connect();
        $builder = $db->table('user');
        $builder->where('banned', 0);
        $builder->where('delete_on <=', date('Y-m-d'));
        $accounts = $builder->get()->getResult();

        $uids = [];
        $count = count($accounts);
        foreach ($accounts as $account) {
            $uids[] = $account->uid;
            echo "Eliminando: $account->uid ($account->display_name).".PHP_EOL;
        }

        if (!empty($uids)) {
            $builder = $db->table('user');
            $builder->whereIn('uid', $uids);
            $builder->delete();
        }

        echo "$count cuentas eliminadas.";
    }

    public function delete_accounts_inactive() {
        $db = \Config\Database::connect();
        $builder = $db->table('user');
        $builder->where('confirmed', 0);
        $builder->where('banned', 0);
        $builder->where('date_created <=', date('Y-m-d', strtotime('- 6 months')));
        $accounts = $builder->get()->getResult();

        $uids = [];
        $count = count($accounts);
        foreach ($accounts as $account) {
            $uids[] = $account->uid;
            echo "Eliminando: $account->uid ($account->display_name).".PHP_EOL;
        }

        if (!empty($uids)) {
            $builder = $db->table('user');
            $builder->whereIn('uid', $uids);
            $builder->delete();
        }

        echo "$count cuentas eliminadas.";
    }

}