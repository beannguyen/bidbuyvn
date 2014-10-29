<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(dirname(__FILE__))));

$url = null;
if(isset($_GET['url']))
{
    $url = $_GET['url'];
    $url = rtrim($url, '/');
}

require (ROOT . DS . 'library' . DS . 'bootstrap.php');
