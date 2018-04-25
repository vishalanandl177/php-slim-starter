<?php  
//session_start();
/*
  Module                      : Index
  File name                   : index.php
  Description                 : All routes are defined here.
 */

require_once 'library/Slim/Slim/Slim.php';
require_once 'src/config/config.php';
require_once 'src/config/connect.php';
require_once 'src/config/messages.php';
require_once 'src/config/jsontags.php';
require_once 'src/config/errorcodes.php';
use Slim\Slim;
Slim::registerAutoloader();

$Rest = new Slim();

include ('autoload.php');

require 'library/vendor/autoload.php';
                                                                

$DeviceCtr = new DeviceController();

$Rest->get('/get-call', array($DeviceCtr, 'getCall'));
$Rest->post('/post-call', array($DeviceCtr, 'postCall'));

$Rest->run();
?>