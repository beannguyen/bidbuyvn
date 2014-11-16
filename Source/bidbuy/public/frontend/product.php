<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(dirname(__FILE__))));

$get_category = null;
$get_slug = null;

if(isset($_GET['category']) && isset($_GET['link']))
{
    $get_category = $_GET['category'];
    $get_slug = $_GET['link'];
}

require_once (ROOT . DS . 'config' . DS . 'config.php');
require (ROOT . DS . 'library' . DS . 'frontend/single.php');