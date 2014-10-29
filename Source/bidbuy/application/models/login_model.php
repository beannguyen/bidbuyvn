<?php

class Login_Model extends Model
{

    // Post vars
    private $user;
    private $pass;

    public $use_emails = false;

    // Misc vars
    private $token;
    private $result;
    private $error;
    private $msg;

    function __construct()
    {
        parent::__construct();
        // Database connect
        $this->db->connect();
        // Get user login type
        $this->use_emails = parent::getOption('email-as-username-enable');
        $this->username_type = ( $this->use_emails ) ? 'email' : 'username';
    }

    public function isSecure($e = false) {

        if($e) :
            if ($this->gen->getOption('block-msg-out-enable'))
                return $msg = $this->gen->getOption('block-msg-out');
        endif;
    }

    public function process($user, $pass, $token) {

        $this->user = $user;
        $this->pass = $pass;
        $this->token = $token;

        // Check that the token is valid, prevents exploits
        if(!parent::valid_token($this->token)) {
            return 'invalid_token';
        }


        // Confirm all details are correct and fetch result
        $valid = $this->validate();
        if($valid == 1)
        {
            // Log the user in
            $result = $this->login();
            return $result;
        } else
        {
            return $valid;
        }
    }

    private function validate() {

        if(!empty($this->error)) return 'error_found';

        $username = $this->username_type;
        $stmt = $this->db->query("SELECT * FROM ".DB_PRE."login_users WHERE {$username} = '$this->user'");
        if( $this->db->numrows($stmt) == 1 )
        {
            $this->result = $this->db->fetch( $stmt );

            if( parent::getOption( 'disable-logins-enable' ) == '1' && $this->result['user_id'] !== '1' ) {

                return 'disable-login';
            } elseif ( !$this->isActivated() ) {

                return 'not_active';
            } elseif ( $this->result['restricted'] == 1 || ( $this->isDisabledLevel( unserialize( $this->result['user_level'] )[0] ) ) ) {

                return 'banned_user';
            } elseif ( !parent::validatePassword( $this->pass, $this->result['password'] ) ) {

                return 'incorrect_password';
            }
        } else
            return 'incorrect_password';

        return 1;
    }

    /**
     * Check user is disabled or not
     * @param $level
     * @return bool
     */
    private function isDisabledLevel( $level ) {

        $sql = "SELECT level_disabled FROM " . DB_PRE . "login_levels WHERE id = " . $level;
        $query = $this->db->query( $sql );
        $result = $this->db->fetch( $query );
        if( $result['level_disabled'] == 1 )
            return true;
        return false;
    }

    /**
     * Verifies if the user's account is activated.
     *
     * If the account is not activated, we redirect them to the
     * userActivate.php page where further instruction is given.
     */
    private function isActivated() {

        /* See if the admin requires new users to activate */
        if ( parent::getOption('user-activation-enable') ) {

            /** Check if user still requires activation. */
            $username = $this->username_type;
            $stmt = $this->db->query("SELECT * FROM `".DB_PRE."login_confirm` WHERE `{$username}` = '$this->user' AND `type` = 'new_user'");

            $count = $this->db->numrows($stmt);

            if ($count > 0)
                return false;

        }
        return true;
    }

    // Once everything's filled out
    public function login() {

        // Just double check there are no errors first
        if( !empty($this->error) ) return 'error_found';

        // Session expiration
        $minutes = parent::getOption('default_session');
        ini_set('session.cookie_lifetime', 60 * $minutes);

        session_regenerate_id();

        // Save if user is restricted
        if ( !empty($this->result['restricted']) ) $_SESSION['jigowatt']['restricted'] = 1;

        // Is the admin forcing a password update if encryption is not the desired method?
        if (parent::getOption('pw-encrypt-force-enable')) :

            $type = $this->getOption('pw-encryption');

            if (strlen($this->result['password']) == 32 && $type == 'SHA256')
                $_SESSION['jigowatt']['forcePwUpdate'] = 1;

            if (strlen($this->result['password']) != 32 && $type == 'MD5')
                $_SESSION['jigowatt']['forcePwUpdate'] = 1;

        endif;

        // Save user's current level
        $user_level = unserialize($this->result['user_level']);
        $_SESSION['jigowatt']['user_level'] = $user_level;

        $_SESSION['jigowatt']['email'] = $this->result['email'];

        $_SESSION['jigowatt']['gravatar'] = parent::get_gravatar($this->result['email'], true, 26);

        /** Check whether the user's level is disabled. */
        $stmt = $this->db->query("SELECT `level_disabled`, `redirect` FROM `".DB_PRE."login_levels` WHERE `id` = $user_level[0];");

        $disRow = $this->db->fetch($stmt);

        if ( !empty($disRow['level_disabled']) ) $_SESSION['jigowatt']['level_disabled'] = 1;
        if ( !empty($disRow['redirect']) ) $redirect = $disRow['redirect'];

        // Stay signed via checkbox?
        if(isset($_POST['remember'])) {
            ini_set('session.cookie_lifetime', 60*60*24*100); // Set to expire in 3 months & 10 days
            session_regenerate_id();
        }

        /** Store a timestamp. */
        if( parent::getOption('profile-timestamps-enable') ) {

            $stmt = $this->db->query("INSERT INTO `".DB_PRE."login_timestamps` (`user_id` ,`ip` ,`timestamp`) VALUES ($this->result['user_id'], $this->getIPAddress(), CURRENT_TIMESTAMP);");

        }

        // And our magic happens here ! Let's sign them in
        $username = $this->username_type;
        $_SESSION['jigowatt']['username'] = $this->result[$username];

        // User ID of the logging in user
        $_SESSION['jigowatt']['user_id'] = $this->result['user_id'];

        if ( empty($redirect) ) $redirect = $_SESSION['jigowatt']['referer'];

        unset(
            $_SESSION['jigowatt']['referer'],
            $_SESSION['jigowatt']['token'],
            $_SESSION['jigowatt']['facebookMisc'],
            $_SESSION['jigowatt']['twitterMisc'],
            $_SESSION['jigowatt']['openIDMisc']
        );

        // Redirect after it's all said and done
        // header("Location: " . $redirect);
        return $redirect;

    }
}