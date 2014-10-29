<?php require_once(ROOT . DS . 'application\views\dashboard\sidebar.php'); ?>
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
            Thư viện ảnh
        </h3>
        <ul class="page-breadcrumb breadcrumb">

            <li>
                <i class="icon-home"></i>
                <a href="../dashboard">Dashboard</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>
                <a href="#">Thư viện ảnh</a>
            </li>
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
                    <button type="button" class="close btn-close-modal" data-dismiss="modal"
                            aria-hidden="true"></button>
                    <h4 class="modal-title">Thêm mới người dùng</h4>
                </div>
                <div class="modal-body">
                    <div class="scroller" style="height:500px" data-always-visible="1" data-rail-visible1="1">
                        <form novalidate="novalidate" class="add-new-user-form" role="form" action="#" method="post">
                            <div class="form-group">
                                <label class="control-label">Tên đăng nhập</label>
                                <input id="username" name="username" placeholder=""
                                       class="form-control placeholder-no-fix" type="text"><span class="loading"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <input id="email" name="email" placeholder="" class="form-control" type="text"><span
                                    class="email_loading"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Mật khẩu</label>
                                <input id="password" name="password" placeholder=""
                                       class="form-control placeholder-no-fix" type="password">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nhập lại mật khẩu</label>
                                <input id="repassword" name="repassword" placeholder=""
                                       class="form-control placeholder-no-fix" type="password">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Họ tên</label>
                                <input id="name" name="name" placeholder="" class="form-control placeholder-no-fix"
                                       type="text">
                            </div>
                            <button type="button" data-dismiss="modal" class="btn-close-modal btn default">Hủy</button>
                            <input id="add_form" type="submit" class="btn green" value="Tạo tài khoản"/><span
                                class="process_loading"></span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ajax" tabindex="-1" role="basic" aria-hidden="true">
        <img src="<?php echo URL::getPath(); ?>/public/dashboard/assets/img/ajax-modal-loading.gif" alt=""
             class="loading">
    </div>
    <!-- /.modal -->
</div>
<div id="content">
<table class="table table-striped table-bordered table-hover" id="picture_library">
<thead>
<tr>
    <th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#picture_library .checkboxes"/></th>
    <th></th>
    <th>Tệp</th>
    <th>Người Upload</th>
    <th>Upload to</th>
    <th>Ngày</th>
</tr>
</thead>
<tbody>
<tr class="odd gradeX">
    <td><input type="checkbox" class="checkboxes" value="1"/></td>
    <td><img src="http://localhost/vuithuong/wp-content/uploads/2012/07/6813233319_752a42a794_b-150x150.jpg" class="attachment-80x60" alt="6813233319_752a42a794_b" height="60" width="60"></td>
    <td><a href="">6813233319_752a42a794_b</a></td>
    <td>admin</td>
    <td class="center"><strong>Vivamus eros elementum etiam leo eu dictum rutrum,</strong><br /> <small>2012/07/30</small> </td>
    <td><span class="label label-sm label-success">Approved</span></td>
</tr>
<tr class="odd gradeX">
    <td><input type="checkbox" class="checkboxes" value="1"/></td>
    <td><img src="http://localhost/vuithuong/wp-content/uploads/2012/07/7015157331_4ff9f7772a_b-150x150.jpg" class="attachment-80x60" alt="7015157331_4ff9f7772a_b" height="60" width="60"></td>
    <td><a href="">7015157331_4ff9f7772a_b</a></td>
    <td>admin</td>
    <td class="center">12.12.2011</td>
    <td><span class="label label-sm label-warning">Suspended</span></td>
</tr>
<tr class="odd gradeX">
    <td><input type="checkbox" class="checkboxes" value="1"/></td>
    <td><img src="http://localhost/vuithuong/wp-content/uploads/2012/07/4704140020_7122011014_b-150x150.jpg" class="attachment-80x60" alt="4704140020_7122011014_b" height="60" width="60"></td>
    <td><a href="">4704140020_7122011014_b</a></td>
    <td>admin</td>
    <td class="center">12.12.2012</td>
    <td><span class="label label-sm label-success">Approved</span></td>
</tr>
<tr class="odd gradeX">
    <td><input type="checkbox" class="checkboxes" value="1"/></td>
    <td><img src="http://localhost/vuithuong/wp-content/uploads/2012/07/3461164183_544861afff_b-150x150.jpg" class="attachment-80x60" alt="3461164183_544861afff_b" height="60" width="60"></td>
    <td><a href="">7650666944_0ca214439e_b</a></td>
    <td>admin</td>
    <td class="center">12.12.2012</td>
    <td><span class="label label-sm label-default">Blocked</span></td>
</tr>
<tr class="odd gradeX">
    <td><input type="checkbox" class="checkboxes" value="1"/></td>
    <td><img src="http://localhost/vuithuong/wp-content/uploads/2012/07/423659645_11bb162aef_o-150x150.jpg" class="attachment-80x60" alt="423659645_11bb162aef_o" height="60" width="60"></td>
    <td><a href="">3461164183_544861afff_b</a></td>
    <td>admin</td>
    <td class="center">12.12.2012</td>
    <td><span class="label label-sm label-success">Approved</span></td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
</div>
</div>
<!--  END PAGE CONTENT -->
</div>
<!--  END PAGE  -->
