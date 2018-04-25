<?php
/*
  Module                      : Connect
  File name                   : connect.php
  Description                 : Connecting to Production or Development Server 
 */

if(SERVER =='DEVELOPMENT'){
    define("HOST", "localhost");
    define("USER", "");
    define("PASSWORD", "");
    define("DATABASE", "");
    define("BASE_URL_STRING", getBaseUrl()); 
    
}

if(SERVER =='PRODUCTION'){
    define("HOST", "localhost");
    define("USER", "");
    define("PASSWORD", "");
    define("DATABASE", "");
    define("BASE_URL_STRING", getBaseUrl());
    
}

/*
 Function            : getBaseUrl
 Brief               : Function to get Base URL
 Details             : Function to get Base URL
 Input param         : Nil
 Input/output param  : $url
 Return              : Returns string.
*/ 

function getBaseUrl()
{
    $currentPath = $_SERVER['PHP_SELF'];$pathInfo = pathinfo($currentPath);
    $hostName = $_SERVER['SERVER_NAME'];
    $protocol =   isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
    
                $url  = $protocol."://".$hostName.$pathInfo['dirname']."/";
            if (substr($url, -1) == '/')
                    $url = substr($url, 0, -1);
return $url;
  //  return $protocol."://".$hostName.$pathInfo['dirname']."/";
}
