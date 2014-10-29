<?php

class Model extends Generic
{
    public $db;

    function __construct()
    {
        $this->db = parent::dbObj();
        $this->gen = new Generic();
    }
}