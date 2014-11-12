<?php

class Register_Model extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->db->connect();

        $this->use_emails = parent::getOption('email-as-username-enable');
        $this->username_type = ($this->use_emails) ? 'email' : 'username';
    }

    function isExistedUsername($username)
    {
        $sth = $this->db->query("SELECT username FROM " . DB_PRE . "login_users WHERE
                    username = '$username'");

        $count = $this->db->numrows($sth);

        if ($count > 0) {
            return 1; // username already existed
        } else
            return 0;
    }

    function isExistedEmail($email)
    {
        $sth = $this->db->query("SELECT email FROM " . DB_PRE . "login_users WHERE
                    email = '$email'");

        $count = $this->db->numrows($sth);

        if ($count > 0) {
            return 1; // username already existed
        } else
            return 0;
    }

    function isExistedLevelName($levelname, $modify = false, $level_id = '')
    {
        if($modify)
        {
            $sql = "SELECT level_name FROM ".DB_PRE."login_levels WHERE id = ".$level_id;
            $query = $this->db->query($sql);
            $result = $this->db->fetch($query);
            if($levelname == $result['level_name'])
                return 'equal';
        }

        $sth = $this->db->query("SELECT level_name FROM " . DB_PRE . "login_levels WHERE
                    level_name = '$levelname'");

        $count = $this->db->numrows($sth);

        if ($count > 0) {
            return 'existed'; // username already existed
        } else
            return 'available';
    }

    function isExistedLevel($level , $modify = false, $level_id = '')
    {
        if($modify)
        {
            $sql = "SELECT level_level FROM ".DB_PRE."login_levels WHERE id = ".$level_id;
            $query = $this->db->query($sql);
            $result = $this->db->fetch($query);

            if($level == $result['level_level'])
                return 'equal';
        }

        $sth = $this->db->query("SELECT level_level FROM " . DB_PRE . "login_levels WHERE
                    level_level = '$level'");

        $count = $this->db->numrows($sth);

        if ($count > 0) {
            return 'existed'; // username already existed
        } else
            return 'available';
    }

    function addNewProcess($settings)
    {
        /* See if the admin requires new users to activate */
        $requireActivate = parent::getOption('user-activation-enable');
        /* Create their account */
        $sql = "INSERT INTO " . DB_PRE . "login_users (user_level, name, email, username, password)
						VALUES ('" . parent::getOption('default-level') . "', '" . $settings['name'] . "', '" . $settings['email'] . "', '" . $settings['username'] . "', '" . parent::hashPassword($settings['password']) . "')";

        $this->db->query($sql);

        /* Create the activation key */
        if ($requireActivate) :
            $key = md5(uniqid(mt_rand(), true));
            $sql = sprintf("INSERT INTO `" . DB_PRE . "login_confirm` (`username`, `key`, `email`, `type`)
								VALUES ('%s', '%s', '%s', '%s');",
                $settings[$this->username_type], $key, $settings['email'], 'new_user');
            $this->db->query($sql);
        endif;

        $disable_welcome_email = parent::getOption('email-welcome-disable');
        if (!$disable_welcome_email) {

            /* Send welcome email to new user. */
            $msg = parent::getOption('email-welcome-msg');
            $subj = parent::getOption('email-welcome-subj');

            $shortcodes = array(
                'site_address' => URL::get_site_url(),
                'full_name' => $settings['name'],
                'username' => $settings[$this->username_type],
                'email' => $settings['email'],
                'activate' => $requireActivate ? URL::get_site_url() . "/admin/login/active/$key" : ''
            );

            if (!parent::sendEmail($settings['email'], $subj, $msg, $shortcodes))
                $error = 'EMAIL_NOT_SEND';

        }

        unset(
        $_SESSION['ssbidbuy']['referer'],
        $_SESSION['ssbidbuy']['token']
        );

        /* After registering */
        $error = URL::get_site_url() . '/admin/all_users';

        return $error;
    }

    function registerProcess( $settings, $metas )
    {
        /* See if the admin requires new users to activate */
        $requireActivate = parent::getOption('user-activation-enable');
        /* Create their account */
        $sql = "INSERT INTO " . DB_PRE . "login_users (user_level, name, email, username, password)
						VALUES ('" . parent::getOption('default-level') . "', '" . $settings['name'] . "', '" . $settings['email'] . "', '" . $settings['username'] . "', '" . parent::hashPassword($settings['password']) . "')";
        $this->db->query($sql);
        // get user ID
        $sql = "SELECT user_id FROM ". DB_PRE ."login_users WHERE username = '". $settings['username'] ."'";
        $query = $this->db->query( $sql );
        $userId = $this->db->fetch( $query );
        $userId = $userId['user_id'];
        // Create information for this account
        foreach ( $metas as $k => $v )
        {
            $sql = "INSERT INTO " . DB_PRE . "members_meta (user_id, meta_key, meta_value)
                                                VALUES (" . $userId . ", '". $k ."', '". $v ."')";
            var_dump($sql);
            $this->db->query( $sql );
        }
        // If user want to register seller account, set flag to pending seller account
        if ( $settings['user_group'] === 'seller' )
        {
            $sql = "INSERT INTO " . DB_PRE . "members_meta (user_id, meta_key, meta_value)
                                                VALUES (" . $userId . ", 'pending_seller_account', '1')";
            $this->db->query( $sql );
        }

        /* Create the activation key */
        if ($requireActivate) :
            $key = md5(uniqid(mt_rand(), true));
            $sql = sprintf("INSERT INTO `" . DB_PRE . "login_confirm` (`username`, `key`, `email`, `type`)
								VALUES ('%s', '%s', '%s', '%s');",
                $settings[$this->username_type], $key, $settings['email'], 'new_user');
            $this->db->query($sql);
        endif;

        $disable_welcome_email = parent::getOption('email-welcome-disable');
        if (!$disable_welcome_email) {

            /* Send welcome email to new user. */
            $msg = parent::getOption('email-welcome-msg');
            $subj = parent::getOption('email-welcome-subj');

            $shortcodes = array(
                'site_address' => URL::get_site_url(),
                'full_name' => $settings['name'],
                'username' => $settings[$this->username_type],
                'email' => $settings['email'],
                'activate' => $requireActivate ? URL::get_site_url() . "/admin/login/active/$key" : ''
            );

            if (!parent::sendEmail($settings['email'], $subj, $msg, $shortcodes))
                $error = 'EMAIL_NOT_SEND';

        }

        unset(
        $_SESSION['ssbidbuy']['referer'],
        $_SESSION['ssbidbuy']['token']
        );

        /* After registering */
        $error = 'done';

        return $error;
    }

    /**
     * @param $options
     * @return int
     */
    public function addlevel($options)
    {

        $this->db->query("INSERT INTO `" . DB_PRE . "login_levels` (`level_name`, `level_level`, `level_disabled`)
						   VALUES ('" . $options['level_name'] . "', " . $options['level_level'] . ", '0')");

        return 1;
    }

    public function modifyLevel($options, $delete = false)
    {
        if ($delete) :

            $params = array( 'level' => '%:"' . $options['level_id'] . '";%' );
            $stmt   = $this->db->query("SELECT COUNT(user_level) AS num FROM ".DB_PRE."login_users WHERE user_level LIKE '".$params['level']."';");

            $result = $this->db->fetch($stmt);

            if ($result['num'] > 0) :
                return 'cant_delete';
            endif;

            $stmt = $this->db->query("DELETE FROM `".DB_PRE."login_levels` WHERE `id` = '".$options['level_id']."';");
            return 'deleted';

        else :

            $stmt = $this->db->query("UPDATE ".DB_PRE."login_levels SET level_name = '".$options['level_name']."', level_level = '".$options['level_level']."', level_disabled = '".$options['disable_level']."' WHERE id = ".$options['level_id']);
            return 'updated';

        endif;
    }

    public function modifyPermission($permission)
    {
        $generic = new Generic();
        foreach($permission as $key => $val){

            if($key != 'level_id' && $key != 'permission')
                $generic->updateOption($key, $val, false, true, $permission['level_id']);

        }
        return 1;
    }
}