<?php
//--------------------------------------------------------------
//+++++++++++++++++++++++  CLIENT MODEL  +++++++++++++++++++++++
//--------------------------------------------------------------
//  status: finished

require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class ClientModel extends Database
{
    // per id suchen
    public function getThis($id){
        $result =  $this->select("SELECT * FROM client WHERE id=?", ["i", $id]);
        
        return $result ?? [];
    }

    // per ... suchen
    public function getBy($where, $is){
        $allowedWhere = ["id", "name", "width", "height", "xPosition", "yPosition", "client_status", "times_used", "last_use", "joined_at"];

        if (!in_array($where, $allowedWhere)) {
            throw new Exception("Invalid parameter name.");
        }

        $result =  $this->select("SELECT * FROM client WHERE $where=?", ["s", $is]);
        
        return $result ?? [];
    }

    //geordnet nach aufsteigend/absteigend; parameter wie id, name etc. ; mit limit ; in bestimmter tabelle
    public function get($by, $order, $limit, $offset){
        $order = strtoupper($order); 
        $allowedOrder = ["ASC", "DESC"];
        $allowedBy = ["id", "name", "width", "height", "xPosition", "yPosition", "client_status", "times_used", "last_use", "joined_at"];


        if (!in_array($order, $allowedOrder)) {
            throw new Exception("Invalid order name.");
        }
        if (!in_array($by, $allowedBy)) {
            throw new Exception("Invalid parameter name.");
        }

        $result =  $this->select("SELECT * FROM client ORDER BY $by $order LIMIT ? OFFSET ?", ["ii", $limit, $offset]);

        return $result ?? [];
    }

    //sql anweisung zum erstellen von clients
    public function add($name, $width, $height, $xPosition, $yPosition, $status, $times_used, $last_used, $joined_at){
        $query = "INSERT INTO client (name, width, height, xPosition, yPosition, client_status, times_used, last_use, joined_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
            "siiiibiss", // Types: s = string, i = integer, b = bit
            $name,
            $width,
            $height,
            $xPosition,
            $yPosition,
            $status,
            $times_used,
            $last_used,
            $joined_at
        ];

        return $this->insert($query, $params); // Returns the ID of the newly inserted client
    }

    //sql anweisung zum aktualisieren der daten von client
    public function updateThis($id, $name, $width, $height, $xPosition, $yPosition, $status, $times_used, $last_used, $joined_at){

        // Ensure $times_used is an integer and $joined_at is a valid string (e.g., 'Y-m-d H:i:s')
        $times_used = (int) $times_used;
        $joined_at = $joined_at ? date('Y-m-d H:i:s', strtotime($joined_at)) : null;


        $query = "UPDATE client 
        SET name=?, width=?, height=?, xPosition=?, yPosition=?, client_status=?, times_used=?, last_use=?, joined_at=? 
        WHERE id=?";

        $params = [
            "siiiibissi", // Types: s = string, i = integer, b = bit
            $name,
            $width,
            $height,
            $xPosition,
            $yPosition,
            $status,
            $times_used,
            $last_used,
            $joined_at,
            $id
        ];

        return $this->update($query, $params);
    }

    //sql anweisung zum aktualisieren des status von client
    public function updateStatus($id, $status){

        $query = "UPDATE client SET client_status=? WHERE id=?";

        $params = [
            "ii", // Types: s = string, i = integer, b = bit
            $status,
            $id
        ];

        return $this->update($query, $params);
    }

    //sql anweisung zum aktualisieren von last Use und times Used von client
    public function updateUsed($id, $time, $used){

        $query = "UPDATE client SET last_use=?, times_used=? WHERE id=?";

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
        $result = $this->delete("DELETE FROM client WHERE id = ?", ["i", $id]);

        return  $result ?? null; // Returns the number of rows affected (deleted)
    }
}
