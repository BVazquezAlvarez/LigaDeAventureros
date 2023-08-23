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
            return pathinfo($fileInFolder, PATHINFO_EXTENSION) === 'pdf';
        });
        $filesToDelete = array_diff($filesInFolder, $sheets);

        $count = 0;
        foreach ($filesToDelete as $fileToDelete) {
            $filePathToDelete = $folderPath . DIRECTORY_SEPARATOR . $fileToDelete;
            if (file_exists($filePathToDelete)) {
                unlink($filePathToDelete);
                echo "Eliminado: $fileToDelete.<br>";
                $count++;
            }
        }
        echo "$count ficheros eliminados.";
    }

}