<?php
require_once(ROOT . DS . 'application/views/dashboard/sidebar.php');
?>
<!-- BEGIN PAGE -->
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
                Quản lý người dùng
                <small>Cài đặt</small>
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
                <li><a href="#">Cài đặt</a></li>
            </ul>
            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>
    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">Cài đặt hệ thống</div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="portlet-body">
                    <form id="mailserv_setting_form" class="form-horizontal" role="form" method="post">
                        <div class="alert alert-success display-hide">
                            <strong>Cập nhật thành công!</strong>
                        </div>
                        <div class="alert alert-warning display-hide">
                            <strong>Đã xảy ra lỗi, vui lòng thử lại!</strong>
                        </div>
                        <div class="form-body">
                            <div class="form-group">
                                <label  class="col-md-3 control-label">Mail Server</label>
                                <div class="col-md-6">
                                    <input type="text" id="mailserver_url" name="mailserver_url" class="form-control"  placeholder="Nhập địa chỉ máy chủ" value="<?php echo $this->settings['mailserver_url']; ?>">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="mailserver_port" name="mailserver_port" class="form-control" placeholder="Port" value="<?php echo $this->settings['mailserver_port']; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-md-3 control-label">Địa chỉ Email</label>
                                <div class="col-md-9">
                                    <input type="text" id="mailserver_login" name="mailserver_login" class="form-control" value="<?php echo $this->settings['mailserver_login']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-md-3 control-label">Mật khẩu</label>
                                <div class="col-md-9">
                                    <input type="text" id="mailserver_pass" name="mailserver_pass" class="form-control" value="<?php echo $this->settings['mailserver_pass']; ?>">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="form-actions fluid">
                    <div class="col-md-offset-3 col-md-9">
                        <input type="submit" id="btn-submit-form" class="btn green" value="Lưu lại" /><span class="process_loading"></span>
                    </div>
                </div>
                </form>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        </div>
    </div>
</div>