<?php
//--------------------------------------------------------------
//++++++++++++++++++++++++  USER MODEL  ++++++++++++++++++++++++
//--------------------------------------------------------------
//  status: finished

require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class UserModel extends Database
{
    // per id von einer tabelle suchen
    public function getThis($id){
        $result =  $this->select("SELECT * FROM user WHERE id=?", ["i", $id]);
        
        return $result ?? [];
    }

    // per ... suchen
    public function getBy($where, $is){
        $allowedWhere = ["id", "username", "password", "rights", "created_at", "times_used", "last_online"];

        if (!in_array($where, $allowedWhere)) {
            throw new Exception("Invalid parameter name.");
        }

        $result =  $this->select("SELECT * FROM user WHERE $where=?", ["s", $is]);
        
        return $result ?? [];
    }

    //geordnet nach aufsteigend/absteigend; parameter wie id, name etc. ; mit limit ; in bestimmter tabelle
    public function get($by, $order, $limit, $offset){
        $order = strtoupper($order); 
        $allowedOrder = ["ASC", "DESC"];
        $allowedBy = ["id", "username", "password", "rights", "created_at", "times_used", "last_online"];

        if (!in_array($order, $allowedOrder)) {
            throw new Exception("Invalid order name.");
        }
        if (!in_array($by, $allowedBy)) {
            throw new Exception("Invalid parameter name.");
        }

        $result =  $this->select("SELECT * FROM user ORDER BY $by $order LIMIT ? OFFSET ?", ["ii", $limit, $offset]);

        return $result ?? [];
    } 
    
    //sql anweisung zum erstellen von plays_on
    public function add($username, $password, $rights, $created_at, $times_used, $last_online){
        $query = "INSERT INTO user (username, password, rights, created_at, times_used, last_online)
                VALUES (?, ?, ?, ?, ?, ? )";
        $params = [
            "ssisis", 
            $username,
            $password,
            $rights,
            $created_at,
            $times_used,
            $last_online
        ];

        return $this->insert($query, $params); // Returns the ID of the newly inserted client
    }

    //sql anweisung zum aktualisieren der daten von plays_on
    public function updateThis($id, $username, $password, $rights, $created_at, $times_used, $last_online){
        $query = "UPDATE user 
        SET username=?, password=?, rights=?, created_at=?, times_used=?, last_online=? WHERE id=?";

        $params = [
            "ssisisi", 
            $username,
            $password,
            $rights,
            $created_at,
            $times_used,
            $last_online,
            $id
        ];

        return $this->update($query, $params);
    }

    //sql anweisung zum aktualisieren von last Use und times Used von client
    public function updateUsed($id, $time, $used){

        $query = "UPDATE user SET last_online=?, times_used=? WHERE id=?";

        $params = [
            "sii", // Types: s = string, i = integer, b = bit
            $time,
            $used,
            $id
        ];

        return $this->update($query, $params);
    }

    //sql anweisung zum löschen von eineer ausgewählten tabelle
    public function deleteThis($id){
        $result = $this->delete("DELETE FROM user WHERE id = ?", ["i", $id]);
        
        return  $result ?? null; // Returns the number of rows affected (deleted)
    }
}