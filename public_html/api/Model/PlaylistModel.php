<?php
//--------------------------------------------------------------
//++++++++++++++++++++++  PLAYLIST MODEL  ++++++++++++++++++++++
//--------------------------------------------------------------
//  status: finished

$allowedTable = ["playlist", "playlist_contains", "plays_on", "play_playlist"];

require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class PlaylistModel extends Database{

// --- ALL PLAYLIST TABLES ---

    private function getAllowedParams($table){
        $allowed = [];
 
        switch($table){
            case "playlist": $allowed = ["id", "name", "times_used", "last_use", "duration", "created_by"];
                break;
            case "playlist_contains": $allowed = ["id", "content_ID", "playlist_ID", "arrangement", "duration"];
                break;
            case "plays_on": $allowed = ["id", "client_ID", "play_ID"];
                break;
            case "play_playlist": $allowed = ["id", "playlist_ID", "start", "extended"];
                break;                    
        }
        return $allowed;
    }

    public function getThis($table, $id){
        global $allowedTable;

        if (!in_array($table, $allowedTable)) {
            throw new Exception("Invalid table name.");
        }
        else{
            $result =  $this->select("SELECT * FROM $table WHERE id=?", ["i", $id]);
        }

        return $result ?? [];
    }

    public function getBy($table, $where, $is){
        global $allowedTable;
        $allowedWhere = $this->getAllowedParams($table);

        if (!in_array($table, $allowedTable) || !in_array($where, $allowedWhere)) {
            throw new Exception("Invalid table name or parameter 'where'.");
        }
        else{
            $result =  $this->select("SELECT * FROM $table WHERE $where=?", ["s", $is]);
        }

        return $result ?? [];
    }

    public function getByOrder($table, $where, $is, $by, $order){
        global $allowedTable;
        $allowedWhere = $this->getAllowedParams($table);
        $order = strtoupper($order); 
        $allowedOrder = ["ASC", "DESC"];
        $allowedBy = $this->getAllowedParams($table);

        if (!in_array($order, $allowedOrder)) {
            throw new Exception("Invalid parameter 'order'.");
        }
        else if (!in_array($by, $allowedBy)) {
            throw new Exception("Invalid parameter 'by'.");
        }
        else if (!in_array($where, $allowedWhere)) {
            throw new Exception("Invalid table name or parameter 'where'.");
        }
        else if (!in_array($table, $allowedTable) ) {
            throw new Exception("Invalid parameter 'by'.");
        }
        else{
            $result =  $this->select("SELECT * FROM " . $table . " WHERE " . $where . "=? ORDER BY " . $by . " " . $order , ["s", $is]);
        }

        return $result ?? [];
    }

    public function get($table, $by, $order, $limit, $offset){
        global $allowedTable;
        $order = strtoupper($order); 
        $allowedOrder = ["ASC", "DESC"];

        if (!in_array($table, $allowedTable)) {
            throw new Exception("Invalid table name.");
        }

        $allowedBy = $this->getAllowedParams($table);

        if (!in_array($order, $allowedOrder)) {
            throw new Exception("Invalid order name.");
        }
        if (!in_array($by, $allowedBy)) {
            throw new Exception("Invalid parameter name.");
        }

        $result =  $this->select("SELECT * FROM $table ORDER BY $by $order LIMIT ? OFFSET ?", ["ii", $limit, $offset]);

        return $result ?? [];
    }

    public function deleteThis($table, $id){
        global $allowedTable;
        $result = [];

        if (!in_array($table, $allowedTable)) {
            throw new Exception("Invalid table name.");
        }
        else{
            $result = $this->delete("DELETE FROM $table WHERE id = ?", ["i", $id]);
        }

        return  $result; // Returns the number of rows affected (deleted)
    }

// --- PLAYLIST ---

    public function addPlaylist($name, $times_used, $last_use, $duration, $created_by, $created_at){
        $query = "INSERT INTO playlist (name, times_used, last_use, duration, created_by, created_at)
                VALUES (?, ?, ?, ?, ? , ?)";
        $params = [
            "sisiis", // Types: s = string, i = integer, b = bit
            $name,
            $times_used,
            $last_use,
            $duration,
            $created_by,
            $created_at
        ];

        return $this->insert($query, $params); // Returns the ID of the newly inserted client
    }

    public function updatePlaylist($id, $name, $times_used, $last_use, $duration){
        $query = "UPDATE playlist 
        SET name=?, times_used=?, last_use=?, duration=?
        WHERE id=?";

        $params = [
            "sisii",
            $name,
            $times_used,
            $last_use,
            $duration,
            $id
        ];

        return $this->update($query, $params);
    }

    //sql anweisung zum aktualisieren von last Use und times Used von client
    public function updateUsed($id, $time, $used){

        $query = "UPDATE playlist SET last_use=?, times_used=? WHERE id=?";

        $params = [
            "sii", // Types: s = string, i = integer, b = bit
            $time,
            $used,
            $id
        ];

        return $this->update($query, $params);
    }

// --- PLAYLIST_CONTAINS ---  

    public function addPlaylistContains($content_ID, $playlist_ID, $duration, $arrangement){
        $query = "INSERT INTO playlist_contains (content_ID, playlist_ID, duration, arrangement)
                VALUES (?, ?, ?, ?)";
        $params = [
            "iiii", // Types: s = string, i = integer, b = bit
            $content_ID,
            $playlist_ID,
            $duration,
            $arrangement
        ];

        return $this->insert($query, $params); // Returns the ID of the newly inserted client
    }

    public function updatePlaylistContains($id, $content_ID, $playlist_ID, $duration, $arrangement){
        $query = "UPDATE playlist_contains 
        SET content_ID=?, playlist_ID=?, duration=?, arrangement=? WHERE id=?";

        $params = [
            "iiiii", // Types: s = string, i = integer, b = bit
            $content_ID,
            $playlist_ID,
            $duration,
            $arrangement,
            $id
        ];

        return $this->update($query, $params);
    }


// --- PLAYS_ON ---  

    public function addPlaysOn($client_ID, $play_ID){
        $query = "INSERT INTO plays_on (client_ID, play_ID)
                VALUES (?, ?)";
        $params = [
            "ii", 
            $client_ID,
            $play_ID
        ];

        return $this->insert($query, $params); // Returns the ID of the newly inserted client
    }

    public function updatePlaysOn($id, $client_ID, $play_ID){
        $query = "UPDATE plays_on 
        SET client_ID=?, play_ID=? WHERE id=?";

        $params = [
            "iii",
            $client_ID,
            $play_ID,
            $id
        ];

        return $this->update($query, $params);
    }

// --- PLAY_PLAYLIST ---  

    public function addPlayPlaylist($playlist_ID, $start, $extended){
        $query = "INSERT INTO play_playlist (playlist_ID, start, extended)
                VALUES (?, ?, ?)";
        $params = [
            "isi", 
            $playlist_ID,
            $start,
            $extended
        ];

        return $this->insert($query, $params); // Returns the ID of the newly inserted client
    }

    public function updatePlayPlaylist($id, $playlist_ID, $start, $extended){
        $query = "UPDATE play_playlist 
        SET playlist_ID=?, start=?, extended=? WHERE id=?";

        $params = [
            "isii",
            $playlist_ID,
            $start,
            $extended,
            $id
        ];

        return $this->update($query, $params);
    }
}