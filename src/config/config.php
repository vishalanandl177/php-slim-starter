<?php
//To supress the errors
error_reporting(1);
ini_set('display_errors', 1);
/*
  Module                      : NA
  File name                   : config.php
  Description                 : Contains configuration settings used in the project codes.
 */
/*********Credentials*********/
define("DBTYPE","mysql");
//define("SERVER", "PRODUCTION");
define("SERVER", "DEVELOPMENT");

define("TIMEZONE", "UTC");

header('Content-Type: text/html; charset=utf-8');
ini_set('max_execution_time', 0); 
date_default_timezone_set(TIMEZONE);
?>