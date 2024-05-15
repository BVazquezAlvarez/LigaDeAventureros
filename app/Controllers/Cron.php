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

        $folderPath = ROOTPATH . 'public/character_sheets';
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

        $folderPath = ROOTPATH . 'public/img/adventures';
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

        $folderPath = ROOTPATH . 'public/img/characters';
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

    public function automatic_merchants() {
        $db = \Config\Database::connect();
        $builder = $db->table('automatic_merchant');
        $builder->where('active', 1);
        $automatic_merchants = $builder->get()->getResult();

        foreach ($automatic_merchants as $am) {
            $builder = $db->table('merchant');
            $builder->where('automatic_merchant_id', $am->id);
            $builder->orderBy('timestamp_end', 'DESC');
            $last_merchant = $builder->get()->getRow();

            if ($last_merchant) {
                if (strtotime($last_merchant->timestamp_start) <  time()) {
                    $this->generateMerchant($db, $am, $last_merchant->timestamp_end);
                }
            } else {
                $this->generateMerchant($db, $am, $am->timestamp_start);
            }
        }

        $db = \Config\Database::connect();
        $builder = $db->table('merchant');
        $current_date = date('Y-m-d H:i:s');
        $builder->where('timestamp_end <', $current_date);
        $builder->where('automatic_merchant_id IS NOT NULL');
        $builder->delete();
        echo "Eliminados mercaderes antiguos" . PHP_EOL;
    }

    private function generateMerchant($db, $auto_merchant, $timestamp_start) {
        $frequency_days = $auto_merchant->frequency_days;
        do {
            $start_date = new \DateTime($timestamp_start);
            $start_date->modify("+$frequency_days days");
            $timestamp_end = $start_date->format('Y-m-d H:i:s');
            if ($start_date < new \DateTime()) {
                $timestamp_start = $timestamp_end;
            }
        } while ($start_date < new \DateTime()); // Recalculamos las fechas hasta que la fecha de fin sea posterior a hoy

        $merchant = array(
            'name' => $auto_merchant->name,
            'permanent' => 0,
            'timestamp_start' => $timestamp_start,
            'timestamp_end' => $timestamp_end,
            'automatic_merchant_id' => $auto_merchant->id,
        );

        $db->table('merchant')->insert($merchant);
		$merchant_id = $db->insertID();

        $items = array();
        $rarities = array(
            'common' => 'common',
            'uncommon' => 'uncommon',
            'rare' => 'rare',
            'very_rare' => 'very rare',
            'legendary' => 'legendary',
        );
        foreach ($rarities as $r_k => $r_v) {
            if ($auto_merchant->{$r_k}) {
                $builder = $db->table('item');
                $builder->where('rarity', $r_v);
                $builder->limit($auto_merchant->{$r_k});
                $builder->orderBy('RAND()');
                $results = $builder->get()->getResult();
                foreach ($results as $res) {
                    $items[] = array(
                        'merchant_id' => $merchant_id,
                        'item_id' => $res->id
                    );
                }
            }
        }
        $db->table('merchant_item')->insertBatch($items);
        echo "Creado mercader: " .$auto_merchant->name . PHP_EOL;
    }

}