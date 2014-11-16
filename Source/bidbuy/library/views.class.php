<?php

class View
{
    function __construct() {}

    public function render($name, $noInclude = false)
    {
        require 'application/views/' . $name . '.php';
    }
}