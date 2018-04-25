<?php
/*
  File name                   : DeviceController.php 
  Description                 : Controller class for Lab related activities
 */

class DeviceController {
    
    /*
      Function            : paramMissing($instance)
      Brief               : Function for Missing Param
      Details             : Function for Missing Param
      Input param         : $instance
      Return              : Returns array.
     */      
    public function paramMissing($instance){
        $result = array(JSON_TAG_STATUS => JSON_TAG_ERROR,
                        JSON_TAG_DESC => INSUFFICIENT_PARAM);   
        $instance->response()->header(CUSTOM_ERROR_CODE, ERRCODE_INSUFFICIENT_PARAM);
        $instance->status(ERRCODE_CLIENT);
        return $result;
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
        $deviceModel = new DeviceModel();
        $genMethod = new GeneralMethod();
        $result = $deviceModel->getCall();   
        $genMethod->generateResult($result);
    }

    /*
      Function            : postCall()
      Brief               : Function to post data
      Details             : Function to post data
      Input param         : Nil
      Input/output param  : Array
      Return              : Returns array.
     */
    public function postCall(){
        $deviceModel = new DeviceModel();
        $genMethod = new GeneralMethod();
        $instance = \Slim\Slim::getInstance();
        $bodyData = $instance->request()->getBody();
        
        $inData = json_decode($bodyData, true);

            if (is_array($inData) && array_key_exists(JSON_TAG_INPUT, $inData)
               ) {
                $result = $deviceModel->postCall($inData);   
            } else {  $result = $this->paramMissing($instance);}
        $genMethod->generateResult($result);
    }

}
   
?>