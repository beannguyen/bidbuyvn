<?php

class errorController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }
    function errHandler($errorMsg = "Hệ thống đã xảy ra một số lỗi", $errorName = "Lỗi hệ thống")
    {
        $this->view->title = 'Lỗi';
        $this->view->errName = $errorName;
        $this->view->errDetail = $errorMsg;

        $this->view->render('dashboard/header');
        $this->view->render('dashboard/error/showError');
        $this->view->render('dashboard/footer');

    }
    function notFoundHandler()
    {
        $this->view->render('dashboard/error/404error');
    }
}