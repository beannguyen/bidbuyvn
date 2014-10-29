<?php
class registerController extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->loadModel('register');
    }

    function index( $alert = false )
    {
        $this->loadModel('login');
        if ($this->gen->guestOnly()) { // Only guest can view this page
            header('location: ' . URL::get_site_url());
        } else {
            $this->view->title = 'Đăng ký tài khoản';
            $this->view->alert = $alert;
            $this->view->render('dashboard/register');
        }
    }

    function isExistedLevelName()
    {
        if(isset($_POST['level-name']))
        {
            $levelname = $_POST['level-name'];
            if(isset($_POST['modify']))
            {
                $level_id = $_POST['level-id'];
                echo $this->model->isExistedLevelName($levelname, true, $level_id);
            } else {
                echo $this->model->isExistedLevelName($levelname);
            }

        } else
            echo 'not_found'; // can not get username
    }

    function isExistedLevel()
    {
        if(isset($_POST['level-level']))
        {
            $level = $_POST['level-level'];
            if(isset($_POST['modify']))
            {
                $level_id = $_POST['level-id'];
                echo $this->model->isExistedLevel($level, true, $level_id);
            } elseif (isset($_POST['level-level'])) {
                echo $this->model->isExistedLevel($level);
            }

        } else
            echo 0; // can not get username
    }

    function isExistedUsername()
    {
        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            echo $this->model->isExistedUsername($username);
        } else
            echo 0; // can not get username
    }

    function isExistedEmail()
    {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            echo $this->model->isExistedEmail($email);
        } else
            echo 0; // can not get username
    }

    /**
     * Admin add new user from backend
     */
    function adminAddNewUser()
    {
        // Has the form been submitted?
        if(!empty($_POST)) {

            // Sign up form post data
            foreach ($_POST as $field => $value)
                $settings[$field] = parent::secure($value);

            $result = $this->model->addNewProcess($settings);
            if($result == 'EMAIL_NOT_SEND')
            {
                $this->view->p = $result;
                $this->view->render('dashboard/error');
            } else
            {
                echo 1;
            }

        }
    }

    /**
     *
     */
    function registerProcess()
    {
        // Has the form been submitted?
        if(!empty($_POST)) {

            // basic information
            $settings['username'] = parent::secure( $_POST['username'] );
            $settings['password'] = parent::secure( $_POST['password'] );
            $settings['user_group'] = parent::secure( $_POST['user_group'] );
            $settings['name'] = parent::secure( $_POST['fullname'] );
            $settings['email'] = parent::secure( $_POST['email'] );
            var_dump($settings);
            //
            $metas['sex'] = parent::secure( $_POST['gender'] );
            $metas['date_of_birth'] = parent::secure( $_POST['dayofbirth'] );
            $metas['phone_num'] = parent::secure( $_POST['phonenum'] );
            $metas['address'] = parent::secure( $_POST['address'] );
            $metas['city'] = parent::secure( $_POST['city'] );
            $metas['country'] = parent::secure( $_POST['country'] );
            var_dump($metas);

            $response = $this->model->registerProcess( $settings, $metas );
            // after register
            if ( $response === 'done' ) {

                $_SESSION['bidbuy']['register'] = 'done';
            } else {

                $_SESSION['bidbuy']['register'] = 'failed';
            }
            URL::redirect_to( URL::get_site_url() . '/admin/login' );
        }
    }

    function adminAddNewGroup()
    {
        $options = array(
            'level_level' => parent::secure($_POST['level-level']),
            'level_name' => parent::secure($_POST['level-name'])
        );

        // Create the level
        if(isset($_POST['modify']))
        { // loi roi
            $options['level_id'] = parent::secure($_POST['level-id']);
            $options['disable_level'] = parent::secure($_POST['disable-level']);
            if(isset($_POST['delete-level']) && $_POST['delete-level'] == '1')
                echo $this->model->modifyLevel($options, true);
            else
                echo $this->model->modifyLevel($options);
        } else
            echo $this->model->addlevel($options);
    }

    function modifyPermission()
    {
        if(isset($_POST['permission']))
        {
            foreach($_POST as $k => $v)
            {
                $permission[$k] = $v;
            }
            echo $this->model->modifyPermission($permission);
        } else
            echo 'error';
    }

}