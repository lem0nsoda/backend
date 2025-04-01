<?php
class Database
{
    protected $connection = null;
    public function __construct()
    {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
            
            if (mysqli_connect_errno()) {
                throw new Exception("Verbindung zur Datenbank fehlgeschlagen.");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    public function select($query = "", $params = [])
    {
        try {
            $stmt = $this->executeStatement($query, $params);
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    public function insert($query = "", $params = [])
    {
        try {
            $stmt = $this->executeStatement($query, $params);
            $insertId = $stmt->insert_id; // Get the ID of the inserted row
            $stmt->close();
            return $insertId; // Return the ID
        } catch (Exception $e) {
            throw new Exception("Error inserting client: " . $e->getMessage());
        }
    }

    public function update($query = "", $params = [])
    {
        try {
            // Execute the update query with parameters
            $stmt = $this->executeStatement($query, $params);
            $affectedRows = $stmt->affected_rows; // Get the number of rows affected
            $stmt->close();
            return $affectedRows; // Return the number of affected rows
        } catch (Exception $e) {
            throw new Exception("Error updating data: " . $e->getMessage());
        }
    }


    public function delete($query = "", $params = [])
    {
        try {
            // Debugging: Log the query and parameters for troubleshooting
            error_log("Executing SQL query: " . $query);
            error_log("Parameters: " . json_encode($params));

            // Prepare the statement
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new Exception("Error preparing statement: " . $this->connection->error);
            }

            // Dynamically bind parameters
            if (count($params) > 0) {
                $types = $params[0]; // The first element contains the types
                $values = array_slice($params, 1); // The rest are the values to bind

                // Bind parameters dynamically
                $stmt->bind_param($types, ...$values);
            }

            // Execute the query
            $stmt->execute();

            // Get the number of affected rows
            $affectedRows = $stmt->affected_rows;
            $stmt->close();

            return $affectedRows; // Return number of rows affected
        } catch (Exception $e) {
            // Log the error and rethrow it
            error_log("Error deleting data: " . $e->getMessage());
            throw new Exception("Error deleting data: " . $e->getMessage());
        }
    }



    private function executeStatement($query = "", $params = [])
    {
        try {
            $stmt = $this->connection->prepare($query);
            if ($stmt === false) {
                throw new Exception("Fehler bei der Prepared Statement-Erstellung.");
            }
            if ($params) {

                $types = $params[0];
                $values = array_slice($params, 1);
    
                if (!is_string($types) || count($values) !== strlen($types)) {
                    throw new Exception("Invalid parameter types or mismatched parameter count.");
                }
    
                // Convert values to references for bind_param
                $stmt->bind_param($types, ...$values);
            }
            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function query($query, $params = [])
    {
        // Bereite die SQL-Anweisung vor
        $stmt = $this->connection->prepare($query);
        
        if ($stmt === false) {
            die('Fehler bei der Vorbereitung der Abfrage: ' . $this->connection->error);
        }
        // Wenn Parameter vorhanden sind, binde sie an die SQL-Anweisung
        if (!empty($params)) {
            // Bereite die Parameterbindung vor (dynamisch, abhängig vom Typ der Parameter)
            $types = $params[0]; // Der Typ-String für die Parameter
            $values = array_slice($params, 1); // Die Werte der Parameter
            // Binde die Parameter
            $stmt->bind_param($types, ...$values);
        }
        // Führe die Abfrage aus
        if ($stmt->execute()) {
            // Rückgabe der Ergebnisse
            $result = $stmt->get_result();
            return $result;
        } else {
            // Fehlerfall
            die('Fehler bei der Ausführung der Abfrage: ' . $stmt->error);
        }
    }
    // Eine Methode, um die Verbindung zu schließen (optional)
    public function close()
    {
        $this->connection->close();
    }
}
?>