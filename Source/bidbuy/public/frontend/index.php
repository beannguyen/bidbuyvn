<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(dirname(__FILE__))));

$get = null;
if( isset($_GET['get']) )
{
    $get = $_GET['get'];
}

$http_error = null;
if ( isset( $_GET['http_error'] ) && $_GET['http_error'] === '404' )
{
    $http_error = true;
}

require_once (ROOT . DS . 'config' . DS . 'config.php');
require (ROOT . DS . 'library' . DS . 'frontend/index.php');