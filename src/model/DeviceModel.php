<?php
/*
  File name                   : DeviceModel.php
  Description                 : Model class for Lab related activities
 */

class DeviceModel {



    /*
      Function            : statusHandler()
      Brief               : Function to handle JSON_TAG_STATUS
      Details             : Function to handle JSON_TAG_STATUS
      Input param         : 
      Input/output param  : 
      Return              :
      */

      public function statusHandler($aList){
        
        $statusCode = $aList[JSON_TAG_STATUS];
        $aResult = array();
        
        switch ($statusCode) {
          case 1:
              // Function to set the header on server error
               $aResult = $this->httpStatusServer();
            break;
          case 2:
              //Function for result response on failure with error code and description
                $aResult = $this->responseResult(ERRCODE_ERROR,MANDATORY_FIELD_REQUIRED);
            break;
          case 3:
                // Function for respond on custom messages
                $aResult = $this->responseResult(ERRCODE_ERROR,$aList[JSON_TAG_CUSTOM_MSG]);
            break;
          default:
                $aResult = $this->responseResult(ERRCODE_ERROR,ERROR_DEFAULT);
        }
        return $aResult;

      }

           
     /*
      Function            : responseResult($errorCode,$errorDesc)
      Brief               : Function for result response for failure
      Details             : Function for result response for failure with error code and description
      Input param         : $errorCode,$errorDesc
      Input/output param  : $aResult
      Return              : Returns array.
     */    
    public function responseResult($errorCode,$errorDesc){
        $aResult = array(JSON_TAG_STATUS => JSON_TAG_ERROR,
                  JSON_TAG_DESC => $errorDesc);
        $this->httpStatus(ERRCODE_CLIENT_REFUSED);   
        return $aResult;
     }

     /*
      Function            : httpStatus($statusCode,$customCode)
      Brief               : Function to set the header 
      Details             : Function to set the header
      Input param         : $statusCode,$customCode
      Input/output param  : $aResult
      Return              : Returns array.
     */   
    public function httpStatus($statusCode){
        $instance = \Slim\Slim::getInstance();    
        $instance->status($statusCode);
    }
    
     /*
      Function            : httpStatusServer()
      Brief               : Function to set the header for server error
      Details             : Function to set the header for server error
      Input param         : Nil
      Input/output param  : $aResult
      Return              : Returns array.
     */    
    public function httpStatusServer(){
        $aResult = array(JSON_TAG_STATUS => JSON_TAG_ERROR,
                JSON_TAG_DESC => SERVER_EXCEPTION);
        $instance = \Slim\Slim::getInstance();    
        $instance->status(ERRCODE_SERVER);
        return $aResult;
    }   
       
    

    /*
      Function            : getCall()
      Brief               : Function to get data
      Details             : Function to get data
      Input param         : Nil
      Input/output param  : Array
      Return              : Returns array.
     */
    public function getCall(){
        $deviceManager = new DeviceManager();        
        $aResult = array();
        $aList   = array();
        $aList   = $deviceManager->getCall();
        if ($aList[JSON_TAG_STATUS] == 0) {
                $aResult = array(JSON_TAG_STATUS => JSON_TAG_SUCCESS,
                    JSON_TAG_RECORDS => $aList[JSON_TAG_RESULT]);
            } elseif ($aList[JSON_TAG_STATUS] == 1) {
                $aResult = $this->httpStatusServer();
            }
        return $aResult;
    }


       
    /*
      Function            : postCall()
      Brief               : Function to post data
      Details             : Function to post data
      Input param         : Nil
      Input/output param  : Array
      Return              : Returns array.
     */
    public function postCall($inData){
        
        $deviceManager = new DeviceManager();        
        $aResult = array();
        $aList   = array();
        $aList   = $deviceManager->postCall($inData);
            if ($aList[JSON_TAG_STATUS] == 0) {
                $aResult = array(JSON_TAG_STATUS => JSON_TAG_SUCCESS,
                    JSON_TAG_RECORDS => $aList[JSON_TAG_RESULT]);
            } else{
                $aResult = $this->statusHandler();
            }
        return $aResult;
    } 
   
}

?>