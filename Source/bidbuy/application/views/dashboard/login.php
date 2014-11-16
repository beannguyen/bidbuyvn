<!DOCTYPE html>

<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title><?= (isset($this->title)) ? $this->title : 'Dashboard'; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta name="MobileOptimized" content="320">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link
        href="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/font-awesome/css/font-awesome.min.css"
        rel="stylesheet" type="text/css"/>
    <link href="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/bootstrap/css/bootstrap.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/uniform/css/uniform.default.css"
          rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css"
          href="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/select2/select2_metro.css"/>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    <link href="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/css/style-metronic.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/css/style.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/css/style-responsive.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/css/plugins.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/css/themes/default.css" rel="stylesheet"
          type="text/css" id="style_color"/>
    <link href="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/css/pages/login.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/css/custom.css" rel="stylesheet"
          type="text/css"/>
    <!-- END THEME STYLES -->
    <!-- SOCIAL LOGIN BUTTON -->
    <link href="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/css/bootstrap-social.css" rel="stylesheet">
    <link href="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/css/font-awesome.css" rel="stylesheet">
    <!-- END SOCIAL LOGIN BUTTON -->
    <link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
    <img src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/img/logo.png" alt=""/>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN ALERT -->
    <?php if (isset($this->error)) { ?>
        <div class="alert alert-block  fade in">
            <h4 class="alert-heading"><?php echo $this->error; ?></h4>
        </div>
    <?php } else { ?>
    <!-- END ALERT -->
    <!-- BEGIN ALERT -->
    <div id="register-sucessful" class="alert alert-block alert-success fade in <?php
                                                                                    if ( isset( $_SESSION['bidbuy']['register'] ) && $_SESSION['bidbuy']['register'] == 'done' )
                                                                                        echo '';
                                                                                    else
                                                                                        echo 'display-hide';
                                                                                ?>">
        <button type="button" class="close" data-dismiss="alert"></button>
        <h4 class="alert-heading">Đăng ký thành công!</h4>

        <p>
            Chúc mừng,
            Bạn đã đăng ký thành công tài khoản, bạn có thể đăng nhập vào trang cá nhân hoặc <a
                href="<?php echo URL::get_site_url(); ?>/">quay lại trang chủ</a>.
        </p>
    </div>
    <div id="invalid_token" class="alert alert-block alert-warning fade in <?php
                                                                                if ( isset( $_SESSION['bidbuy']['register'] ) && $_SESSION['bidbuy']['register'] == 'failed' )
                                                                                    echo '';
                                                                                else
                                                                                    echo 'display-hide';
                                                                                unset( $_SESSION['bidbuy']['register'] );
                                                                            ?>">
        <button type="button" class="close" data-dismiss="alert"></button>
        <h4 class="alert-heading">Đăng nhập thất bại!</h4>

        <p>
            Xin lỗi,
            Phiên đăng nhập của bạn không hợp lệ hoặc xảy ra sự cố, vui lòng "Làm mới trang" và đăng nhập lại.
        </p>
    </div>
    <div id="error_found" class="alert alert-block alert-warning fade in display-hide">
        <button type="button" class="close" data-dismiss="alert"></button>
        <h4 class="alert-heading">Đăng nhập thất bại!</h4>

        <p>
            Xin lỗi,
            Phiên đăng nhập của bạn không hợp lệ hoặc xảy ra sự cố, vui lòng "Làm mới trang" và đăng nhập lại.
        </p>
    </div>
    <div id="disable-login" class="alert alert-block alert-warning fade in display-hide">
        <button type="button" class="close" data-dismiss="alert"></button>
        <h4 class="alert-heading">Đăng nhập thất bại!</h4>

        <p>
            Xin lỗi,
            Quản trị viên đã khóa chức năng đăng nhập của người dùng.
        </p>
    </div>
    <div id="incorrect_password" class="alert alert-block alert-warning fade in display-hide">
        <button type="button" class="close" data-dismiss="alert"></button>
        <h4 class="alert-heading">Đăng nhập thất bại!</h4>

        <p>
            Xin lỗi,<br/>
            Tên đăng nhập hoặc mật khẩu không đúng. Vui lòng thử lại!<br/>
            Nếu bạn quên mật khẩu, <a href="javascript:;" id="forget-password-require" class="forget-btn">hãy nhấn vào
                đây</a>!
        </p>
    </div>
    <div id="banned_user" class="alert alert-block alert-warning fade in display-hide">
        <button type="button" class="close" data-dismiss="alert"></button>
        <h4 class="alert-heading">Đăng nhập thất bại!</h4>

        <p>
            Xin lỗi,<br/>
            Tài khoản của bạn đã bị khóa tạm thời hoặc bị cấm truy cập vĩnh viễn!<br/>
            Hãy liên hệ với quản trị viên để biết thêm chi tiết!
        </p>
    </div>
    <div id="not_active" class="alert alert-block alert-warning fade in display-hide">
        <button type="button" class="close" data-dismiss="alert"></button>
        <h4 class="alert-heading">Tài khoản của bạn chưa được kích hoạt.</h4>

        <p>
            Hãy nhấn vào liên kết được gửi trong email để kích hoạt tài khoản.<br/>

        <p><?php echo "Bạn có muốn <a id='resend-btn' href='javascript:;'>gửi lại</a> mã kích hoạt?" ?> </p>
        </p>
    </div>
    <!-- END ALERT -->
    <!-- BEGIN ALERT SECURE -->
    <?php if (isset($this->securemsg)) { ?>
        <div class="alert alert-block alert-success fade in">
            <button type="button" class="close" data-dismiss="alert"></button>
            <h5 class="alert-heading"><?php echo $this->securemsg; ?></h5>
        </div>
    <?php } ?>
    <?php
    if (isset($this->activationMsg)) {
        echo $this->activationMsg;
    }
    ?>
    <!-- END ALERT SECURE -->
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form <?php if ( isset( $this->resendFlag ) && $this->resendFlag == true ) echo "display-hide"; else echo ""  ?>" action="<?php echo URL::get_site_url(); ?>/admin/login/process" method="post">
        <h3 class="form-title" style="text-align: center;">Đăng nhập vào hệ thống</h3>

        <div class="alert-error" style="font-weight: bold; color: red; margin-bottom: 2px"></div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label for="username"
                   class="control-label visible-ie8 visible-ie9"><?php echo $this->use_emails ? _('Đỉa chỉ Email') : _('Tên đăng nhập'); ?></label>

            <div class="input-icon">
                <i class="<?php echo $this->use_emails ? _('icon-envelope') : _('icon-user'); ?>"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off"
                       placeholder="<?php echo $this->use_emails ? _('Đỉa chỉ Email') : _('Tên đăng nhập'); ?>"
                       name="<?php echo $this->use_emails ? _('email') : _('username'); ?>"
                       id="<?php echo $this->use_emails ? _('email') : _('username'); ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="control-label visible-ie8 visible-ie9"><?php echo _('Mật khẩu'); ?></label>

            <div class="input-icon">
                <i class="icon-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Mật khẩu"
                       name="password" id="password"/>
            </div>
        </div>
        <div class="form-actions">
            <label class="checkbox">
                <input type="checkbox" id="remember" name="remember" value="1"/><?php echo _('Ghi nhớ đăng nhập'); ?>
            </label>
            <input type="hidden" id="token" name="token" value="<?php echo $_SESSION['ssbidbuy']['token']; ?>"/>
            <input type="hidden" name="login" value="1"/>
            <button type="submit" class="btn green pull-right">
                <?php echo _('Đăng nhập'); ?> <i class="m-icon-swapright m-icon-white"></i>
                <span class="loading"></span>
            </button>
        </div>
        <div class="forget-password">
            <h4><?php echo _('Quên mật khẩu ?'); ?></h4>

            <p>
                đừng lo, nhấn <a href="javascript:;" id="forget-password" class="forget-btn">vào đây</a>
                để lấy lại mật khẩu.
            </p>
        </div>
        <!-- <div class="create-account">
        <p>
            Bạn chưa có tải khoản ?&nbsp;
            <a href="<?php echo URL::get_site_url(); ?>/admin/register" id="register-btn" ><?php echo _('Đăng ký tải khoản'); ?></a>
        </p>
    </div> -->
    </form>
    <!-- END LOGIN FORM -->
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form class="forget-form" action="#" method="post">
        <h3>Bạn quên mật khẩu ?</h3>

        <p>Nhập email của bạn để tạo mới mật khẩu.</p>

        <div class="alert-error" style="font-weight: bold; color: red; margin-bottom: 2px"></div>
        <div class="alert-success" style="font-weight: bold; color: green; margin-bottom: 2px"></div>
        <div class="form-group">
            <div class="input-icon">
                <i class="icon-envelope"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email"
                       name="email-reset-password" id="email-reset-password"/>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn">
                <i class="m-icon-swapleft"></i> Quay lại
            </button>
            <input type="submit" class="btn green pull-right" value="Hoàn tất" /><span class="loading"></span>
        </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->
    <!-- BEGIN RESEND KEY FORM -->
    <form class="resend-key-form <?php if ( isset( $this->resendFlag ) && $this->resendFlag == true ) echo ""; else echo "display-hide"  ?>" action="#" method="post">
        <div id="not_exist_user" class="alert alert-block alert-warning fade in display-hide">
            <button type="button" class="close" data-dismiss="alert"></button>
            <h4 class="alert-heading">Thất bại!</h4>

            <p>
                Xin lỗi,
                Hệ thống không tìm thấy tài khoản mà bạn yêu cầu!
            </p>
        </div>
        <div id="key_not_found" class="alert alert-block alert-warning fade in display-hide">
            <button type="button" class="close" data-dismiss="alert"></button>
            <h4 class="alert-heading">Thất bại!</h4>

            <p>
                Xin lỗi,
                Có thể tài khoản của bạn đã được kích hoạt, vui lòng đăng nhập!
            </p>
        </div>
        <div id="resend_key" class="alert alert-block alert-warning fade in display-hide">
            <button type="button" class="close" data-dismiss="alert"></button>
            <h4 class="alert-heading">Thành công!</h4>

            <p>
                Một email đã được gửi tới hộp thư của bạn, hãy nhấn vào liên kết trong email để kích hoạt tài khoản!
            </p>
        </div>
        <div id="email_not_send" class="alert alert-block alert-warning fade in display-hide">
            <button type="button" class="close" data-dismiss="alert"></button>
            <h4 class="alert-heading">Thất bại!</h4>

            <p>
                Xin lỗi,
                Hệ thống đã xảy ra một số lỗi không thể gửi được email, vui lòng quay lại sau!
            </p>
        </div>
        <h3>Chưa kích hoạt tài khoản ?</h3>

        <p>Nhập email của bạn để nhận lại key kích hoạt tài khoản.</p>

        <div class="alert-error" style="font-weight: bold; color: red; margin-bottom: 2px"></div>
        <div class="alert-success" style="font-weight: bold; color: green; margin-bottom: 2px"></div>
        <div class="form-group">
            <div class="input-icon">
                <i class="icon-envelope"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email"
                       name="email-to-resend" id="email-to-resend"/>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="back-login-btn" class="btn">
                <i class="m-icon-swapleft"></i> Quay lại
            </button>
            <input type="submit" class="btn green pull-right" value="Hoàn tất" />
        </div>
    </form>
    <!-- END RESEND KEY FORM -->
</div>
<!-- END LOGIN -->
<?php } ?>
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
    2014 &copy; BeBoard. Admin Dashboard Develop by BeanNguyen.
</div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/respond.min.js"></script>
<script src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/jquery-1.10.2.min.js"
        type="text/javascript"></script>
<script src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/jquery-migrate-1.2.1.min.js"
        type="text/javascript"></script>
<script src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/bootstrap/js/bootstrap.min.js"
        type="text/javascript"></script>
<script
    src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js"
    type="text/javascript"></script>
<script
    src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"
    type="text/javascript"></script>
<script src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/jquery.blockui.min.js"
        type="text/javascript"></script>
<script src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/jquery.cookie.min.js"
        type="text/javascript"></script>
<script src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/uniform/jquery.uniform.min.js"
        type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script
    src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/jquery-validation/dist/jquery.validate.min.js"
    type="text/javascript"></script>
<script type="text/javascript"
        src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/select2/select2.min.js"></script>
<script
    src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/bootstrap-toastr/toastr.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/scripts/login.js"
        type="text/javascript"></script>
<script src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/scripts/sha512.js"
        type="text/javascript"></script>
<script src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/scripts/generic.js"
        type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script>
    jQuery(document).ready(function () {
        App.init();
        Login.init();
    });
</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>