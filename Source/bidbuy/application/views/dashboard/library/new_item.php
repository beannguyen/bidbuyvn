<?php require_once(ROOT . DS . 'application\views\dashboard\sidebar.php'); ?>
<!-- BEGIN PAGE -->
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
                Tải lên tệp ảnh mới
            </h3>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="<?php echo URL::get_site_url(); ?>/dashboard">Dashboard</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <a href="<?php echo URL::get_site_url(); ?>/dashboard/library">Thư viện ảnh</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li><a href="#">Thêm mới</a></li>
            </ul>
            <!-- END PAGE TITLE & BREADCRUMB-->
            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row dropzone-form">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Chú ý</h3>
                </div>
                <div class="panel-body">
                    <ul>
                        <li>Kích cỡ ảnh lớn nhất là <strong>2 MB</strong></li>
                        <li>Chỉ hỗ trợ upload các định dạng (<strong>JPG, JPEG, PNG</strong>).</li>
                    </ul>
                </div>
            </div>

            <form action="<?php echo URL::get_site_url(); ?>/upload/process" class="dropzone" id="my-dropzone"></form>
            <span id="switch-to-basic-form" class="help-block"><a href="javascript:;">Chọn chế độ upload cơ bản</a></span>
        </div>
    </div>
    <div class="row basic-form display-hide">
        <form action="<?php echo URL::get_site_url(); ?>/upload/process" method="post" class="basic-upload" id="basic-upload" enctype="multipart/form-data">
            <input type="file" name="uploaded_image" /><br />
            <input type="submit" class="btn" name="submit" value="Upload" />
        </form>
        <span id="switch-to-dropzone-form" class="help-block"><a href="javascript:;">Chọn chế độ upload nhiều file</a></span>
    </div>
    <!-- END PAGE CONTENT-->
</div>
<!-- END PAGE -->