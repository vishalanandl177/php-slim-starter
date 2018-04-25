<?php
/*
  File name                   : DeviceManager.php
  Description                 : DeviceManager class for Device related activities
 */

   
class DeviceManager {
      
    

    /*
      Function            : getCall()
      Brief               : Function to get data
      Details             : Function to get data
      Input param         : Nil
      Input/output param  : Array
      Return              : Returns array.
     */
    public function getCall(){
        
        $db                     = new ConnectionManager();
        $generalMethod          = new GeneralMethod(); 
        try {         
//            $sQuery = "SELECT * FROM tablename";
//            $db->query($sQuery);
//            //$db->bind(':user_id',$userId);
//            $row = $db->resultSet();

            $aList[JSON_TAG_RESULT]= 'success';
            $aList[JSON_TAG_STATUS] = 0;         
        } catch (Exception $e) {
            $aList[JSON_TAG_STATUS] = 1;
        }   
        return $aList;    
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
        
        $db = new ConnectionManager();
        $generalMethod = new GeneralMethod(); 
        try {         
            
            $input  = $generalMethod->sanitizeString($inData[JSON_TAG_INPUT]);
                                
            $aList[JSON_TAG_RESULT] = $input;
            $aList[JSON_TAG_STATUS] = 0;         
        } catch (Exception $e) {
            $aList[JSON_TAG_STATUS] = 1;
        }   
        return $aList;    
    }

}
?>