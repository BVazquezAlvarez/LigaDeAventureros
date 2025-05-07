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

class SessionModel extends Model {

    protected $table = 'session';
    protected $primaryKey = 'uid';

    protected $allowedFields = [
        'uid',
        'adventure_uid',
        'master_uid',
        'date',
        'time',
        'players_min',
        'players_max',
        'location',
        'published',
    ];

    public function getSessions($start = NULL, $end = NULL, $master_uid = NULL, $count_players = false, $published_only = true) {
        $builder = $this->db->table('session');
        $builder->select('session.*, adventure.name AS adventure_name, adventure.rank, user.display_name AS master, adventure.thumbnail, adventure.w_setting_id, world_setting.name AS w_setting_name, world_setting.timeline, adventure.type AS type_id, adventure_type.name AS type_name');
        $builder->join('adventure','session.adventure_uid = adventure.uid', 'left');
        $builder->join('world_setting','adventure.w_setting_id = world_setting.id', 'left');
        $builder->join('adventure_type', 'adventure.type = adventure_type.id', 'left');
        $builder->join('user', 'session.master_uid = user.uid', 'left');
        if ($published_only) {
            $builder->where('session.published', 1);
        }
        if ($start) {
            $builder->where('session.date >=', $start);
        }
        if ($end) {
            $builder->where('session.date <=', $end);
        }
        if ($master_uid) {
            $builder->where('session.master_uid', $master_uid);
        }
        if ($count_players) {
            $builder->select('COUNT(player_session.player_uid) AS registered_players');
            $builder->join('player_session', 'session.uid = player_session.session_uid', 'left');
            $builder->groupBy('session.uid');
        }
        $builder->orderBy('session.date', 'ASC');
        $builder->orderBy('session.time', 'ASC');
        return $builder->get()->getResult();
    }

    public function getSession($uid) {
        $builder = $this->db->table('session');
        $builder->select('session.*, adventure.w_setting_id, user.display_name AS master');
        $builder->join('adventure','session.adventure_uid = adventure.uid', 'left');
        $builder->join('user', 'session.master_uid = user.uid', 'left');
        $builder->where('session.uid', $uid);
        return $builder->get()->getRow();
    }

    public function getAdventureSessions($adventure_uid) {
        $builder = $this->db->table('session');
        $builder->select('session.*, user.uid AS master_uid, user.display_name AS master_name, COUNT(player_session.player_uid) AS registered_players');
        $builder->join('user', 'session.master_uid = user.uid', 'left');
        $builder->join('player_session', 'session.uid = player_session.session_uid', 'left');
        $builder->where('session.adventure_uid', $adventure_uid);
        $builder->orderBy('session.date', 'DESC');
        $builder->groupBy('session.uid');
        return $builder->get()->getResult();
    }

    public function getUnpublishedSessions() {
        $builder = $this->db->table('session');
        $builder->select('session.*, adventure.name AS adventure_name, adventure.rank, user.display_name AS master, adventure.w_setting_id, world_setting.name AS w_setting_name, world_setting.timeline, adventure.type as type_id, adventure_type.name AS type_name');
        $builder->join('adventure','session.adventure_uid = adventure.uid', 'left');
        $builder->join('world_setting','adventure.w_setting_id = world_setting.id', 'left');
        $builder->join('user', 'session.master_uid = user.uid', 'left');
        $builder->join('adventure_type', 'adventure.type = adventure_type.id', 'left');
        $builder->where('session.published', 0);
        $builder->orderBy('session.date', 'ASC');
        return $builder->get()->getResult();      
    }

    public function getSessionPlayers($session_uid) {
        $builder = $this->db->table('player_session');
        $builder->select('player_session.timestamp, user.uid, user.display_name, player_character.uid AS character_uid, player_character.name, player_character.level, player_character.uploaded_sheet, player_session.priority');
        $builder->join('user', 'player_session.player_uid = user.uid', 'left');
        $builder->join('player_character', 'player_session.player_character_uid = player_character.uid', 'left');
        $builder->where('player_session.session_uid', $session_uid);
        $builder->orderBy('player_session.priority', 'DESC');
        $builder->orderBy('player_session.timestamp', 'ASC');
        return $builder->get()->getResult();
    }

    public function addSession($data) {
        $this->db->table('session')->insert($data);
        return $this->db->affectedRows();
    }

    public function updateSession($uid, $data) {
        $builder = $this->db->table('session');
        $builder->where('uid', $uid);
        $builder->update($data);
    }

    public function addPlayerSession($data) {
        $this->db->table('player_session')->insert($data);
        return $this->db->affectedRows();
    }

    public function updatePlayerSession($session_uid, $player_uid, $data) {
        $builder = $this->db->table('player_session');
        $builder->where('session_uid', $session_uid);
        $builder->where('player_uid', $player_uid);
        $builder->update($data);
    }

    public function deletePlayerSession($session_uid, $player_uid) {
        $builder = $this->db->table('player_session');
        $builder->where('session_uid', $session_uid);
        $builder->where('player_uid', $player_uid);
        $builder->delete();
    }

    public function deleteSession($session_uid) {
        $builder = $this->db->table('session');
        $builder->where('uid', $session_uid);
        $builder->delete();
    }

    public function publishSessions($uids) {
        $builder = $this->db->table('session');
        $builder->whereIn('uid', $uids);
        $builder->update(['published' => 1]);
    }

    public function getLocations() {
        $builder = $this->db->table('session');
        $builder->select('location, COUNT(*) AS total');
        $builder->orderBy('total', 'DESC');
        $builder->groupBy('location');
        $builder->where('location !=', '');
        return $builder->get()->getResult();
    }

}