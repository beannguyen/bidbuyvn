<?php require_once(ROOT . DS . 'application/views/dashboard/sidebar.php'); ?>
<!-- BEGIN PAGE -->
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
                Lỗi hệ thống
            </h3>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="index.html">Dashboard</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <a href="#">Lỗi</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li><a href="#"><?=(isset($this->errName)) ? $this->errName : 'Thông báo lỗi'; ?></a></li>
            </ul>
            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12 page-500">
            <div class=" number">
                Oops!
            </div>
            <div class=" details">
                <h3><?=(isset($this->errName)) ? $this->errName : 'Thông báo lỗi'; ?></h3>
                <p>
                    <?=(isset($this->errDetail)) ? $this->errDetail : 'Lỗi hệ thống'; ?>
                </p>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
<!-- BEGIN PAGE -->