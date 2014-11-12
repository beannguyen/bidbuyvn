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
                    <form id="general_setting_form" class="form-horizontal" role="form" method="post">
                        <div class="alert alert-success display-hide">
                            <strong>Cập nhật thành công!</strong>
                        </div>
                        <div class="alert alert-warning display-hide">
                            <strong>Đã xảy ra lỗi, vui lòng thử lại!</strong>
                        </div>
                        <div class="form-body">
                            <div class="form-group">
                                <label  class="col-md-3 control-label">Tiêu đề trang</label>
                                <div class="col-md-9">
                                    <input type="text" id="site_title" name="site_title" class="form-control"  placeholder="Nhập tiêu đề blog" value="<?php if(!empty($this->settings)) echo $this->settings['site_title']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-md-3 control-label">Địa chỉ Email</label>
                                <div class="col-md-9">
                                    <input type="text" id="email_address" name="email_address" class="form-control"  placeholder="Nhập địa chỉ Email của người quản trị" value="<?php if(!empty($this->settings)) echo $this->settings['admin_email']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-md-3 control-label">Hotline</label>
                                <div class="col-md-9">
                                    <input type="text" id="hotline_support" name="hotline_support" class="form-control"  placeholder="Số điện thoại sẽ hiện thị ra trang chủ" value="<?php if(!empty($this->settings)) echo $this->settings['hotline_support']; ?>">
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