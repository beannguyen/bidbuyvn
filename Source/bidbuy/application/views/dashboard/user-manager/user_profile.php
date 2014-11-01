<?php require_once(ROOT . DS . 'application/views/dashboard/sidebar.php'); ?>
<?php $generic = new Generic(); ?>
<!-- BEGIN PAGE -->
<div class="page-content">
<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Quản lý người dùng
            <small>Trang cá nhân</small>
        </h3>
        <ul class="page-breadcrumb breadcrumb">

            <li>
                <i class="icon-home"></i>
                <a href="index.html">Dashboard</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>
                <a href="#">Quản lý người dùng</a>
                <i class="icon-angle-right"></i>
            </li>
            <li><a href="#">Trang cá nhân</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<?php if ($this->error == 'user_not_found') : ?>
    <div class="alert alert-danger">
        <strong>Error!</strong><br/>
        <span>Tài khoản này không tồn tại hoặc đã bị xóa. Vui lòng kiểm tra lại!</span>

        <p>
            <a class="btn red" href="<?php echo URL::get_site_url() . '/admin/all_users'; ?>">Quay lại</a>
        </p>
    </div>
    <?php return; endif; ?>
<div class="row profile">
<div class="col-md-12">
<!--BEGIN TABS-->
<div class="tabbable tabbable-custom tabbable-full-width">
<ul class="nav nav-tabs">
    <?php if (!isset($this->profile_setting)) { ?>
        <li class="active"><a href="#tab_1_1" data-toggle="tab">Tổng quan</a></li><?php } ?>
    <li <?php if (isset($this->profile_setting)) { ?>class="active"<?php } ?>><a href="#tab_1_3" data-toggle="tab">Cài
            đặt tài khoản</a></li>
</ul>
<div class="tab-content">
<?php if (!isset($this->profile_setting)) { ?>
    <div class="tab-pane active" id="tab_1_1">
<div class="row">
<div class="col-md-3">
    <ul class="list-unstyled profile-nav">
        <li>
            <a href="http://gravatar.com/emails/" title="<?php echo _('Change your avatar at Gravatar.com'); ?>"
               target="_blank">
                <img src="<?php echo $generic->get_gravatar($_SESSION['jigowatt']['email'], false, 300); ?>"
                     class="img-responsive" alt=""/>
            </a>
        </li>
    </ul>
</div>
<div class="col-md-9">
    <div class="row">
        <div class="col-md-8 profile-info">
            <h1><?php echo $this->user_info['name']; ?></h1>
            <strong>Giới thiệu: </strong>
            <?php
            if ($this->user_meta['about'] != '')
                echo $this->user_meta['about'];
            else {
                ?>
                <i>Cập nhật dòng giới thiệu của bạn tại "Cài đặt tài khoản".</i>
            <?php } ?>
            <?php if ($this->user_meta['website_url'] != '') { ?>
                <p><a href="#"><?php echo $this->user_meta['website_url']; ?></a></p>
            <?php } ?>

        </div>
        <!--end col-md-8-->
    </div>
    <!--end row-->
    <div class="tabbable tabbable-custom tabbable-custom-profile">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1_11" data-toggle="tab">Thông báo</a></li>
        </ul>
        <div class="tab-content">
        <div class="tab-pane active" id="tab_1_1">
        <div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible="0">
        <ul class="feeds">
            <?php
            require('function.php');
            historyLog();
            ?>
        </ul>
        </div>
        </div>
        </div>
    </div>
</div>
</div>
    </div><?php } ?>
<!--tab_1_2-->
<div class="tab-pane <?php if (isset($this->profile_setting)) { ?>active<?php } ?>" id="tab_1_3">
    <div class="row profile-account">

        <div class="col-md-3">
            <ul class="ver-inline-menu tabbable margin-bottom-10">
                <li class="active">
                    <a data-toggle="tab" href="#tab_1-1">
                        <i class="icon-cog"></i>
                        Thông tin cá nhân
                    </a>
                    <span class="after"></span>
                </li>
                <?php if ($generic->getPermission(UserInfo::getUserId(), 'can_manager_users')): ?>
                    <li><a data-toggle="tab" href="#tab_2-2"><i class="icon-picture"></i> Phân quyền</a></li>
                <?php endif; ?>
                <li><a data-toggle="tab" href="#tab_3-3"><i class="icon-lock"></i> Đổi mật khẩu</a></li>
            </ul>
        </div>
        <div class="col-md-9">
            <div class="tab-content">
                <div id="tab_1-1" class="tab-pane active">
                    <div class="alert alert-danger display-hide">
                        Vui lòng kiểm tra lại lỗi dữ liệu nhập.
                    </div>

                    <form class="user-profile-setting" role="form" action="#" method="post">
                        <div class="alert alert-success display-hide info-updated">
                            Thông tin cá nhân của bạn đã được lưu thành công!
                        </div>

                        <div class="alert alert-danger error-system display-hide">
                            <strong>Error!</strong> Hệ thống đã phát sinh lỗi. Vui lòng thử lại!
                        </div>
                        <div class="form-group">
                            <label class="control-label">Họ Tên</label>
                            <input name="name" type="text" placeholder="Nhập họ và tên"
                                   class="form-control placeholder-no-fix name"
                                   value="<?php echo $this->user_info['name']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Ngày sinh</label>

                            <div class="input-icon">
                                <i class="icon-calendar"></i>
                                <input class="form-control placeholder-no-fix date_of_birth" name="date_of_birth"
                                       placeholder="Ngày sinh" id="mask_date" type="text"
                                       value="<?php echo $this->user_meta['date_of_birth']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Giới tính</label>

                            <div class="radio-list">
                                <label>
                                    <div class="radio"><span><input class="sex" name="sex" value="M" data-title="Nam"
                                                                    type="radio" <?php if ($this->user_meta['sex'] == 'M') {
                                                echo 'checked';
                                            } ?>></span></div>
                                    Nam
                                </label>
                                <label>
                                    <div class="radio"><span><input class="sex" name="sex" value="F" data-title="Nữ"
                                                                    type="radio" <?php if ($this->user_meta['sex'] == 'F') {
                                                echo 'checked';
                                            } ?>></span></div>
                                    Nữ
                                </label>

                                <div id="form_gender_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input name="email" type="text" placeholder="Nhập email" class="form-control email"
                                   value="<?php echo $this->user_info['email']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Số điện thoại</label>
                            <input name="phone_num" type="text" placeholder="Nhập số điện thoại"
                                   class="form-control phone_num" value="<?php echo $this->user_meta['phone_num']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Nghề nghiệp</label>
                            <input type="text" name="job_title" placeholder="Nhập nghề nghiệp"
                                   class="form-control job_title" value="<?php echo $this->user_meta['job_title']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Website Url</label>
                            <input name="website_url" type="text" placeholder="Nhập liên kết website"
                                   class="form-control website_url"
                                   value="<?php echo $this->user_meta['website_url']; ?>"/>
                            <span class="help-block">e.g: http://www.demo.com or http://demo.com</span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Yahoo IM</label>
                            <input name="yahoo_im" type="text" placeholder="Nickname yahoo"
                                   class="form-control yahoo_im" value="<?php echo $this->user_meta['yahoo_im']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Skype</label>
                            <input name="skype" type="text" placeholder="Nickname skype" class="form-control skype"
                                   value="<?php echo $this->user_meta['skype']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">About</label>
                            <textarea name="about" class="form-control about" rows="3"
                                      placeholder="Giới thiệu bản thân"><?php echo $this->user_meta['about']; ?></textarea>
                        </div>
                        <input name="userId" value="<?php echo $this->userId; ?>" type="hidden"/>

                        <div class="margiv-top-10">
                            <input type="submit" id="save-change-userinfo" class="btn green" value="Lưu thay đổi"/><span
                                class="tab1_loading"></span>
                        </div>
                    </form>
                </div>
                <?php if ($generic->getPermission(UserInfo::getUserId(), 'can_manager_users')): ?>
                    <div id="tab_2-2" class="tab-pane">

                        <form id="change_user_permission" method="post" role="form">
                            <div class="alert alert-warning warning-deleted display-hide">
                                <strong>Tài khoản đã bị xóa!</strong>

                                <div id="timer"><em>Trang sẽ reload sau 3s</em></div>
                            </div>
                            <div class="alert alert-success permission-updated display-hide">
                                Thông tin cá nhân của bạn đã được lưu thành công!
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nhóm người dùng</label>
                                <i class="icon-info-sign tooltips"
                                   data-original-title="Chọn nhóm tương thích với quyền hạn của người dùng này"
                                   data-container="body"></i>

                                <div class="input-icon right">
                                    <?php UserInfo::returnUserLevels($this->userId); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="">Khóa tài khoản người dùng</label>
                                <i class="icon-info-sign tooltips"
                                   data-original-title="Chọn khóa tài khoản nếu muốn cấm người dùng này. Chọn Xóa nếu muốn xóa vĩnh viễn, và không bao h khôi phục lại được."
                                   data-container="body"></i>

                                <div class="checkbox-list">
                                    <label>
                                        <input type="checkbox" id="disable_user" name="disable-user"
                                               value="1" <?php echo (UserInfo::isUserDisabled($this->userId) == true) ? 'checked' : ''; ?> <?php echo ($this->isAdmin) ? 'disabled' : ''; ?>>
                                        Khóa tài khoản?
                                    </label>
                                    <label>
                                        <input type="checkbox" id="delete_user" name="delete-user"
                                               value='1' <?php echo ($this->isAdmin) ? 'disabled' : ''; ?>> Xóa tài
                                        khoản?
                                    </label>
                                </div>
                            </div>
                            <input id="user_id" name="userId" value="<?php echo $this->userId; ?>" type="hidden"/>

                            <div class="margin-top-10">
                                <input type="submit" id="save-change-userpermission" class="btn green" name="submit"
                                       value="Lưu thay đổi"><span class="tab2_loading"></span>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
                <div id="tab_3-3" class="tab-pane">
                    <form class="change-password" action="<?php echo URL::get_site_url(); ?>/user/changePassword"
                          method="post">

                        <div class="alert alert-success display-hide password-changed">
                            <strong>Chúc mừng!</strong> Bạn đã đổi mật khẩu thành công.
                        </div>

                        <div class="form-group">
                            <label class="control-label">Mật khẩu mới</label>
                            <input id="newpassword" name="newpassword" type="password" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Nhập lại mật khẩu</label>
                            <input id="renewpassword" name="renewpassword" type="password" class="form-control"/>
                        </div>
                        <input type="hidden" class="userId" name="userId" value="<?php echo $this->userId; ?>"/>

                        <div class="margin-top-10">
                            <input id="save-change-changepass" type="submit" class="btn green"
                                   value="Đổi mật khẩu"/><span class="tab3_loading"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end col-md-9-->
    </div>
</div>
<!--end tab-pane-->
</div>
</div>
<!--END TABS-->
</div>
</div>
<!-- END PAGE CONTENT-->
</div>
<!-- END PAGE -->