<?php

class Setting_Model extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->db->connect();
    }

    function getSettings($setting)
    {
        $value = $this->getOption($setting);
        return $value;
    }

    function updateSetting($settings)
    {
        foreach($settings as $k => $v)
        {
            $this->updateOption($k, $v);
        }
    }

    function getSiteTitle()
    {
        return $this->getOption('site_title');
    }
}