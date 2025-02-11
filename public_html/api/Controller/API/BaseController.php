<?php
class BaseController
{
    /** 
* __call magic method. 
*/
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }


    /** 
* Get URI elements. 
* 
* @return array 
*/
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );
        return $uri;
    }


    /** 
* Get querystring params. 
* 
* @return array 
*/
// only GET
    protected function getQueryStringParams()
    {
        parse_str($_SERVER['QUERY_STRING'], $query);
        return $query;
    }


    //only POST
    protected function getPostParams()
    { // Lese den raw POST-Body
        if(strtoupper($_SERVER["REQUEST_METHOD"]) == 'POST' && $_POST)
            $arrParams = $_POST;
        else{
            $rawData = file_get_contents("php://input");
        
            // Dekodiere die JSON-Daten zu einem Array
            $arrParams = json_decode($rawData, true); // true für assoziative Arrays
        }
        return $arrParams;
    } 

    
    /** 
* Send API output. 
* 
* @param mixed $data 
* @param string $httpHeader 
*/
    protected function sendOutput($data, $httpHeaders=array())
    {
        header_remove('Set-Cookie');
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        echo $data;
        exit;
    }
}