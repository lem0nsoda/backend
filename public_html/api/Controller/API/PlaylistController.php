<?php
//-----------------------------------------------------------------
//+++++++++++++++++++++  PLAYLIST CONTROLLER  +++++++++++++++++++++
//-----------------------------------------------------------------
//  status: finished

class PlaylistController extends BaseController
{
//------------------- FUNCTIONS -------------------

    private function getFromTableByID($table, $id){
        $playlistModel = new PlaylistModel();
    
        $playlist = $playlistModel->getThis($table, $id);

        return json_encode($playlist); 
    }

//-------------------- ACTIONS --------------------

    public function getThisAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = [];

        
        if (strtoupper($requestMethod) == 'GET' ) 
            $arrParams = $this->getQueryStringParams();
        else if(strtoupper($requestMethod) == 'POST')
            $arrParams = $this->getPostParams();


        if (strtoupper($requestMethod) == 'GET' || strtoupper($requestMethod) == 'POST') {
            try {                  
                if (isset($arrParams['id']) && $arrParams['id'] && 
                    isset($arrParams['table']) && $arrParams['table']) {
                    
                    $id = $arrParams['id'];
                    $table = $arrParams['table'];

                    $responseData = $this->getFromTableByID($table, $id); 
                }else{
                    $responseData = json_encode(['success' => false, 'message' => 'no id or table name']);
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
    
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function getByAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = [];

        
        if (strtoupper($requestMethod) == 'GET' ) 
            $arrParams = $this->getQueryStringParams();
        else if(strtoupper($requestMethod) == 'POST')
            $arrParams = $this->getPostParams();


        if (strtoupper($requestMethod) == 'GET' || strtoupper($requestMethod) == 'POST') {
            try {                  
                if (isset($arrParams['table']) && $arrParams['table'] &&
                    isset($arrParams['where']) && $arrParams['where'] &&
                    isset($arrParams['is']) && $arrParams['is']) {
                    
                    $table = $arrParams['table'];
                    $where = $arrParams['where'];
                    $is = $arrParams['is'];

                    $playlistModel = new PlaylistModel();
    
                    $data = $playlistModel->getBy($table, $where, $is);

                    $responseData = json_encode($data);

                    if(empty($responseData)){
                        $responseData = json_encode(['success' => false, 'message' => 'data not found']);
                    }
                }else{
                    $responseData = json_encode(['success' => false, 'message' => 'no id or table name']);
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
    
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    
    public function getByOrderAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = [];

        
        if (strtoupper($requestMethod) == 'GET' ) 
            $arrParams = $this->getQueryStringParams();
        else if(strtoupper($requestMethod) == 'POST')
            $arrParams = $this->getPostParams();


        if (strtoupper($requestMethod) == 'GET' || strtoupper($requestMethod) == 'POST') {
            try {                  
                if (isset($arrParams['table']) && $arrParams['table'] &&
                    isset($arrParams['where']) && $arrParams['where'] &&
                    isset($arrParams['is']) && $arrParams['is']) {
                    
                    $table = $arrParams['table'];
                    $where = $arrParams['where'];
                    $is = $arrParams['is'];

                    $by = "id";
                    $order = "ASC";

                    if (isset($arrParams['by']) && $arrParams['by']) {
                        $by = $arrParams['by'];
                    }
                    if (isset($arrParams['order']) && $arrParams['order']) {
                        $order = $arrParams['order'];
                    }


                    $playlistModel = new PlaylistModel();
    
                    $data = $playlistModel->getByOrder($table, $where, $is, $by, $order);

                    $responseData = json_encode($data);

                    if(empty($responseData)){
                        $responseData = json_encode(['success' => false, 'message' => 'data not found']);
                    }
                }else{
                    $responseData = json_encode(['success' => false, 'message' => 'no id or table name']);
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
    
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function getAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = [];

        if (strtoupper($requestMethod) == 'GET' ) 
            $arrParams = $this->getQueryStringParams();
        else if(strtoupper($requestMethod) == 'POST')
            $arrParams = $this->getPostParams();
        
        
        if (strtoupper($requestMethod) == 'GET' || strtoupper($requestMethod) == 'POST') {
            if(isset($arrParams['table']) && $arrParams['table']){
                $table = $arrParams['table'];

                try {                 
                    $limit = 10;
                    $by = "id";
                    $order = "ASC";
                    $offset = 0;

                    if (isset($arrParams['limit']) && $arrParams['limit']) {
                        $limit = $arrParams['limit'];
                    }
                    if (isset($arrParams['by']) && $arrParams['by']) {
                        $by = $arrParams['by'];
                    }
                    if (isset($arrParams['order']) && $arrParams['order']) {
                        $order = $arrParams['order'];
                    }
                    if (isset($arrParams['offset']) && $arrParams['offset']) {
                        $offset = $arrParams['offset'];
                    }

                    $playlistModel = new PlaylistModel();

                    $fromTable = $playlistModel->get($table, $by, $order, $limit, $offset);

                    $responseData = json_encode($fromTable); 
                    
                } catch (Error $e) {
                    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
            }else {
                $responseData = json_encode(['success' => false, 'message' => 'no table name found']);
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
    
        // send output 

        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    } 

    public function deleteAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = $this->getPostParams(); // To get post parameters 

        if (strtoupper($requestMethod) == 'POST') {
            try {
                // Get the ID from the query string parameters
                $id = $arrParams['id'] ?? null;
                $table = $arrParams['table'] ?? null;

                // Basic validation
                if (!$id || !$table) {
                    throw new Exception("table name AND id are required!!");
                }

                $playlistModel = new PlaylistModel();
                $affectedRows = $playlistModel->deleteThis($table, $id);

                if ($affectedRows > 0) {
                    $responseData = json_encode(['success' => true, 'message' => $table . ' with id ' . $id . ' deleted successfully']);
                } else {
                    $responseData = json_encode(['success' => false, 'message' => $table . ' with id ' . $id . ' not found']);
                }

            } catch (Exception $e) {
                $strErrorDesc = $e->getMessage();
                $strErrorHeader = 'HTTP/1.1 400 Bad Request';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 405 Method Not Allowed';
        }

        // Send response
        if (!$strErrorDesc) {
            $this->sendOutput($responseData, ['Content-Type: application/json', 'HTTP/1.1 200 OK']);
        } else {
            $this->sendOutput(json_encode(['error' => $strErrorDesc]), ['Content-Type: application/json', $strErrorHeader]);
        }
    }

// --- PLAYLIST ---
    public function addPlaylistAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = $this->getPostParams();

        if (strtoupper($requestMethod) == 'POST') {      //POST
            try {
                //extract input files
                $name = $arrParams['name'] ?? null;
                $times_used = 0 ?? null;
                $last_use = null;
                $duration = $arrParams['duration'] ?? null;
                $created_by = $arrParams['created_by'] ?? null;
                $created_at = date('Y-m-d H:i:s') ?? null;

                $playlistModel = new PlaylistModel();
                //add playlist with user Model
                $newPlaylistId = $playlistModel->addPlaylist($name, $times_used, $last_use, $duration, $created_by, $created_at);

                //success message
                if ($newPlaylistId > 0) {
                    $responseData = json_encode(['success' => true, 'message' => 'Playlist added successfully', 'newID' => $newPlaylistId]);
                } else {
                    $responseData = json_encode(['success' => false, 'message' => 'Could not add Playlist']);
                }
            } catch (Exception $e) {
                $strErrorDesc = $e->getMessage();
                $strErrorHeader = 'HTTP/1.1 400 Bad Request';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 405 Method Not Allowed';
        }
        
        // Send response
        if (!$strErrorDesc) {
            $this->sendOutput($responseData, ['Content-Type: application/json', 'HTTP/1.1 200 OK']);
        } else {
            $this->sendOutput(json_encode(['error' => $strErrorDesc]), ['Content-Type: application/json', $strErrorHeader]);
        }
    }

    public function updatePlaylistAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = $this->getPostParams();

        if (strtoupper($requestMethod) == 'POST' && $arrParams) {
            try {
                if (isset($arrParams['id']) && $arrParams['id']) {
                    $id = $arrParams['id'];
                    
                    $dataToUpdate = json_decode($this->getFromTableByID("playlist", $id));

                    //wenn id in tabelle nicht existiert
                    if (empty($dataToUpdate)) {
                            $responseData = json_encode(['success' => false, 'message' => 'Playlist with id '. $id .' not found.']);
                    }
                    else{

                        $name = (is_array($arrParams) && isset($arrParams['name']) && $arrParams['name']) ? $arrParams['name'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->name)) ? $dataToUpdate[0]->name 
                        : null);

                        $times_used = (is_array($arrParams) && isset($arrParams['times_used']) && $arrParams['times_used']) ? $arrParams['times_used'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->times_used)) ? $dataToUpdate[0]->times_used 
                        : null);

                        $last_use = (is_array($arrParams) && isset($arrParams['last_use']) && $arrParams['last_use']) ? $arrParams['last_use'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->last_use)) ? $dataToUpdate[0]->last_use 
                        : null);

                        $duration = (is_array($arrParams) && isset($arrParams['duration']) && $arrParams['duration']) ? $arrParams['duration'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->duration)) ? $dataToUpdate[0]->duration 
                        : null);

                        $playlistModel = new PlaylistModel();
                        $result = $playlistModel->updatePlaylist($id, $name, $times_used, $last_use, $duration);

                        //success message
                        if ($result > 0) {
                            $responseData = json_encode(['success' => true, 'message' => 'Playlist with id '. $id .' updated successfully']);
                        } else {
                            $responseData = json_encode(['success' => false, 'message' => 'No rows affected or Playlist with id '. $id .' not found.']);
                        }
                    }
                }
                else{
                    $responseData = json_encode(['success' => false, 'message' => 'No ID']);
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
     
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }  

    }

    public function useAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = [];

        if (strtoupper($requestMethod) == 'GET' ) 
            $arrParams = $this->getQueryStringParams();
        else if(strtoupper($requestMethod) == 'POST')
            $arrParams = $this->getPostParams();
        
        
        if (strtoupper($requestMethod) == 'GET' || strtoupper($requestMethod) == 'POST') {
            try {
                if (isset($arrParams['id']) && $arrParams['id']) {
                    $id = $arrParams['id'];
                    
                    $time = date("Y-m-d H:i:s");
                    $old = json_decode($this->getFromTableByID("playlist", $id));
                    if(isset($old[0]->times_used)){
                        $used = $old[0]->times_used;
                        $used++;
                    }
                    else
                        $used = 0;

                    $playlistModel = new PlaylistModel();
                    //update client with userModel
                    $result = $playlistModel->updateUsed($id, $time, $used);
                
                    //success message
                    if ($result > 0) {
                        $responseData = json_encode(['success' => true, 'message' => 'Client with id '. $id .' updated successfully']);
                    } else {
                        $responseData = json_encode(['success' => false, 'message' => 'No rows affected or Client with id '. $id .' not found.']);
                    }
                    
                }
                else{
                    $responseData = json_encode(['success' => false, 'message' => 'No ID']);
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
     
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }  
    }

// --- PLAYLIST_CONTAINS ---
    public function addPlaylistContainsAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = $this->getPostParams();

        if (strtoupper($requestMethod) == 'POST') { 
            try {
                $content_id = $arrParams['content_id'] ?? null;
                $playlist_id = $arrParams['playlist_id'] ?? null;
                $duration = $arrParams['duration'] ?? null;
                $arrangement = $arrParams['arrangement'] ?? null;

                $playlistModel = new PlaylistModel();
                $newPlaylistContainsId = $playlistModel->addPlaylistContains($content_id, $playlist_id, $duration, $arrangement);

                //success message
                if ($newPlaylistContainsId > 0) {
                    $responseData = json_encode(['success' => true, 'message' => 'Playlist_contains added successfully', 'newID' => $newPlaylistContainsId]);
                } else {
                    $responseData = json_encode(['success' => false, 'message' => 'Could not add Playlist_contains']);
                }
            } catch (Exception $e) {
                $strErrorDesc = $e->getMessage();
                $strErrorHeader = 'HTTP/1.1 400 Bad Request';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 405 Method Not Allowed';
        }
        
        // Send response
        if (!$strErrorDesc) {
            $this->sendOutput($responseData, ['Content-Type: application/json', 'HTTP/1.1 200 OK']);
        } else {
            $this->sendOutput(json_encode(['error' => $strErrorDesc]), ['Content-Type: application/json', $strErrorHeader]);
        }
    }

    public function updatePlaylistContainsAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = $this->getPostParams();

        if (strtoupper($requestMethod) == 'POST' && $arrParams) {
            try {
                if (isset($arrParams['id']) && $arrParams['id']) {
                    $id = $arrParams['id'];
                    
                    $dataToUpdate = json_decode($this->getFromTableByID("playlist_contains", $id));

                    //wenn id in tabelle nicht existiert
                    if (empty($dataToUpdate)) {
                        $responseData = json_encode(['success' => false, 'message' => 'response data is empty, no playlist_contains to update, wrong ID']);
                    }
                    else{

                        $content_id = (is_array($arrParams) && isset($arrParams['content_id']) && $arrParams['content_id']) ? $arrParams['content_id'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->content_ID)) ? $dataToUpdate[0]->content_ID 
                        : null);

                        $playlist_id = (is_array($arrParams) && isset($arrParams['playlist_id']) && $arrParams['playlist_id']) ? $arrParams['playlist_id'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->playlist_ID)) ? $dataToUpdate[0]->playlist_ID 
                        : null);

                        $duration = (is_array($arrParams) && isset($arrParams['duration']) && $arrParams['duration']) ? $arrParams['duration'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->duration)) ? $dataToUpdate[0]->duration 
                        : null);

                        $arrangement = (is_array($arrParams) && isset($arrParams['arrangement']) && $arrParams['arrangement']) ? $arrParams['arrangement'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->arrangement)) ? $dataToUpdate[0]->arrangement 
                        : null);

                        $playlistModel = new PlaylistModel();
                        $result = $playlistModel->updatePlaylistContains($id, $content_id, $playlist_id, $duration, $arrangement);
                    
                        //success message
                        if ($result > 0) {
                            $responseData = json_encode(['success' => true, 'message' => 'playlist_contains with id '. $id .' updated successfully']);
                        } else {
                            $responseData = json_encode(['success' => false, 'message' => 'No rows affected or playlist_contains with id '. $id .' not found.']);
                        }
                    }
                }
                else{
                    $responseData = json_encode(['success' => false, 'message' => 'No ID']);
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
     
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }  
    }
    
// --- PLAYS_ON ---
    public function addPlaysOnAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = $this->getPostParams();

        if (strtoupper($requestMethod) == 'POST') {     
            try {
                // Extract input fields
                $client_id = $arrParams['client_id'] ?? null;
                $play_id = $arrParams['play_id'] ?? null;

                $playlistModel = new PlaylistModel();
                //add plays_on with user model
                $newPlaysOnId = $playlistModel->addPlaysOn($client_id, $play_id);

                //success message
                if ($newPlaysOnId > 0) {
                    $responseData = json_encode(['success' => true, 'message' => 'Plays_on added successfully', 'newID' => $newPlaysOnId]);
                } else {
                    $responseData = json_encode(['success' => false, 'message' => 'Could not add Plays_on']);
                }
            } catch (Exception $e) {
                $strErrorDesc = $e->getMessage();
                $strErrorHeader = 'HTTP/1.1 400 Bad Request';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 405 Method Not Allowed';
        }
        
        // Send response
        if (!$strErrorDesc) {
            $this->sendOutput($responseData, ['Content-Type: application/json', 'HTTP/1.1 200 OK']);
        } else {
            $this->sendOutput(json_encode(['error' => $strErrorDesc]), ['Content-Type: application/json', $strErrorHeader]);
        }
    }

    public function updatePlaysOnAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = $this->getPostParams();

        if (strtoupper($requestMethod) == 'POST' && $arrParams) {
            try {
                if (isset($arrParams['id']) && $arrParams['id']) {
                    $id = $arrParams['id'];
                    
                    $dataToUpdate = json_decode($this->getFromTableByID("plays_on", $id));

                    //wenn id in tabelle nicht existiert
                    if (empty($dataToUpdate)) {
                        $responseData = json_encode(['success' => false, 'message' => 'response data is empty, no plays_on to update']);
                    }
                    else{

                        $client_id = (is_array($arrParams) && isset($arrParams['client_id']) && $arrParams['client_id']) ? $arrParams['client_id'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->client_id)) ? $dataToUpdate[0]->client_id 
                        : null);

                        $play_id = (is_array($arrParams) && isset($arrParams['play_id']) && $arrParams['play_id']) ? $arrParams['play_id'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->play_id)) ? $dataToUpdate[0]->play_id 
                        : null);

                        $playlistModel = new PlaylistModel();
                        //update plays_on with userModel
                        $result = $playlistModel->updatePlaysOn($id, $client_id, $play_id);
                    
                        //success message
                        if ($result > 0) {
                            $responseData = json_encode(['success' => true, 'message' => 'plays_on with id '. $id .' updated successfully']);
                        } else {
                            $responseData = json_encode(['success' => false, 'message' => 'No rows affected or plays_on with id '. $id .' not found.']);
                        }
                    }
                }
                else{
                    $responseData = json_encode(['success' => false, 'message' => 'No ID']);
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
     
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }  

    }
   
// --- PLAY_PLAYLIST ---

    public function addPlayPlaylistAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = $this->getPostParams();

        if (strtoupper($requestMethod) == 'POST') {      //POST
            try {
                // Extract input fields
                $playlist_id = $arrParams['playlist_id'] ?? null;
                $start = $arrParams['start'] ?? null;
                $extended = $arrParams['extended'] ?? null;

                $playlistModel = new PlaylistModel();
                $newPlayPlaylistId = $playlistModel->addPlayPlaylist($playlist_id, $start, $extended);
                
                $responseData = $this->getFromTableByID("play_playlist", $newPlayPlaylistId);

                //success message
                if ($newPlayPlaylistId > 0) {
                    $responseData = json_encode(['success' => true, 'message' => 'play_playlist added successfully', 'newID' => $newPlayPlaylistId]);
                } else {
                    $responseData = json_encode(['success' => false, 'message' => 'Could not add play_playlist']);
                }
            } catch (Exception $e) {
                $strErrorDesc = $e->getMessage();
                $strErrorHeader = 'HTTP/1.1 400 Bad Request';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 405 Method Not Allowed';
        }
        
        // Send response
        if (!$strErrorDesc) {
            $this->sendOutput($responseData, ['Content-Type: application/json', 'HTTP/1.1 200 OK']);
        } else {
            $this->sendOutput(json_encode(['error' => $strErrorDesc]), ['Content-Type: application/json', $strErrorHeader]);
        }
    }

    public function updatePlayPlaylistAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = $this->getPostParams();

        if (strtoupper($requestMethod) == 'POST' && $arrParams) {
            try {
                if (isset($arrParams['id']) && $arrParams['id']) {
                    $id = $arrParams['id'];
                    
                    $dataToUpdate = json_decode($this->getFromTableByID("play_playlist", $id));

                    //wenn id in tabelle nicht existiert
                    if (empty($dataToUpdate)) {
                        $responseData = json_encode(['success' => false, 'message' => 'response data is empty, no play_playlist to update']);
                    }
                    else{

                        $playlist_id = (is_array($arrParams) && isset($arrParams['playlist_id']) && $arrParams['playlist_id']) ? $arrParams['playlist_id'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->playlist_id)) ? $dataToUpdate[0]->playlist_id 
                        : null);

                        $start = (is_array($arrParams) && isset($arrParams['start']) && $arrParams['start']) ? $arrParams['start'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->start)) ? $dataToUpdate[0]->start 
                        : null);
                        
                        $extended = (is_array($arrParams) && isset($arrParams['extended']) && $arrParams['extended']) ? $arrParams['extended'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->extended)) ? $dataToUpdate[0]->extended 
                        : null);

                        $playlistModel = new PlaylistModel();
                        $result = $playlistModel->updatePlayPlaylist($id, $playlist_id, $start, $extended);
                    
                        //success message
                        if ($result > 0) {
                            $responseData = json_encode(['success' => true, 'message' => 'play_playlist with id '. $id .' updated successfully']);
                        } else {
                            $responseData = json_encode(['success' => false, 'message' => 'No rows affected or play_playlist with id '. $id .' not found.']);
                        }
                    }
                }
                else{
                    $responseData = json_encode(['success' => false, 'message' => 'No ID']);
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
     
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }  

    }
}