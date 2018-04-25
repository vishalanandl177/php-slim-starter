<?php
/*
  Module                      : General
  File name                   : GeneralMethod.php
  Description                 : General utility functions
 */

class GeneralMethod {

    //put your code here
    public function __construct() {
        
    }

    /*
      Function            : generateResult($inRes)
      Brief               : Function used to display the result in json format.
      Details             : Function used to display the result in json format.
      Input param         : res - result in array
      Input/output param  : Nil
      Return              : Outputs Json data
     */

    public function generateResult($inaRes) {
        $Req = \Slim\Slim::getInstance();
        $Req->contentType('application/json');
        echo json_encode($inaRes);
    }

    /*
      Function            : decodeJson($injData)
      Brief               : Function used to decode input json.
      Details             : Function used to decode input json.
      Input param         : Json data
      Input/output param  : Nil
      Return              : Outputs array
     */

    public function decodeJson($injData) {
        $bvalid = true;
        if ($injData == "" || !$injData) {
            $bvalid = false;
        } else {
            $aDecoded = json_decode($injData, true);
            if (!is_array($aDecoded))
                $bvalid = false;
        }

        if ($bvalid)
            return $aDecoded;
        else {
            return array(
                JSON_TAG_TYPE => JSON_TAG_ERROR,
                JSON_TAG_CODE => NULL,
                JSON_TAG_DESC => INVALID_JSON,
                JSON_TAG_ERRORS => array()
            );
        }
    }

    /*
      Function            : bCrypt($insPassword, $sSalt)
      Brief               : Function used to encode the password into BCrypt format.
      Details             : Function used to encode the password into BCrypt format using the salt data from database.
      Input param         : $insPassword - input password, $sSalt - salt data retrieved from database.
      Input/output param  : Nil
      Return              : Outputs hashed password.
     */

    public function bCrypt($insPassword, $sSalt) {

        //This string tells crypt to use blowfish for 5 rounds.
        $Blowfish_Pre = '$2a$05$';
        $Blowfish_End = '$';
        $bcrypt_salt = ($Blowfish_Pre . $sSalt . $Blowfish_End);

        $hashed_password = crypt($insPassword, $bcrypt_salt);
        return $hashed_password;
    }

    /*
      Function            : createHashedPassword($sPassword)
      Brief               : Function used to create hashed password.
      Details             : Function used to create hashed password.
      Input param         : $sPassword - password
      Input/output param  : Nil
      Return              : Outputs hashed password.
     */

    public function createHashedPassword($sPassword) {

        $aData = array();
        $Blowfish_Pre = '$2a$05$';
        $Blowfish_End = '$';

        $Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
        $Chars_Len = 63;

        // 18 would be secure as well.
        $Salt_Length = 21;

        //$mysql_date = date('Y-m-d');
        $salt = "";

        for ($i = 0; $i < $Salt_Length; $i++) {
            $salt .= $Allowed_Chars[mt_rand(0, $Chars_Len)];
        }
        $bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;

        $hashed_password = crypt($sPassword, $bcrypt_salt);
        $aData['hashedPass'] = $hashed_password;
        $aData['salt'] = $salt;

        return $aData;
    }

    /*
      Function            : generateUUID()
      Brief               : Function used to generate UUID.
      Details             : Function used to generate UUID.
      Input param         : Nil
      Input/output param  : Nil
      Return              : Outputs UUID v4.
     */

    public function generateUUID() {

        // http://www.php.net/manual/en/function.uniqid.php#94959

        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                // 32 bits for "time_low"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                // 16 bits for "time_mid"
                mt_rand(0, 0xffff),
                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                mt_rand(0, 0x0fff) | 0x4000,
                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                mt_rand(0, 0x3fff) | 0x8000,
                // 48 bits for "node"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /*
      Function            : sanitizeString($insString)
      Brief               : Function used to sanitize input string.
      Details             : Function used to sanitize input string.
      Input param         : String
      Input/output param  : Nil
      Return              : Outputs sanitized string.
     */

    public function sanitizeString($insString) {
       $insString = strip_tags($insString); 
        if (get_magic_quotes_gpc())
            $insString = stripslashes($insString);
        $insString =  trim($insString);
        return $insString;
    }

    /*
      Function            : isValidDate( $postedDate )
      Brief               : Function used to check date.
      Details             : Function used to check date.
      Input param         : String
      Input/output param  : Nil
      Return              : bool
     */

    public function isValidDate($postedDate) {
        if (preg_match('/^[0-9]{4}-([0-9]|0[1-9]|1[0-2])-([0-9]|0[1-9]|[1-2][0-9]|3[0-1])$/', $postedDate)) {
            list($year, $month, $day) = explode('-', $postedDate);
            return checkdate($month, $day, $year);
        } else {
            return false;
        }
    }

    /*
      Function            : isValidDatetime($dateTime)
      Brief               : Function used to check date time object
      Details             : Function used to check date time object
      Input param         : String
      Input/output param  : Nil
      Return              : bool
     */

    public function isValidDatetime($dateTime) {
        $matches = array();
        // if(preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $dateTime, $matches)){
        if (preg_match("/^(\d{4})-([0-9]|0[1-9]|1[0-2])-([0-9]|0[1-9]|[1-2][0-9]|3[0-1]) ([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $dateTime, $matches)) {

            // print_r($matches); echo "<br>";
            $yy = trim($matches[1]);
            $mm = trim($matches[2]);
            $dd = trim($matches[3]);
            return checkdate($mm, $dd, $yy); // <- Problem here?
        } else {
//        echo "wrong format<br>";
            return false;
        }
    }

    /*
      Function            : emptyElementExists($arr)
      Brief               : Function used to verify whether an array has null element.
      Details             : Function used to verify whether an array has null element.
      Input param         : array
      Input/output param  : Nil
      Return              : bool
     */

    public function emptyElementExists($arr) {
        //If one or more elements of an array contains null values then this function returns true.
        return array_search("", $arr) !== false;
    }

    
    function generateUniqueFileName($length = 12){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        
        $uniqFileName = md5($randomString.time());
        
        return $uniqFileName;        
    }
    
    function generateUniqueQRKey() {
        
        $uniqKey = md5(uniqid().time());
        
        return $uniqKey;
    }

    
}

?>
