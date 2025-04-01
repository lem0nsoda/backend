<?php
//---------------------------------------------------------------
//+++++++++++++++++++++++  CONTENT MODEL  +++++++++++++++++++++++
//---------------------------------------------------------------
//  status: finished

require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class ContentModel extends Database
{

// per id von einer tabelle suchen
    public function getThis($id){

        $result =  $this->select("SELECT * FROM content WHERE id=?", ["i", $id]);

        return $result ?? [];
    }

    // per ... suchen
    public function getBy($where, $is){

        $allowedWhere = ["id", "name", "type", "width", "height", "duration", "times_used", "last_use", "added_by", "added_at"];

        if (!in_array($where, $allowedWhere)) {
            throw new Exception("Invalid parameter name.");
        }

        $result =  $this->select("SELECT * FROM content WHERE $where=?", ["s", $is]);
        
        return $result ?? [];
    }

//geordnet nach aufsteigend/absteigend; parameter wie id, name etc. ; mit limit 
    public function get($by, $order, $limit, $offset){
        $order = strtoupper($order); 
        $allowedOrder = ["ASC", "DESC"];
        $allowedBy = ["id", "name", "type", "width", "height", "duration", "times_used", "last_use", "added_by", "added_at"];
                
        if (!in_array($order, $allowedOrder)) {
            throw new Exception("Invalid order name.");
        }
        if (!in_array($by, $allowedBy)) {
            throw new Exception("Invalid parameter name.");
        }

        $result =  $this->select("SELECT * FROM content ORDER BY $by $order LIMIT ? OFFSET ?", ["ii", $limit, $offset]);

        return $result ?? [];
    }

    public function getInfo($by, $order, $limit, $offset){
        $order = strtoupper($order); 
        $allowedOrder = ["ASC", "DESC"];
        $allowedBy = ["id", "name", "type", "width", "height", "duration", "times_used", "last_use", "added_by", "added_at"];
                
        if (!in_array($order, $allowedOrder)) {
            throw new Exception("Invalid order name.");
        }
        if (!in_array($by, $allowedBy)) {
            throw new Exception("Invalid parameter name.");
        }

        $result =  $this->select("SELECT id, name, type,  width, height, duration, times_used, last_use, added_by, added_at FROM content ORDER BY $by $order LIMIT ? OFFSET ?", ["ii", $limit, $offset]);

        return $result ?? [];
    }

//sql anweisung zum erstellen von content
    public function add($name, $type,  $width, $height, $data, $duration, $times_used, $last_use, $added_by, $added_at){
        $query = "INSERT INTO content (name, type,  width, height, data, duration, times_used, last_use, added_by, added_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
            "ssiisiisis", // Types: s = string, i = integer, b = bit
            $name,
            $type,
            $width,
            $height,
            $data,
            $duration,
            $times_used,
            $last_use,
            $added_by,
            $added_at
        ];

        return $this->insert($query, $params); // Returns the ID of the newly inserted client
    }
    
//sql anweisung zum aktualisieren der daten von content
    public function updateThis($id, $name, $type,  $width, $height, $data, $duration, $times_used, $last_use){

        $query = "UPDATE content 
        SET name=?, type=?, width=?, height=?, data=?, duration=?, times_used=?, last_use=? 
        WHERE id=?";

        $params = [
            "ssiisiisi", // Types: s = string, i = integer, b = bit
            $name,
            $type,
            $width,
            $height,
            $data,
            $duration,
            $times_used,
            $last_use,
            $id
        ];

        return $this->update($query, $params);
    }

//sql anweisung zum aktualisieren von last Use und times Used von client
    public function updateUsed($id, $time, $used){

        $query = "UPDATE content SET last_use=?, times_used=? WHERE id=?";

        $params = [
            "sii", // Types: s = string, i = integer, b = bit
            $time,
            $used,
            $id
        ];

        return $this->update($query, $params);
    }

//sql anweisung zum löschen
    public function deleteThis($id){
        $result = $this->delete("DELETE FROM content WHERE id = ?", ["i", $id]);

        return  $result ?? []; // Returns the number of rows affected (deleted)
    }

}