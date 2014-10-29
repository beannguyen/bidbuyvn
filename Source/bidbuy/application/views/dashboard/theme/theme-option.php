<?php
require_once(ROOT . DS . 'application/views/dashboard/sidebar.php');
require_once('function.php');
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
                    <a href="<?php echo URL::get_site_url(); ?>/admin">Dashboard</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <a href="#">Chỉnh sửa giao diện</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li><a href="#tab_2-2">Tùy chỉnh giao diện</a></li>
            </ul>
            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>
    <?php if (isset($this->updateStatus) && $this->updateStatus === 'updated') { ?>
        <div class="alert alert-success">
            <strong>Cập nhật thành công!</strong>
        </div>
    <?php } elseif (isset($this->updateStatus) && $this->updateStatus === 'failed') { ?>
        <div class="alert alert-danger">
            <strong>Đã xảy ra lỗi!</strong> Vui lòng kiểm tra và thử lại.
        </div>
    <?php } ?>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row user-setting">
        <div class="col-md-3">
            <ul class="ver-inline-menu tabbable margin-bottom-10">
                <li class="active">
                    <a data-toggle="tab" href="#tab_1-1">
                        <i class="icon-cog"></i>
                        Tổng quan
                    </a>
                    <span class="after"></span>
                </li>
                <li><a data-toggle="tab" href="#tab_2-2"><i class="icon-warning-sign"></i> Trang chủ</a></li>
            </ul>
        </div>
        <div class="col-md-9">
            <div class="tab-content">
                <div id="tab_1-1" class="tab-pane active">
                    <form class="form-horizontal" role="form">

                    </form>
                </div>
                <div id="tab_2-2" class="tab-pane">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet">
                                <div class="portlet-title">
                                    <div class="caption">Chỉnh sửa trang chủ</div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <div id="help-tips">
                                        <p class="description" style="padding:10px;">
                                            <strong>Để thêm mới 1 box</strong>: nhấn vào tên của từng chuyên mục để
                                            chọn,<br/>
                                            bạn có thể chọn nhiều chuyên mục cùng lúc.<br/>
                                            <strong>Để bỏ chọn:</strong> bạn nhấn vào tên chuyên mục đó trong danh sách
                                            đã chọn.<br/>
                                            Đừng quên nhấn nút <strong>Lưu lại</strong>.
                                        </p>
                                        <hr/>
                                    </div>
                                    <form action="<?php echo URL::get_site_url(); ?>/admin/theme/updateHomeBoxOption"
                                          method="post" class="form-horizontal form-row-seperated">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Chọn chuyên mục</label>

                                                <div class="col-md-9">
                                                    <select multiple="multiple" class="multi-select"
                                                            id="home_box_multi_select" name="home_box_multi_select[]">
                                                        <?php loadListHomepageBox(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                </div>
                                <div class="form-actions fluid">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">Lưu lại</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END SAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--end col-md-9-->
</div>
<!-- END PAGE CONTENT-->
</div>
<!-- END PAGE -->