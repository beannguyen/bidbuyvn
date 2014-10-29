<?php


class Useractive_Model extends Model
{
    private $user;
    private $error;

    function __construct()
    {
        parent::__construct();
        $this->db->connect();
        // Assign their username to a variable
        if(isset($_SESSION['jigowatt']['username']))
            $this->user = $_SESSION['jigowatt']['username'];

        // Display any errors
        parent::displayMessage($this->error, false);

    }

    public function getKey($key) {

        $sql = "SELECT `".DB_PRE."login_confirm`.`email`, `".DB_PRE."login_confirm`.`username`, `".DB_PRE."login_users`.`name`
							  FROM   `".DB_PRE."login_confirm`,         `".DB_PRE."login_users`
							  WHERE  `".DB_PRE."login_confirm`.`key`      =  '$key'
							  AND    `".DB_PRE."login_confirm`.`username` = `".DB_PRE."login_users`.`username`
							  AND    `".DB_PRE."login_confirm`.`type`     = 'new_user'";
        $stmt = $this->db->query($sql);

        if ($this->db->numrows($stmt) < 1) {
            return "not_found";
        }

        $row = $this->db->fetch($stmt);
        $username = $row['username'];
        $to = $row['email'];

        // Activate by deleting the activation key
        $this->db->query("DELETE FROM `".DB_PRE."login_confirm` WHERE `username` = '$username' AND `type` = 'new_user';");

        // Set user's activate session to false
        if(!empty($_SESSION['jigowatt']['activate'])) unset($_SESSION['jigowatt']['activate']);

        $shortcodes = array(
            'site_address'	=>	URL::get_site_url(),
            'full_name'		=>	$row['name'],
            'username'		=>	$username
        );

        $msg = parent::getOption('email-activate-msg');
        $subj = parent::getOption('email-activate-subj');


        if(!parent::sendEmail($to, $subj, $msg, $shortcodes))
            return "email_not_send";

        return true;

    }
    public function resendKey( $email ) {

        $sql = "SELECT `".DB_PRE."login_confirm`.`email`,  `".DB_PRE."login_confirm`.`username`, `".DB_PRE."login_confirm`.`key`, `".DB_PRE."login_users`.`name`
								FROM    `".DB_PRE."login_confirm`,          `".DB_PRE."login_users`
								WHERE   `".DB_PRE."login_confirm`.`email` = '$email'
								AND     `".DB_PRE."login_confirm`.`type`     = 'new_user'
								AND     `".DB_PRE."login_users`.`email`   = '$email'";
        $stmt   = $this->db->query($sql);

        $row = $this->db->fetch($stmt);
        $key = $row['key'];

        if ( $key == '' ) {
            return "key_not_found";
        }

        $shortcodes = array(
            'site_address'	=>	URL::get_site_url(),
            'full_name'		=>	$row['name'],
            'username'		=>	$row['username'],
            'activate'		=>	URL::get_site_url() . "/admin/login/active/$key"
        );

        $subj = parent::getOption('email-activate-resend-subj');
        $msg = parent::getOption('email-activate-resend-msg');
        $to = $row['email'];

        if(parent::sendEmail($to, $subj, $msg, $shortcodes)) {
            return "resend_key";
        } else
            return "email_not_send";

        return true;

    }

    public function signedIn() {

        // Check if user needs activation
        $sql = "SELECT * FROM `".DB_PRE."login_confirm` WHERE `username` = '".$this->user."' AND `type` = 'new_user'";
        $stmt   = $this->db->query($sql);

        if ($this->db->numrows($stmt) < 1) {

            return true;
        } else{

            return false;
        }
    }
}