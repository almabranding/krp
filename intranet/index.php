<?php
//error_reporting(0);
require 'config.php';
require 'util/Auth.php';
require ROOT.'../libs/SIU.php';
// Also spl_autoload_register (Take a look at it if you like)
function __autoload($class) {
    require LIBS . $class .".php";
}

ini_set('include_path', 'util/PEAR');
// Load the Bootstrap!
$bootstrap = new Bootstrap();

// Optional Path Settings
//$bootstrap->setControllerPath();
//$bootstrap->setModelPath();
//$bootstrap->setDefaultFile();
//$bootstrap->setErrorFile();

$bootstrap->init();
