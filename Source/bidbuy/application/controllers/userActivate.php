<?php

class userActivateController extends Controller
{
    private $error;
    private $key;

    function __construct()
    {
        parent::__construct();


        // Assign their username to a variable
        if(isset($_SESSION['ssbidbuy']['username']))
            $this->user = $_SESSION['ssbidbuy']['username'];
    }

    function index()
    {

    }

}