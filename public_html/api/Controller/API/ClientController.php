<?php
//---------------------------------------------------------------
//+++++++++++++++++++++  CLIENT CONTROLLER  +++++++++++++++++++++
//---------------------------------------------------------------
//  status: finished

class ClientController extends BaseController
{
//------------------- FUNCTIONS -------------------
    private function getByID($id){
        $clientModel = new ClientModel();

        $client = $clientModel->getThis($id);

        return json_encode($client); 
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
                //default values           
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

                $clientModel = new ClientModel();

                $fromTable = $clientModel->get($by, $order, $intLimit, $offset);

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

                    $clientModel = new ClientModel();

                    $client = $clientModel->getBy($where, $is);
                
                    $responseData = json_encode($client); 

                    if(empty($responseData)){
                        $responseData = json_encode(['success' => false, 'message' => 'client not found']);
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
                // Extract input fields
                $name = $arrParams['name'] ?? null;
                $width = $arrParams['width'] ?? null;
                $height = $arrParams['height'] ?? null;
                $xPosition = $arrParams['xPosition'] ?? null;
                $yPosition = $arrParams['yPosition'] ?? null;
                $status = (isset($arrParams['status'])) ? 1 : 0;
                $times_used = 0 ?? null;
                $last_used = null;
                $joined_at = date('Y-m-d H:i:s') ?? null;

                $clientModel = new ClientModel();
                //add client with user model
                $newClientId = $clientModel->add($name, $width, $height, $xPosition, $yPosition, $status, $times_used, $last_used, $joined_at);

                //success message
                if ($newClientId > 0) {                        
                    $responseData = json_encode(['success' => true, 'message' => 'Client added successfully', 'newID' => $newClientId]);
                } else {
                    $responseData = json_encode(['success' => false, 'message' => 'Could not add Client']);
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
                        $responseData = json_encode(['success' => false, 'message' => 'Client with id '. $id .' not found.']);
                    }
                    else{
                        $name = (is_array($arrParams) && isset($arrParams['name']) && $arrParams['name']) ? $arrParams['name'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->name)) ? $dataToUpdate[0]->name 
                        : null);

                        $width = (is_array($arrParams) && isset($arrParams['width']) && $arrParams['width']) ? $arrParams['width'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->width)) ? $dataToUpdate[0]->width 
                        : null);

                        $height = (is_array($arrParams) && isset($arrParams['height']) && $arrParams['height']) ? $arrParams['height'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->height)) ? $dataToUpdate[0]->height 
                        : null);

                        $xPosition = (is_array($arrParams) && isset($arrParams['xPosition']) && $arrParams['xPosition']) ? $arrParams['xPosition'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->xPosition)) ? $dataToUpdate[0]->xPosition 
                        : null);

                        $yPosition = (is_array($arrParams) && isset($arrParams['yPosition']) && $arrParams['yPosition']) ? $arrParams['yPosition'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->yPosition)) ? $dataToUpdate[0]->yPosition 
                        : null);

                        $status = (is_array($arrParams) && isset($arrParams['client_status']) && $arrParams['client_status']) ? $arrParams['client_status'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->client_status)) ? $dataToUpdate[0]->client_status 
                        : null);

                        $times_used = (is_array($arrParams) && isset($arrParams['times_used']) && $arrParams['times_used']) ? $arrParams['times_used'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->times_used)) ? $dataToUpdate[0]->times_used 
                        : null);

                        $last_used = (is_array($arrParams) && isset($arrParams['last_used']) && $arrParams['last_used']) ? $arrParams['last_used'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->last_used)) ? $dataToUpdate[0]->last_used 
                        : null);

                        $joined_at = (is_array($arrParams) && isset($arrParams['joined_at']) && $arrParams['joined_at']) ? $arrParams['joined_at'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->joined_at)) ? $dataToUpdate[0]->joined_at 
                        : null);

                        $clientModel = new ClientModel();
                        //update client with userModel
                        $result = $clientModel->updateThis($id, $name, $width, $height, $xPosition, $yPosition, $status, (int)$times_used, $last_used, $joined_at);
                    

                        //success message
                        if ($result > 0) {
                            $responseData = json_encode(['success' => true, 'message' => 'Client with id '. $id .' updated successfully']);
                        } else {
                            $responseData = json_encode(['success' => false, 'message' => 'No rows affected or Client with id '. $id .' not found.']);
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

    public function updateStatusAction(){
        
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrParams = $this->getPostParams();

        if (strtoupper($requestMethod) == 'POST' && $arrParams) {
            try {
                if (isset($arrParams['id']) && $arrParams['id']) {
                    $id = $arrParams['id'];
                    

                        $status = (is_array($arrParams) && isset($arrParams['client_status']) && $arrParams['client_status']) ? 1 : 0; 

                        $clientModel = new ClientModel();
                        //update client with userModel
                        $result = $clientModel->updateStatus($id, $status);
                    

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

                    $clientModel = new ClientModel();
                    //update client with userModel
                    $result = $clientModel->updateUsed($id, $time, $used);
                
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
                    $clientModel = new ClientModel();

                    $affectedRows = $clientModel->deleteThis($id);

                    if ($affectedRows > 0) {
                        $responseData = json_encode(['success' => true, 'message' => 'Client with id '. $id . ' deleted successfully']);
                    } else {
                        $responseData = json_encode(['success' => false, 'message' => 'Client with id '. $id . ' not found']);
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
            $this->sendOutput($responseData, ['Content-Type: application/json', 'HTTP/1.1 200 OK']);
        } else {
            $this->sendOutput(json_encode(['error' => $strErrorDesc]), ['Content-Type: application/json', $strErrorHeader]);
        }
    }
} 