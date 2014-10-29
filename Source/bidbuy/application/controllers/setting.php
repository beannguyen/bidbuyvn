<?php
class settingController extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->loadModel('setting');
    }

    function updateSetting()
    {
        foreach ( $_POST as $key => $value )
        {
            $settings[$key] = $value;
        }

        $this->model->updateSetting($settings);

        echo 1;
    }
}