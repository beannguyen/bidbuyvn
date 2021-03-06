<?php

class Controller extends Generic
{
    function __construct()
    {
        $this->view = new View();
        $this->gen = new Generic();
    }

    /**
     * @param $name
     * @param string $modelPath
     */
    public function loadModel($name, $modelPath = 'application/models/') {

        $path = $modelPath . $name.'_model.php';
        if (file_exists($path)) {
            require $modelPath .$name.'_model.php';

            $modelName = $name . '_Model';
            $this->model = new $modelName();
        }
    }
}