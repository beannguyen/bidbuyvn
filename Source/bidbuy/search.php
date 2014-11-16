<?php

// Also spl_autoload_register (Take a look at it if you like)
function __autoload($class) {
    require 'library/' . strtolower($class) ."s.class.php";
}

require_once ('public/frontend' . DIRECTORY_SEPARATOR . 'search.php');