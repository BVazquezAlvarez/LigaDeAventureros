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

namespace App\Models;  
use CodeIgniter\Model;

class AdventureModel extends Model {

	protected $table = 'adventure';
	protected $primaryKey = 'uid';

	protected $allowedFields = [
		'uid',
        'name',
        'rank',
        'players_min_recommended',
        'players_max_recommended',
        'duration',
        'themes',
        'description',
        'rewards',
        'thumbnail'
	];

    public function getAdventureList() {
        $builder = $this->db->table('adventure');
        $builder->orderBy('rank', 'ASC');
        $builder->orderBy('name', 'ASC');
        return $builder->get()->getResult();
    }

    public function getAdventuresWithSessionData($filters) {
        $builder = $this->db->table('adventure');
        $builder->select(
            'adventure.*,
            COUNT(CASE WHEN TIMESTAMP(session.date, session.time) < NOW() THEN session.uid END) AS total_past,
            COUNT(CASE WHEN TIMESTAMP(session.date, session.time) > NOW() THEN session.uid END) AS total_future,
            MAX(CASE WHEN TIMESTAMP(session.date, session.time) < NOW() THEN TIMESTAMP(session.date, session.time) END) AS last_session_datetime,
            MIN(CASE WHEN TIMESTAMP(session.date, session.time) > NOW() THEN TIMESTAMP(session.date, session.time) END) AS next_session_datetime'
        );
        $builder->join('session', 'adventure.uid = session.adventure_uid', 'left');
        $builder->groupBy('adventure.uid');
        $builder->orderBy('ISNULL(adventure.rank)', 'ASC');
        $builder->orderBy('adventure.rank', 'ASC');
        $builder->orderBy('adventure.name', 'ASC');

        extract($filters);
        if ($q) {
            $builder->like('adventure.name', $q);
        }
        if ($rank) {
            $builder->groupStart();
            $builder->where('adventure.rank', $rank);
            $builder->orWhere('adventure.rank IS NULL');
            $builder->groupEnd();
        }
        if ($my_games) {
            $builder->join('session session_mine', 'adventure.uid = session_mine.adventure_uid', 'left');
            $builder->where('session_mine.master_uid', session('user_uid'));
        }
        if ($unplayed) {
            $builder->having('total_past', 0);
        }

        return $builder->get()->getResult();
    }

    public function getAdventure($uid) {
        $builder = $this->db->table('adventure');
        $builder->where('uid',$uid);
        return $builder->get()->getRow();
    }

    public function addAdventure($data) {
		$this->db->table('adventure')->insert($data);
		return $this->db->affectedRows();
	}
}