<?php

function user_levels()
{

    // Init function
    $generic = new Generic();
    $cnn = new Connect();
    $db = $cnn->dbObj();
    $db->connect();

    /* Check that at least one row was returned */
    $sql = "SELECT * FROM " . DB_PRE . "login_levels";
    $stmt = $db->query($sql);
    if ($db->numrows($stmt) < 1) return false;

    /* Manage levels */
    ?>
    <table class="table table-striped table-bordered table-hover" id="user_group_manager">
        <thead>
        <tr>
            <th>Tên nhóm</th>
            <th>Cấp độ</th>
            <th>Sô người dùng</th>
        </tr>
        </thead>
        <tbody>

        <?php

        while ($row = $db->fetch($stmt)) :

            /* Count of users in this level */
            $lid = $row['id'];
            $params = array('user_level' => "%:\"$lid\";%");
            $sql1 = "SELECT COUNT(user_level) as num FROM " . DB_PRE . "login_users WHERE user_level LIKE '" . $params['user_level'] . "'";
            $query = $db->query($sql1);
            $count = $db->fetch($query);
            $count = $count['num'];

            /* Admin level? */
            $admin = ($row['level_level'] == 1)
                ? ' <span class="label label-important">*</span>'
                : '';

            /* Disabled level? */
            $status = !empty($row['level_disabled'])
                ? ' <span class="label label-warning">' . _('Disabled') . '</span>'
                : '';

            ?>

            <tr>
                <td>
                    <a href="<?php echo URL::get_site_url().'/admin/dashboard/user_group_modify/'.$lid; ?>"><?php echo $row['level_name']; ?></a><?php echo $status; ?>
                </td>
                </td>
                <td width="15%"><?php echo $row['level_level']; ?></td>
                <td width="15%"><?php echo $count; ?></td>
            </tr>

        <?php endwhile; ?>
        </tbody>
    </table>

<?php

}

function display_all_user()
{

    // Init function
    $generic = new Generic();
    $cnn = new Connect();
    $db = $cnn->dbObj();
    $db->connect();
    ?>
    <table class="table table-striped table-bordered table-hover" id="all_user_manager">
        <thead>
        <tr>
            <th>Tên đăng nhập</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Ngày tham gia</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM `" . DB_PRE . "login_users`;";
        $stmt = $db->query($sql);

        $i = 0;
        while ($row = $db->fetch($stmt)) :

            ?>
            <tr class="odd gradeX">
            <td>
                <a href="<?php echo URL::get_site_url(); ?>/admin/dashboard/user_profile/<?php echo $row['user_id']; ?>"> <?php echo $row['username']; ?></a>
            </td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['timestamp']; ?></td>
            <td class="center"><span
                    class="label label-sm <?php if ($row['restricted'] == 1) {
                        echo _('label-default');
                    } else echo _('label-success'); ?>"><?php if ($row['restricted'] == 1) {
                        echo _('Bị khóa');
                    } else echo _('Đang hoạt động'); ?></span>
            </td>
            </tr><?php
        endwhile;
        ?>
        </tbody>
    </table>
<?php
}

function display_active_sellers()
{
    // Init function
    $generic = new Generic();
    $cnn = new Connect();
    $db = $cnn->dbObj();
    $db->connect();

    $sql = "select user_id
            from ". DB_PRE ."members_meta
            where meta_key = 'pending_seller_account'
                and meta_value = '1'";
    $query = $db->query( $sql );
    ?>
    <table class="table table-striped table-bordered table-hover" id="all_user_manager">
        <thead>
        <tr>
            <th>Tên đăng nhập</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Ngày tham gia</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ( $db->numrows( $query ) > 0 ) {

            while ( $userId = $db->fetch( $query ) ) {
                $sql = "SELECT * FROM `" . DB_PRE . "login_users` WHERE user_id = " . $userId['user_id'];
                $stmt = $db->query($sql);

                while ($row = $db->fetch($stmt)) :

                    ?>
                    <tr class="odd gradeX">
                    <td>
                        <?php echo $row['username']; ?>
                    </td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['timestamp']; ?></td>
                    <td class="center"><span
                            class="label label-sm label-success"><a href="<?php echo URL::get_site_url(); ?>/admin/user/activeSeller/<?php echo $row['user_id'] ?>">Kích hoạt</a></span>
                    </td>
                    </tr><?php
                endwhile;
            }
        }
        echo '</tbody>';
    echo '</table>';
}

function historyLog()
{
    // db connect
    $cnn = new Connect();
    $db = $cnn->dbObj();
    $db->connect();
    // log user register
    $sql = "select user_id
            from ". DB_PRE ."members_meta
            where meta_key = 'pending_seller_account'
                and meta_value = '1'";
    $query = $db->query( $sql );
    // have pending seller account
    if ( $db->numrows( $query ) > 0 ) {

        echo '<li>
                <div class="col1">
                    <div class="cont">
                        <div class="cont-col1">
                            <div class="label label-sm label-info">
                                <i class="icon-bell"></i>
                            </div>
                        </div>
                        <div class="cont-col2">
                            <div class="desc">
                                Có '. $db->numrows( $query ) .' tài khoản seller đang chờ được duyệt.
                                                       <span class="label label-sm label-danger ">
                                                       <a href="#">Duyệt ngay</a>
                                                       <i class="icon-share-alt"></i>
                                                       </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col2">
                    <div class="date">
                    </div>
                </div>
            </li>';
    }
}