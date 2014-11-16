<?php require_once(ROOT . DS . 'application/views/dashboard/sidebar.php'); ?>
<?php require('function.php'); ?>
<?php
    $cnn = new Connect();
    $db = $cnn->dbObj();
    $db->connect();

    $generic = new Generic();
?>
<!--  BEGIN PAGE  -->
<div class="page-content">
    <!--  BEGIN PAGE HEADER -->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
                Quản lý người dùng
                <small>Tất cả người dùng</small>
            </h3>
            <ul class="page-breadcrumb breadcrumb">

                <li>
                    <i class="icon-home"></i>
                    <a href="../dashboard">Dashboard</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <a href="#">Quản lý người dùng</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>Tất cả người dùng</li>
            </ul>
            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>
    <!--  END PAGE HEADER -->

    <!--  BEGIN PAGE CONTENT -->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box light-grey">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-globe"></i></div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if( $generic->getPermission( UserInfo::getUserId(), 'can_manager_users' ) ): ?>
                    <div class="table-toolbar">
                        <div class="btn-group">
                            <a id="sample_editable_1_new" class=" btn green" href="#responsive" data-toggle="modal">
                                Thêm mới <i class="icon-plus"></i>
                            </a>
                        </div>
                        <div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Thêm mới người dùng</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="scroller" style="height:500px" data-always-visible="1" data-rail-visible1="1">
                                            <form novalidate="novalidate" class="add-new-user-form" role="form" action="#" method="post">
                                                <div class="note note-success display-hide">
                                                    <h4 class="block">Tạo tài khoản thành công</h4>
                                                    <?php if ($generic->getOption('email-welcome-disable')) : ?>
                                                        <p>
                                                            Bạn có thể đăng nhập với tên và mật khẩu vừa được sử dụng.
                                                        </p>
                                                        <div id="timer"><em>Trang sẽ reload sau 3s</em></div>
                                                    <?php else : ?>
                                                        <p>
                                                            Hệ thông yêu cầu người dùng kích hoạt tài khoản. Vui lòng đăng nhập email để lấy link kích hoạt!
                                                        </p>
                                                        <div id="timer"><em>Trang sẽ reload sau 3s</em></div>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">Tên đăng nhập</label>
                                                    <input id="username" name="username" placeholder="" class="form-control placeholder-no-fix" type="text"><span class="loading"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Email</label>
                                                    <input id="email" name="email" placeholder="" class="form-control" type="text"><span class="email_loading"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Mật khẩu</label>
                                                    <input id="password" name="password" placeholder="" class="form-control placeholder-no-fix" type="password">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Nhập lại mật khẩu</label>
                                                    <input id="repassword" name="repassword" placeholder="" class="form-control placeholder-no-fix" type="password">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Họ tên</label>
                                                    <input id="name" name="name" placeholder="" class="form-control placeholder-no-fix" type="text">
                                                </div>
                                                <button type="button" data-dismiss="modal" class="btn-close-modal btn default">Hủy</button>
                                                <input id="add_form" type="submit" class="btn green" value="Tạo tài khoản" /><span class="process_loading"></span>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="ajax" tabindex="-1" role="basic" aria-hidden="true">
                            <img src="<?php echo URL::getPath(); ?>/public/dashboard/assets/img/ajax-modal-loading.gif" alt="" class="loading">
                        </div>
                        <!-- /.modal -->
                    </div>
                    <?php endif; ?>
                    <div id="content">
                        <?php display_all_user(); ?>
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    <!--  END PAGE CONTENT -->
</div>
<!--  END PAGE  -->
