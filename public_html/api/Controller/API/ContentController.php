<?php
//----------------------------------------------------------------
//+++++++++++++++++++++  CONTENT CONTROLLER  +++++++++++++++++++++
//----------------------------------------------------------------
//  status: finished

class ContentController extends BaseController
{
//------------------- FUNCTIONS -------------------

    private function getByID($id){
        $contentModel = new ContentModel();
    
        $content = $contentModel->getThis($id);

        return json_encode($content); 
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

                $contentModel = new ContentModel();
    
                $content = $contentModel->get($by, $order, $limit, $offset);

                $responseData = json_encode($content); 
                
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

    public function getInfoAction(){
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

                $contentModel = new ContentModel();
    
                $content = $contentModel->getInfo($by, $order, $limit, $offset);

                $responseData = json_encode($content); 
                
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

                    $contentModel = new ContentModel();

                    $content = $contentModel->getBy($where, $is);

                    $responseData = json_encode($content); 

                    if(empty($responseData)){
                        $responseData = json_encode(['success' => false, 'message' => 'content not found']);
                    }
                }else{
                    $responseData = json_encode(['success' => false, 'message' => 'no id']);
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

                    if(empty($responseData)){
                        $responseData = json_encode(['success' => false, 'message' => 'id ' . $id . ' not found']);
                    }
                }else{
                    $responseData = json_encode(['success' => false, 'message' => 'no id']);
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
                $arrParams = $this->getPostParams();
                
                // Extract input fields
                $name = $arrParams['name'] ?? null;
                $type = $arrParams['type'] ?? null;
                $width = $arrParams['width'] ?? null;
                $height = $arrParams['height'] ?? null;
                $data = $arrParams['data'] ?? null;
                $duration = $arrParams['duration'] ?? null;
                $times_used = 0 ?? null;
                $last_use = null;
                $added_by = $arrParams['added_by'] ?? null;
                $added_at = date('Y-m-d H:i:s') ?? null;

                $contentModel = new ContentModel();
                //add content with user model
                $newContentId = $contentModel->add($name, $type,  $width, $height, $data, $duration, $times_used, $last_use, $added_by, $added_at);
                         
                //success message
                if ($newContentId > 0) {
                    $responseData = json_encode(['success' => true, 'message' => 'Content added successfully', 'newID' => $newContentId]);
                } else {
                    $responseData = json_encode(['success' => false, 'message' => 'Could not add Content']);
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
                        $responseData = json_encode(['success' => false, 'message' => 'dataToUpdate is empty -> no Content to update']);
                    }
                    else{

                        $name = (is_array($arrParams) && isset($arrParams['name']) && $arrParams['name']) ? $arrParams['name'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->name)) ? $dataToUpdate[0]->name 
                        : null);

                        $type = (is_array($arrParams) && isset($arrParams['type']) && $arrParams['type']) ? $arrParams['type'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->type)) ? $dataToUpdate[0]->type 
                        : null);

                        $width = (is_array($arrParams) && isset($arrParams['width']) && $arrParams['width']) ? $arrParams['width'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->width)) ? $dataToUpdate[0]->width 
                        : null);

                        $height = (is_array($arrParams) && isset($arrParams['height']) && $arrParams['height']) ? $arrParams['height'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->height)) ? $dataToUpdate[0]->height 
                        : null);

                        $data = (is_array($arrParams) && isset($arrParams['data']) && $arrParams['data']) ? $arrParams['data'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->data)) ? $dataToUpdate[0]->data 
                        : null);

                        $duration = (is_array($arrParams) && isset($arrParams['duration']) && $arrParams['duration']) ? $arrParams['duration'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->duration)) ? $dataToUpdate[0]->duration 
                        : null);

                        $times_used = (is_array($arrParams) && isset($arrParams['times_used']) && $arrParams['times_used']) ? $arrParams['times_used'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->times_used)) ? $dataToUpdate[0]->times_used 
                        : null);

                        $last_use = (is_array($arrParams) && isset($arrParams['last_use']) && $arrParams['last_use']) ? $arrParams['last_use'] 
                        : ((is_array($dataToUpdate) && isset($dataToUpdate[0]->last_use)) ? $dataToUpdate[0]->last_use 
                        : null);

                        $contentModel = new ContentModel();
                        $result = $contentModel->updateThis($id, $name, $type,  $width, $height, $data, $duration, $times_used, $last_use);
                        
                        //success message
                        if ($result > 0) {
                            $responseData = json_encode(['success' => true, 'message' => 'Content with id '. $id .' updated successfully']);
                        } else {
                            $responseData = json_encode(['success' => false, 'message' => 'No rows affected or content not found.']);
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

                        $contentModel = new ContentModel();
                        //update client with userModel
                        $result = $contentModel->updateUsed($id, $time, $used);
                    
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
                // Get the ID from the query string parameters
                $id = $arrParams['id'] ?? null;

                // Basic validation
                if (!$id) {
                    $responseData = json_encode(['success' => false, 'message' => 'ID is required !']);
                }else{
                    $contentModel = new ContentModel();
                    $affectedRows = $contentModel->deleteThis($id);

                    if ($affectedRows > 0) {
                        $responseData = json_encode(['success' => true, 'message' => 'Content with id '. $id . ' deleted successfully']);
                    } else {
                        $responseData = json_encode(['success' => false, 'message' => 'Content with id '. $id . ' not found']);
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
?>