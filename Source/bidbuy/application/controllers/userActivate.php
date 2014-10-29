<?php

class userActivateController extends Controller
{
    private $error;
    private $key;

    function __construct()
    {
        parent::__construct();


        // Assign their username to a variable
        if(isset($_SESSION['jigowatt']['username']))
            $this->user = $_SESSION['jigowatt']['username'];
    }

    function index()
    {

    }

}