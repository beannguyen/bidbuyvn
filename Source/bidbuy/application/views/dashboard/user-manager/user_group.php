<?php require_once(ROOT . DS . 'application/views/dashboard/sidebar.php'); ?>
<?php require("function.php"); ?>
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
                <small>Nhóm người dùng</small>
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
                <li>Nhóm người dùng</li>
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
                        <a href="javascript:;" class="remove"></a>
                    </div>
                </div>
                <div class="portlet-body">
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
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true"></button>
                                        <h4 class="modal-title">Thêm mới nhóm người dùng</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="scroller" style="height:500px" data-always-visible="1"
                                             data-rail-visible1="1">
                                            <form novalidate="novalidate" class="add-new-group" role="form"
                                                  action="<?php echo URL::get_site_url(); ?>/register/adminAddNewUser"
                                                  method="post">
                                                <div class="note note-success display-hide">
                                                    <h4 class="block">Tạo nhóm thành công</h4>

                                                    <p>
                                                        Nhóm mới tạo đã có thể hoạt động. Bạn có thể thêm người dùng vào nhóm.
                                                    </p>

                                                    <div id="timer"><em>Trang sẽ reload sau 3s</em></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Tên nhóm</label>
                                                    <input id="level_name" name="level_name" placeholder="Nhập tên nhóm người dùng"
                                                           class="form-control placeholder-no-fix" type="text"><span
                                                        class="level_name_loading"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Cấp bậc</label>
                                                    <input id="level_level" name="level_level"
                                                           placeholder="Nhập cấp độ nhóm người dùng"
                                                           class="form-control placeholder-no-fix" type="text"><span
                                                        class="level_level_loading"></span>
                                                </div>
                                                <button type="button" data-dismiss="modal" class="btn default">Hủy
                                                </button>
                                                <input id="add_form" type="submit" class="btn green" value="Tạo nhóm"/><span class="process_loading"></span>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="ajax" tabindex="-1" role="basic" aria-hidden="true">
                            <img src="<?php echo URL::getPath(); ?>/public/dashboard/assets/img/ajax-modal-loading.gif"
                                 alt="" class="loading">
                        </div>
                        <!-- /.modal -->
                    </div>
                    <?php user_levels(); ?>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    <!--  END PAGE CONTENT -->
</div>
<!--  END PAGE  -->
