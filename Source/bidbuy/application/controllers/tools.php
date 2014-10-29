<?php
/**
 * Class toolsController
 *
 * Xử lý các request từ Dashboard/Tools
 * Thao tác gọi đến các models
 */
class toolsController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * toolsController::dobackup()
     * gọi model dbTools::doBackup
     */
    public function dobackup()
    {
        $this->model->doBackup();
    }

    /**
     * toolsController::dorestore()
     *
     * gọi model dbTools::doRestore
     */
    public function dorestore()
    {
        $this->loadModel('dbtool');
        if(isset($_POST['fname']))
            $fname = $_POST['fname'];
        else
            $fname = '';

        $this->model->doRestore($fname);
    }
}