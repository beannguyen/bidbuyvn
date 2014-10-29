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
            <?php if ( isset( $_SESSION['bean']['changeGroupComplete'] ) && $_SESSION['bean']['changeGroupComplete'] ) : ?>
            <div class="alert alert-success">
                <strong>Kích hoạt thành công!</strong>
            </div>
            <?php unset($_SESSION['bean']['changeGroupComplete']); endif; ?>
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box light-grey">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-globe"></i></div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="content">
                        <?php display_active_sellers(); ?>
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    <!--  END PAGE CONTENT -->
</div>
<!--  END PAGE  -->
