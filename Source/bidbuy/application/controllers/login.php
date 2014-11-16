<?php
class loginController extends Controller
{

    // Post vars
    private $user;
    private $pass;
    private $key;

    public $error;

    public $use_emails = false;

    // Misc vars
    private $token;

    function __construct()
    {
        parent::__construct();
        // load login model
        $this->loadModel('login');

        $this->use_emails = $this->gen->getOption('email-as-username-enable');
        $this->username_type = ( $this->use_emails ) ? 'email' : 'username';
    }

    function index($alert = false, $msg = '')
    {
        if ($this->gen->guestOnly()) { // Only guest can view this page
            header('location: ' . URL::get_site_url() . '/admin');
        } else {

            $this->view->use_emails = $this->gen->getOption('email-as-username-enable');

            // Redirect the logging in user
            if ($this->gen->getOption('signin-redirect-referrer-enable'))
                $_SESSION['ssbidbuy']['referer'] = (!empty($_SESSION['ssbidbuy']['referer'])) ? $_SESSION['ssbidbuy']['referer'] : 'dashboard';
            else
                $_SESSION['ssbidbuy']['referer'] = $this->gen->getOption('signin-redirect-url');

            // Are they attempting to access a secure page?
            if ($alert == 'secure')
                $this->view->securemsg = $this->model->isSecure(true);
            elseif ( $alert === 'active_user' ) {
                $this->view->activationMsg = $msg;
            } elseif ($alert === 'resendpage' ) {
                $this->view->resendFlag = true;
            }

            // Only allow guests to view this page
            $isGuest = $this->gen->guestOnly();
            if ($isGuest) {
                URL::redirect_to(URL::get_site_url().'/admin');
            }

            // Generate a unique token for security purposes
            $this->gen->generateToken();

            $this->view->alert = $alert;
            $this->view->render('dashboard/login');
        }
    }

    function process()
    {

        // Login form post data
        if(isset($_POST['login'])) :
            $this->user = parent::secure($_POST[$this->username_type]);
            $this->pass = parent::secure($_POST['password']);

            $this->token = !empty($_POST['token']) ? $_POST['token'] : '';
            $processCheck = $this->model->process($this->user, $this->pass, $this->token);
            if( $processCheck == 'invalid_token' || $processCheck == 'error_found' || $processCheck == 'incorrect_password' || $processCheck == 'banned_user' || $processCheck == 'disable-login' || $processCheck == 'not_active')
            {
                echo $processCheck;
            } else
            {
                echo 'success';
            }
        endif;
    }

    /**
     * Get userId from email then reset user`s password
     * @param string email email of user
     * @return boolean processing status
     */
    function forgotPassword() {

        if ( isset($_POST['email'] ) ) {

            $email = $this->gen->secure( $_POST['email'] );
            // check for email is exist
            $this->loadModel( 'register' );
            if ( $this->model->isExistedEmail( $email ) ) {

                // get userId from email
                $this->loadModel( 'user' );
                $userId = $this->model->getUserIdByEmail( $email );
                // random new password
                $newpass = $this->random_password( 8 );
                // change new password
                $change = $this->model->changePassword( $userId, $this->gen->hashPassword( $newpass ) );
                if ( $change ) {

                    // if change password processing is success, send an email to user
                    $msg = $this->gen->getOption('email-forgot-msg');
                    $subj = $this->gen->getOption('email-forgot-subj');

                    // get user information
                    $user = $this->model->getUser( $userId );
                    // set value for shortcodes
                    $shortcodes = array(
                        'site_address' => URL::get_site_url(),
                        'full_name' => $user['name'],
                        'username' => $user['username'],
                        'reset' => $newpass,
                    );
                    // send an email
                    if (!$this->gen->sendEmail($user['email'], $subj, $msg, $shortcodes)) {
                        echo 'email_not_send';
                        return false;
                    }
                    // all done
                    echo 'changed';
                } else {

                    // failed
                    echo 'not_changed';
                }
            } else {

                echo 'email_not_found';
            }
        } else {

            echo 'error';
        }
        return true;
    }

    /**
     * Random a password function
     * @param int $length
     * @return string
     */
    private function random_password( $length = 8 ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }

    // Are they clicking from an email?
    function active($key)
    {
        $this->loadModel('useractive');
        if($key != '') {
            $this->key = $key;
            $key = parent::secure($key);
            $res = $this->model->getKey($key);

            $this->view->error = $res;

        } else {
            $this->view->error = 'link_not_found';
        }
        $this->view->render( 'dashboard/error/msgbox' );
    }

    // get email for resend key
    function resend() {

        if ( isset( $_POST['email-to-resend'] ) ) {
            // get email
            $email = parent::secure( $_POST['email-to-resend'] );
            // check if email is already existed
            $this->loadModel( 'register' );
            $existedUser = $this->model->isExistedEmail( $email );
            if ( $existedUser == 1 ) {
                echo $this->resendKey( $email );
            } else {
                echo 'not_exist_user';
            }
        } else {
            echo 0;
        }
    }

    // Do they want the key resent?
    function resendKey( $email )
    {
        $this->loadModel('useractive');
        echo $this->model->resendKey( $email );
    }
}