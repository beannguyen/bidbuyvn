<?php
require_once(ROOT . DS . 'application/views/dashboard/sidebar.php');
require_once('function.php');

$func = new postFunction();
?>
<!--  BEGIN PAGE  -->
<div class="page-content">
<!--  BEGIN PAGE HEADER -->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Quản lý bài viết
            <small>Tất cả bài viết</small>
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li class="btn-group">
                <button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                        data-delay="1000" data-close-others="true">
                    <span>Actions</span> <i class="icon-angle-down"></i>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <li><a href="./addnewpost">Thêm mới</a></li>
                    <li><a href="./category">Chuyên mục</a></li>
                    <li class="divider"></li>
                    <li><a href="./allpost">Tất cả bài viết</a></li>
                </ul>
            </li>
            <li>
                <i class="icon-home"></i>
                <a href="../dashboard">Dashboard</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>
                <a href="#">Quản lý bài viết</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>Tất cả bài viết</li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!--  END PAGE HEADER -->
<!--  BEGIN PAGE CONTENT -->
<div class="row">
<div class="col-md-12">

    <div class="table-toolbar">
        <div class="btn-group">
        <a href="./addnewpost" id="add_new_post_btn" class="btn green">
            Thêm mới <i class="icon-plus"></i>
        </a>
        </div>

        <div class="clearfix"></div>
    </div>
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box white">
<div class="portlet-title">
    <div class="caption btn-group-post-filter">
        <ul class="subsubsub">
            <i class="icon-globe"></i>
            <li class=""><a id="show-all-btn" href="allpost/all">Tất cả <span class="count"></span></a> |</li>
            <li class=""><a id="show-published-btn" href="allpost/publish">Đã đăng <span class="count"></span></a> |</li>
            <li class=""><a id="show-draft-btn" href="allpost/draft">Bản nháp <span class="count"></span></a> |</li>
            <li class="trash"><a id="show-trash-btn" href="allpost/trash">Đã xóa <span class="count"></span></a></li>
        </ul>
    </div>
    <div class="tools">
        <div class="btn-group pull-right">
            <button class="btn dropdown-toggle" data-toggle="dropdown">Thao tác <i class="icon-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right">
                <li><a href="#">Chỉnh sửa</a></li>
                <li><a href="#">Xóa</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="portlet-body">
<div id="post-filter">
    <div class="form-group category-filter">
        <select class="form-control input-large">
            <option value="-1">Chọn chuyên mục</option>
            <?php $func->returnAllTaxonomy(); ?>
        </select>
    </div>
    <button type="submit" class="btn btn-default action-filter">Lọc kết quả</button>
    <div class="clearfix"></div>
</div>
<table class="table table-striped table-bordered table-hover" id="all_post_manager">
<thead>
<tr>
    <th style="width1:8px;" class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#all_post_manager .checkboxes"/>
    </th>
    <th>Tên bài viết</th>
    <th>Người viết</th>
    <th>Chuyên mục</th>
    <th>Ngày viết</th>
    <th>Trạng thái</th>
</tr>
</thead>
<tbody>
<?php
$func->loadPostList($this->postStatus);
?>
</tbody>
</table>
</div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
</div>
</div>
<!--  END PAGE CONTENT -->
</div>
<!--  END PAGE  -->
