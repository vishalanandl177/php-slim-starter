<?php
/*
  Module                      : Autoload
  File name                   : autoload.php
  Description                 : Autoloading of required classes and libraries are handled here
 */
spl_autoload_register(null, false);

function class_autoloader($inClass) {
    $sClass = str_replace('_', '/', $inClass);
    $sUtilsClass ='';
    $sUtilsClass = dirname(__FILE__) . '/src/utils/' . $sClass . '.php'; 
    $sCtrClass = dirname(__FILE__) . '/src/controller/' . $sClass . '.php';
    $sDBClass = dirname(__FILE__) . '/src/dbmanager/' . $sClass . '.php';
    $sModelClass = dirname(__FILE__) . '/src/model/' . $sClass . '.php';
    if (file_exists($sCtrClass) && require_once($sCtrClass)) {
        return TRUE;
    } else if (file_exists($sDBClass) && require_once ($sDBClass)) {
        return TRUE;
    } else if (file_exists($sModelClass) && require_once ($sModelClass)) {
        return TRUE;
    } else if (file_exists($sUtilsClass) && require_once ($sUtilsClass)) {
        return TRUE;
    } else if ($sClass=='FacebookSession' ||$sClass=='FacebookRequest'||  $sClass=='FacebookRequest' ) {
        return TRUE;
    }
    else {
        trigger_error("The class '$inClass'  failed to spl_autoload  ", E_USER_WARNING);
        return FALSE;
    }
}
spl_autoload_register('class_autoloader'); 
?>