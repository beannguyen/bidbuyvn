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
    <link href="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/font-awesome/css/font-awesome.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/bootstrap/css/bootstrap.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/uniform/css/uniform.default.css"
          rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css"
          href="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/select2/select2_metro.css"/>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    <link href="<?php echo BASE_PATH; ?>public/dashboard/assets/css/style-metronic.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo BASE_PATH; ?>public/dashboard/assets/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo BASE_PATH; ?>public/dashboard/assets/css/style-responsive.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo BASE_PATH; ?>public/dashboard/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo BASE_PATH; ?>public/dashboard/assets/css/themes/default.css" rel="stylesheet" type="text/css"
          id="style_color"/>
    <link href="<?php echo BASE_PATH; ?>public/dashboard/assets/css/pages/login.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo BASE_PATH; ?>public/dashboard/assets/css/pages/register.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo BASE_PATH; ?>public/dashboard/assets/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- BEGIN BODY -->
<body class="reg">
<!-- BEGIN LOGO -->
<div class="logo">
    <img src="<?php echo BASE_PATH; ?>public/dashboard/assets/img/logo-big.png" alt=""/>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN ERROR -->
    <?php if (isset($this->alert) && $this->alert == "register-failed") { ?>
        <div class="alert alert-block alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert"></button>
            <h4 class="alert-heading">Xảy ra lỗi!</h4>

            <p>
                Rất tiếc, hệ thống đã xảy ra lỗi trong quá trình đăng ký.
                Vui lòng thử lại.
            </p>
        </div>
    <?php } ?>
    <!-- END ERROR -->
    <!-- BEGIN REGISTRATION FORM -->
    <form class="register-form" action="<?php echo URL::get_site_url(); ?>/admin/register/registerProcess" method="post">
        <h3>Đăng ký tài khoản</h3>

        <p>Nhập thông tin cá nhân của bạn:</p>

        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Họ và Tên</label>

            <div class="input-icon">
                <i class="icon-font"></i>
                <input class="form-control placeholder-no-fix" type="text" placeholder="Họ và Tên" name="fullname"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">Giới tính</label>

            <div class="radio-list">
                <label class="radio-inline">
                    <div class="radio" id="uniform-optionsRadios4"><input type="radio" name="gender" value="M" checked></div>
                    Nam
                </label>
                <label class="radio-inline">
                    <div class="radio" id="uniform-optionsRadios5"><input type="radio" name="gender" value="F"></div>
                    Nữ
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Ngày sinh</label>

            <div class="input-icon">
                <i class="icon-calendar"></i>
                <input class="form-control placeholder-no-fix" name="dayofbirth" placeholder="Ngày sinh" id="mask_date" type="text">
            </div>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Email</label>

            <div class="input-icon">
                <i class="icon-envelope"></i>
                <input class="form-control placeholder-no-fix" type="email" placeholder="Email" name="email"/>
            </div>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Số điện thoại</label>

            <div class="input-icon">
                <i class="icon-file-text"></i>
                <input name="phonenum" type="text" placeholder="Số điện thoại" class="form-control placeholder-no-fix"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Địa chỉ</label>

            <div class="input-icon">
                <i class="icon-map-marker"></i>
                <input class="form-control placeholder-no-fix" type="text" placeholder="Địa chỉ" name="address"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Tỉnh / Thành phố</label>

            <div class="input-icon">
                <i class="icon-location-arrow"></i>
                <input class="form-control placeholder-no-fix" type="text" placeholder="Tỉnh / Thành phố" name="city"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Nước</label>
            <select name="country" id="country_select" class="select2 form-control">
                <option value="vn">Viet Nam</option>
            </select>
        </div>
        <p>Nhập chi tiết tài khoản:</p>

        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Tên tài khoản</label>

            <div class="input-icon">
                <i class="icon-user"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off"
                       placeholder="Tên tài khoản"
                       name="username"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Mật khẩu</label>

            <div class="input-icon">
                <i class="icon-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password"
                       placeholder="Mật khẩu" name="password"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Nhập lại mật khẩu</label>

            <div class="controls">
                <div class="input-icon">
                    <i class="icon-ok"></i>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off"
                           placeholder="Nhập lại mật khẩu" name="rpassword"/>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="">Loại tài khoản</label>

            <div class="radio-list">
                <label class="radio-inline">
                    <input type="radio" name="user_group" id="buyer_group" value="buyer" checked> Người mua
                </label>
                <label class="radio-inline">
                    <input type="radio" name="user_group" id="seller_group" value="seller"> Người bán
                </label>
            </div>
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="tnc"/> Tôi đồng ý với <a href="#">Điều khoản dịch vụ</a>
            </label>

            <div id="register_tnc_error"></div>
        </div>
        <div class="form-actions">
            <button type="submit" id="register-submit-btn" class="btn green pull-right">
                Đăng ký <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>
    </form>
    <!-- END REGISTRATION FORM -->
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
    2013 &copy; Metronic. Admin Dashboard Template.
</div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/respond.min.js"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jquery-1.10.2.min.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jquery-migrate-1.2.1.min.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/bootstrap/js/bootstrap.min.js"
        type="text/javascript"></script>
<script
    src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js"
    type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jquery.blockui.min.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jquery.cookie.min.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/uniform/jquery.uniform.min.js"
        type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jqvmap/jqvmap/jquery.vmap.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/flot/jquery.flot.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/flot/jquery.flot.resize.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jquery.pulsate.min.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/bootstrap-daterangepicker/moment.min.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/gritter/js/jquery.gritter.js"
        type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/fullcalendar/fullcalendar/fullcalendar.min.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jquery.sparkline.min.js"
        type="text/javascript"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/data-tables/DT_bootstrap.js"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jquery-validation/dist/jquery.validate.min.js"
        type="text/javascript"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/fuelux/js/spinner.min.js"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/clockface/js/clockface.js"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript"
        src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jquery-multi-select/js/jquery.quicksearch.js"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jquery.pwstrength.bootstrap/src/pwstrength.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/bootstrap-switch/static/js/bootstrap-switch.min.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/jquery-tags-input/jquery.tagsinput.min.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/bootstrap-markdown/js/bootstrap-markdown.js"
        type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"
        type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/scripts/register.js" type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/scripts/sha512.js" type="text/javascript"></script>
<script src="<?php echo BASE_PATH; ?>public/dashboard/assets/scripts/form-components.js"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function () {
        App.init();
        Register.init();
        FormComponents.init();
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>