<?php

class userController extends Controller
{
    private $error;
    private $options = array();

    function __construct()
    {
        parent::__construct();
        $this->loadModel('user');
    }

    function admUpdateProfile()
    {
        $info = array(
            'name' => '',
            'email' => ''
        );
        $meta = array(
            'date_of_birth' => '',
            'sex' => '',
            'phone_num' => '',
            'job_title' => '',
            'address' => '',
            'city' => '',
            'country' => '',
            'website_url' => '',
            'yahoo_im' => '',
            'skype' => '',
            'about' => ''
        );
        $userId = $_POST['userId'];
        // Update user info
        foreach($info as $key => $value)
        {
            $info[$key] = $this->gen->secure( $_POST[$key] );
        }
        // Update user meta
        foreach($meta as $key => $value)
        {
            $meta[$key] = $_POST[$key];
        }
        $res = $this->model->updateProfileSetting($userId, $info, $meta);
        if($res)
            echo 1;
    }
    function changePassword()
    {
        $generic = new Generic();
        $userId = $_POST['userId'];
        $newpass = $generic->hashPassword($_POST['newpassword']);

        $res = $this->model->changePassword($userId, $newpass);
        if($res)
            echo 1;
        else
            echo 0;
    }

    function admChangeUserPermission()
    {
        $options['user_id'] = parent::secure($_POST['user_id']);
        $options['user_level'] = parent::secure($_POST['user_level']);
        $options['disable_user'] = parent::secure($_POST['disable_user']);

        if(isset($_POST['delete_user']) && $_POST['delete_user'] == 1)
        {
            echo $this->model->admChangeUserPermission(true, $options);
        } else
            echo $this->model->admChangeUserPermission(false, $options);
    }

    public function returnAllLevels()
    {
        echo $this->model->returnAllLevels();
    }

    function updateGeneralOptions($refer = '')
    {
        // Once the form has been processed
        if(!empty($_POST)) {
            foreach ($_POST as $key => $value)
                $this->options[$key] = parent::secure($value);

            // Validate fields
            $this->validate();

            // Process form
            $result = empty($this->error) ? $this->model->updateGeneralOptionsProcess($this->options) : $this->error;

            //$this->view->p = var_dump($result);
            URL::redirect_to(URL::get_site_url() . '/admin/user_setting#' . $refer);
            exit();

        }
    }

    // Validate the submitted information
    private function validate() {

        $checkboxes = array();
        if(!empty($_POST['denied-form'])) {
            $checkboxes[] = 'block-msg-enable';
            $checkboxes[] = 'block-msg-out-enable';
        }
        if(!empty($_POST['general-options-form'])) {
            $checkboxes[] = 'user-activation-enable';
            $checkboxes[] = 'notify-new-user-enable';
            $checkboxes[] = 'disable-registrations-enable';
            $checkboxes[] = 'disable-logins-enable';
            $checkboxes[] = 'email-as-username-enable';
            $checkboxes[] = 'pw-encrypt-force-enable';
            $checkboxes[] = 'signin-redirect-referrer-enable';
            $checkboxes[] = 'signout-redirect-referrer-enable';
            $checkboxes[] = 'email-welcome-disable';
        }
        if(!empty($_POST['integration-form'])) {
            $checkboxes[] = 'integration-facebook-enable';
            $checkboxes[] = 'integration-google-enable';
            $checkboxes[] = 'integration-twitter-enable';
            $checkboxes[] = 'integration-yahoo-enable';
        }
        if(!empty($_POST['update-form'])) {
            $checkboxes[] = 'update-check-enable';
        }
        if(!empty($_POST['user-profiles-form'])) {
            $checkboxes[] = 'profile-display-email-enable';
            $checkboxes[] = 'profile-display-name-enable';
            $checkboxes[] = 'profile-public-enable';
            $checkboxes[] = 'profile-timestamps-admin-enable';
            $checkboxes[] = 'profile-timestamps-enable';
        }

        foreach($checkboxes as $label)
            $this->options[$label] = !empty($this->options[$label]) ? 1 : 0;


        //$this->options['default-level'] = !empty($this->options['default-level']) ? serialize($this->options['default-level']) : serialize(array('3'));
        $this->options['restrict-signups-by-email'] = !empty($this->options['restrict-signups-by-email']) ? serialize(preg_split ('/,/', $this->options['restrict-signups-by-email'])) : '';

    }

    function activeSeller( $userId )
    {
        // change user to seller group
        $level = 2;
        $response = $this->model->changeGroup( $userId, $level );

        URL::goBack();
        exit();
    }
}