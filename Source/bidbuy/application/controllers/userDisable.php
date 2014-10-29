<?php

class userDisableController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->view->render('frontend/users/disable');
    }
}