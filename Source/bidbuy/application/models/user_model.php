<?php


class User_Model extends Model
{

    private $array = array();

    function __construct()
    {
        parent::__construct();
        $this->db->connect();
    }

    function getUserInfo($userId = 1)
    {
        $sql = "SELECT * FROM " . DB_PRE . "login_users WHERE user_id = " . $userId;
        $queryid = $this->db->query($sql);
        return $this->db->fetch($queryid);
    }

    function getUserMeta($userId = 1)
    {
        $info = array(
            'date_of_birth' => '',
            'sex' => '',
            'phone_num' => '',
            'job_title' => '',
            'website_url' => '',
            'yahoo_im' => '',
            'skype' => '',
            'about' => ''
        );

        foreach ($info as $key => $value) {
            $sql = "SELECT meta_value FROM " . DB_PRE . "members_meta WHERE meta_key = '" . $key . "' AND user_id =" . $userId;
            $q = $this->db->query($sql);
            $res = $this->db->fetch($q);
            $info[$key] = $res['meta_value'];
        }

        return $info;
    }

    function updateProfileSetting($userId, $info = null, $meta = null)
    {
        foreach ($info as $key => $value) {
            if ($info[$key] != '') {
                $sql = "UPDATE " . DB_PRE . "login_users SET $key = '" . $info[$key] . "' WHERE user_id =" . $userId;
                $this->db->query($sql);
            }
        }
        foreach ($meta as $key => $value) {
            $sql = "SELECT * FROM " . DB_PRE . "members_meta WHERE meta_key = '" . $key . "' AND user_id =" . $userId;
            $query = $this->db->query($sql);
            $numrows = $this->db->numrows($query);
            if ($numrows > 0) {
                $update_sql = "UPDATE " . DB_PRE . "members_meta SET meta_value = '" . $meta[$key] . "' WHERE meta_key = '" . $key . "' AND user_id = " . $userId;
                $this->db->query($update_sql);
            } else {
                $insert_sql = "INSERT INTO " . DB_PRE . "members_meta (`user_id`, `meta_key`, `meta_value`) VALUES (" . $userId . ",'" . $key . "', '" . $meta[$key] . "')";
                $this->db->query($insert_sql);
            }
        }
        return true;
    }

    function changePassword($userId, $password)
    {
        $sql = "UPDATE " . DB_PRE . "login_users SET password = '" . $password . "' WHERE user_id = " . $userId;
        $query = $this->db->query($sql);
        if ($query)
            return true;
        return false;
    }

    function returnAllLevels()
    {
        $sql = "SELECT level_name, level_level FROM " . DB_PRE . "login_levels WHERE level_disabled != 1";
        $stmt = $this->db->query($sql);

        $level = '';
        while ($result = $this->db->fetch($stmt)) {
            $level .= $result['level_name'] . ", ";
        }
        $level = rtrim($level, ", ");
        return $level;
    }

    /** Insert setting values into the database */
    public function updateGeneralOptionsProcess($options)
    {

        $generic = new Generic();

        /** Save every other field */
        foreach ($options as $key => $newvalue) {
            if (!is_array($key)) {
                if ($key == 'default-level' || $key == 'notify-new-users') {
                    $level = explode(',', $options[$key]);
                    $string = '';
                    foreach ($level as $k => $v) {
                        $string .= "'" . $level[$k] . "',";
                    }
                    $string = rtrim($string, ',');
                    $sql = "SELECT level_level FROM " . DB_PRE . "login_levels WHERE level_name IN (" . $string . ")";
                    $stmt = $this->db->query($sql);

                    $i = 0;
                    while ($res = $this->db->fetch($stmt)) {
                        $this->array[$i] = $res['level_level'];
                        $i++;
                    }
                    $generic->updateOption($key, serialize($this->array));
                } else
                    $generic->updateOption($key, $newvalue);
            }
        }

        return true;

    }

    function admChangeUserPermission($delete = false, $options = array())
    {
        $generic = new Generic();
        if ($delete) :

            $sql = "DELETE FROM " . DB_PRE . "login_users WHERE user_id = " . $options['user_id'];
            $q = $this->db->query($sql);

            if ($q)
                return 'deleted';
            else
                return 'cant_delete';
        endif;

        // Check if user_level was not selected
        // $serialize_level = '';
        if ($options['user_level'] == '') {
            $serialize_level = $generic->getOption('default-level');
        } else {
            $level_list = $options['user_level'];
            $level_arr = explode(',', $level_list);

            $string = '';
            foreach ($level_arr as $k => $v) {
                $string .= "'" . $v . "',";
            }
            $string = rtrim($string, ',');
            $sql = "SELECT level_level FROM " . DB_PRE . "login_levels WHERE level_name IN (" . $string . ")";
            $stmt = $this->db->query($sql);

            $i = 0;
            while ($res = $this->db->fetch($stmt)) {
                $array[$i] = $res['level_level'];
                $i++;
            }

            $serialize_level = serialize($array);
        }

        $sql = "UPDATE " . DB_PRE . "login_users SET user_level = '" . $serialize_level . "', restricted = " . $options['disable_user'] . " WHERE user_id = " . $options['user_id'];
        if ($this->db->query($sql))
            return 'updated';
        return 'error';
    }

    function getLevel($levelId)
    {
        $sql = "SELECT * FROM " . DB_PRE . "login_levels WHERE id = " . $levelId;
        $q = $this->db->query($sql);

        if ($this->db->numrows($q) == 0)
            return false;

        $result = $this->db->fetch($q);
        return $result;
    }

    function getUser($userId)
    {
        $sql = "SELECT * FROM " . DB_PRE . "login_users WHERE user_id = " . $userId;
        $q = $this->db->query($sql);

        if ($this->db->numrows($q) == 0)
            return false;

        $result = $this->db->fetch($q);
        return $result;
    }

    /**
     * Return userId by email
     * @param $email
     * @return int userId
     */
    function getUserIdByEmail($email)
    {

        $sql = "SELECT user_id FROM " . DB_PRE . "login_users WHERE email = '" . $email . "'";
        $query = $this->db->query($sql);
        $result = $this->db->fetch($query);

        return $result['user_id'];
    }

    function changeGroup($userId, $level)
    {
        $levelArray = array(
            0 => $level
        );
        $levelId = serialize( $levelArray );

        // update user group
        $sql = "UPDATE ". DB_PRE ."login_users SET user_level = '". $levelId ."' WHERE user_id = " . $userId;
        $this->db->query( $sql );

        // remove flag on user meta
        $sql = "DELETE FROM ". DB_PRE ."members_meta WHERE user_id = " . $userId . " AND meta_key = 'pending_seller_account'";
        $this->db->query( $sql );

        $_SESSION['bean']['changeGroupComplete'] = true;
        return true;
    }
}