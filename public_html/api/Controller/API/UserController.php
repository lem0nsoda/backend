<?php
//-----------------------------------------------------------------
//+++++++++++++++++++++++  USER CONTROLLER  +++++++++++++++++++++++
//-----------------------------------------------------------------
//  finished

class UserController extends BaseController
{
//---------------- FUNCTIONS ----------------

    private function getByID($id){
        $userModel = new UserModel();
    
        $user = $userModel->getThis($id);

        return json_encode($user); 
    }

//-------------------- ACTIONS --------------------

    public function getAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = [];

        if (strtoupper($requestMethod) == 'GET' ) 
            $arrParams = $this->getQueryStringParams();
        else if(strtoupper($requestMethod) == 'POST')
            $arrParams = $this->getPostParams();
        
        
        if (strtoupper($requestMethod) == 'GET' || strtoupper($requestMethod) == 'POST') {
                try {                 
                    $intLimit = 10;
                    $by = "id";
                    $order = "ASC";
                    $offset = 0;

                    if (isset($arrParams['limit']) && $arrParams['limit']) {
                        $intLimit = $arrParams['limit'];
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

                    $userModel = new UserModel();

                    $fromTable = $userModel->get($by, $order, $intLimit, $offset);

                    $responseData = json_encode($fromTable); 
                    
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
                if (isset($arrParams['where']) && $arrParams['where'] &&
                    isset($arrParams['is']) && $arrParams['is']) {
                
                    $where = $arrParams['where'];
                    $is = $arrParams['is'];


                    $userModel = new UserModel();

                    $user = $userModel->getBy($where, $is);

                    $responseData = json_encode($user); 

                    if(empty($responseData)){
                        $responseData = json_encode(['success' => false, 'message' => 'user not found']);
                    }
                }else{
                    $responseData = json_encode(['success' => false, 'message' => 'no ID']);
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
                if (isset($arrParams['id']) && $arrParams['id']) {
                    $id = $arrParams['id'];

                    $responseData = $this->getByID($id); 
                }else{
                    $responseData = json_encode(['success' => false, 'message' => 'no ID']);
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

    public function addAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = $this->getPostParams();

        if (strtoupper($requestMethod) == 'POST') {      //POST
            try {
                $username = $arrParams['username'] ?? null;
                $password = $arrParams['password'] ?? null;
                $rights = $arrParams['rights'] ?? null;
                $created_at = date('Y-m-d H:i:s') ?? null;
                $times_used = 0 ?? null;
                $last_online = null;

                $userModel = new UserModel();
                //add user with userModel
                $newUserId = $userModel->add($username, $password, $rights, $created_at, $times_used, $last_online);

                //success message
                if ($newUserId > 0) {
                    $responseData = json_encode(['success' => true, 'message' => 'user added successfully', 'newID' => $newUserId]);
                } else {
                    $responseData = json_encode(['success' => false, 'message' => 'Could not add user']);
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

    public function updateAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = $this->getPostParams();

        if (strtoupper($requestMethod) == 'POST' && $arrParams) {
            try {
                if (isset($arrParams['id']) && $arrParams['id']) {
                    $id = $arrParams['id'];
                    
                    $dataToUpdate = json_decode($this->getByID($id));

                    //wenn id in tabelle nicht existiert
                    if (empty($dataToUpdate)) {
                        $responseData = json_encode(['success' => false, 'message' => 'User with id '. $id .' not found.']);
                    }
                    else{

                        $username = (is_array($arrParams) && isset($arrParams['username']) && $arrParams['username']) ? $arrParams['username'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->username)) ? $dataToUpdate[0]->username 
                        : null);

                        $password = (is_array($arrParams) && isset($arrParams['password']) && $arrParams['password']) ? $arrParams['password'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->password)) ? $dataToUpdate[0]->password 
                        : null);

                        $rights = (is_array($arrParams) && isset($arrParams['rights']) && $arrParams['rights']) ? $arrParams['rights'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->rights)) ? $dataToUpdate[0]->rights 
                        : null);

                        $created_at = (is_array($arrParams) && isset($arrParams['created_at']) && $arrParams['created_at']) ? $arrParams['created_at'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->created_at)) ? $dataToUpdate[0]->created_at 
                        : null);

                        $times_used = (is_array($arrParams) && isset($arrParams['times_used']) && $arrParams['times_used']) ? $arrParams['times_used'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->times_used)) ? $dataToUpdate[0]->times_used 
                        : null);

                        $last_online = (is_array($arrParams) && isset($arrParams['last_online']) && $arrParams['last_online']) ? $arrParams['last_online'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->last_online)) ? $dataToUpdate[0]->last_online 
                        : null);

                        $userModel = new UserModel();
                        //update users with userModel
                        $result = $userModel->updateThis($id, $username, $password, $rights, $created_at, $times_used, $last_online);
                    
                        //success message
                        if ($result > 0) {
                            $responseData = json_encode(['success' => true, 'message' => 'User with id '. $id .' updated successfully']);
                        } else {
                            $responseData = json_encode(['success' => false, 'message' => 'No rows affected or User with id '. $id .' not found.']);
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
                        $old = json_decode($this->getByID($id));

                        if(isset($old[0]->times_used)){
                            $used = $old[0]->times_used;
                            $used++;
                        }
                        else
                            $used = 0;

                        $userModel = new UserModel();
                        //update client with userModel
                        $result = $userModel->updateUsed($id, $time, $used);
                    
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

    public function deleteAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = $this->getPostParams(); // To get post parameters 

        if (strtoupper($requestMethod) == 'POST') {
            try {
                $id = $arrParams['id'] ?? null;

                if (!$id) {
                    $responseData = json_encode(['success' => false, 'message' => 'ID is required !']);
                }else{
                    $userModel = new UserModel();
                    $affectedRows = $userModel->deleteThis($id);

                    if ($affectedRows > 0) {
                        $responseData = json_encode(['success' => true, 'message' => 'User with id '. $id . ' deleted successfully']);
                    } else {
                        $responseData = json_encode(['success' => false, 'message' => 'User with id '. $id . ' not found']);
                    }
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
            $this->sendOutput(
                $responseData, 
                ['Content-Type: application/json', 'HTTP/1.1 200 OK']
            );
        } else {
            $this->sendOutput(
                json_encode(['error' => $strErrorDesc]), 
                ['Content-Type: application/json', $strErrorHeader]
            );
        }
    }

}