<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(dirname(__FILE__))));

$get_category = null;

if( isset( $_GET['category'] ) && isset( $_GET['id'] ) )
{
    $get_category['id'] = $_GET['id'];
    $get_category['query'] = $_GET['category'];
}

require_once (ROOT . DS . 'config' . DS . 'config.php');
require (ROOT . DS . 'library' . DS . 'frontend/archive.php');