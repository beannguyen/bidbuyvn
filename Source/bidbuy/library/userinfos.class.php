<?php

class UserInfo
{
    function __construct() {}

    public static function getUsername($user_id = false)
    {
        $cnn = new Connect();
        $db = $cnn->dbObj();
        $db->connect();
        if($user_id == false)
        {
            return $_SESSION['jigowatt']['username'];
        } else
        {
            $query = "SELECT username FROM ".DB_PRE."login_users WHERE user_id = $user_id";
            $query_id = $db->query($query);
            $result = $db->fetch($query_id);
            return $result['username'];
        }
    }

    public static function getUserId($username = false)
    {
        // db connect
        $cnn = new Connect();
        $db = $cnn->dbObj();
        $db->connect();

        //
        $generic = new Generic();
        $use_emails = $generic->getOption('email-as-username-enable');
        $username_type = ( $use_emails ) ? 'email' : 'username';
        if($username == false)
            return $_SESSION['jigowatt']['user_id'];
        else
        {
            $query = "SELECT user_id FROM ".DB_PRE."login_users WHERE {$username_type} = '$username'";
            $query_id = $db->query($query);
            $result = $db->fetch($query_id);
            return $result['user_id'];
        }
    }

    public static function get_domains($json = false) {

        $generic = new Generic();
        $option = $generic->getOption('restrict-signups-by-email');

        if ( !$option ) return '';
        $option = unserialize($option);

        $options = '';
        foreach ( $option as $value ) :

            $options .= $json ? "'$value', " : "$value, ";;

        endforeach;
        $options = rtrim($options, ', ');

        echo $options;

    }

    /* @TODO: This function is repeated once in edit_user.class.php. Obliterate that repeat. */
    public static function returnLevels($id = 'default-level') {

        $generic = new Generic();
        // DB connect
        $cnn = new Connect();
        $db = $cnn->dbObj();
        $db->connect();

        $option = $generic->getOption($id);

        $ids = !empty( $option ) ? unserialize($option) : array('');

        $string = implode(',', $ids);

        $sql = "SELECT level_name, level_level FROM ".DB_PRE."login_levels WHERE level_level IN (" . $string . ")";
        $stmt = $db->query($sql);
        $value = '';
        ?>
        <?php while($level = $db->fetch($stmt)) : ?>
            <?php $value .= $level['level_name'].','; ?>
        <?php endwhile; ?>
        <input type="hidden" class="form-control select2_default_level" id="<?php echo $id; ?>" name="<?php echo $id; ?>" value="<?php $v = trim($value, ','); echo $v; ?>" disabled>
        <?php

    }

    /* @TODO: This function is repeated once in edit_user.class.php. Obliterate that repeat. */
    public static function returnUserLevels($id = '') {

        // DB connect
        $cnn = new Connect();
        $db = $cnn->dbObj();
        $db->connect();

        //$option = $generic->getOption($id);
        $sql1 = "SELECT user_level FROM ".DB_PRE."login_users WHERE user_id =".$id;
        $q = $db->query($sql1);
        $option = $db->fetch($q);

        $ids = !empty( $option ) ? unserialize($option['user_level']) : array('');

        $string = implode(',', $ids);

        $sql = "SELECT level_name, level_level FROM ".DB_PRE."login_levels WHERE level_level IN (" . $string . ")";
        $stmt = $db->query($sql);
        $value = '';
        ?>
        <?php while($level = $db->fetch($stmt)) : ?>
            <?php $value .= $level['level_name'].','; ?>
        <?php endwhile; ?>
        <input type="hidden" class="form-control select2_user_group" id="user_group" name="user_group" value="<?php $v = trim($value, ','); echo $v; ?>" disabled>
    <?php

    }

    public static function isUserDisabled($userId)
    {
        // DB connect
        $cnn = new Connect();
        $db = $cnn->dbObj();
        $db->connect();

        $sql = "SELECT restricted FROM ".DB_PRE."login_users WHERE user_id = ".$userId;
        $query = $db->query($sql);

        $res = $db->fetch($query);

        if($res['restricted'] == 1)
            return true; // this user is disabled
        return false; // this user is active
    }
}