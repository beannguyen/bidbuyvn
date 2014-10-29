<?php require_once(ROOT . DS . 'application/views/dashboard/sidebar.php'); ?>


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
                    <a href="#">Quản lý giỏ hàng</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>Tất cả hóa đơn</li>
            </ul>
            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>
    <!--  END PAGE HEADER -->
    <!--  BEGIN PAGE CONTENT -->
    <div class="col-md-12">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet gren">
            <div class="portlet-title">
                <div class="caption"><i class="icon-reorder"></i>Tất cả hóa đơn <span class="badge">6</span></div>
            </div>
            <div class="portlet-body">
                <!-- BEGIN ORDERS TOOLBAR -->
                <div class="custom-toolbar row">
                    <div class="item">
                        <a href="<?php URL::get_site_url(); ?>/admin/create_orders" class="btn green">Thêm mới <i class="icon-plus"></i></a>
                    </div>
                    <div class="item">
                        <select class="form-control input-medium">
                            <option>Tất cả các ngày</option>
                            <option>Option 2</option>
                            <option>Option 3</option>
                            <option>Option 4</option>
                            <option>Option 5</option>
                        </select>
                    </div>
                    <div class="item">
                        <select  class="form-control input-medium select2me" data-placeholder="Chọn tên khách hàng...">
                            <option value=""></option>
                            <option value="AL">Alabama</option>
                            <option value="WY">Wyoming</option>
                        </select>
                        <a href="javascript:;" class="btn green"><i class="icon-search"></i></a>
                    </div>
                </div>
                <!-- END ORDERS TOOLBAR -->
                <!-- BEGIN TABLE DATA -->
                <div class="row">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                        <tr>
                            <th><i class="icon-info-sign"></i> Trạng thái</th>
                            <th><i class="icon-file"></i> Hóa Đơn</th>
                            <th class="hidden-xs"><i class="icon-truck"></i> Địa Chỉ</th>
                            <th><i class="icon-calendar"></i> Ngày lập</th>
                            <th><i class="icon-shopping-cart"></i> Tổng cộng</th>
                            <th><i class="icon-cog"></i> Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    On hold
                                </td>
                                <td>
                                    <a href="#">#11</a> by <strong><a href="#">Customer A</a></strong>
                                </td>
                                <td>
                                    bean, 42 Man Thien, Ho Chi Minh, Viet Nam
                                </td>
                                <td>
                                    22/10/2014
                                </td>
                                <td>
                                    300,000d
                                </td>
                                <td>
                                    <a href="javascript:;" class="btn blue"><i class="icon-eye-open"></i></a>
                                    <a href="javascript:;" class="btn blue"><i class="icon-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Pending
                                </td>
                                <td>
                                    <a href="#">#12</a> by <strong><a href="#">Customer B</a></strong>
                                </td>
                                <td>
                                    bean, 1 Vo Van Ngan, Ho Chi Minh, Viet Nam
                                </td>
                                <td>
                                    21/10/2014
                                </td>
                                <td>
                                    1,000,000d
                                </td>
                                <td>
                                    <a href="javascript:;" class="btn blue"><i class="icon-eye-open"></i></a>
                                    <a href="javascript:;" class="btn blue"><i class="icon-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <ul class="pagination pull-right">
                        <li><a href="#"><i class="icon-angle-left"></i></a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">6</a></li>
                        <li><a href="#"><i class="icon-angle-right"></i></a></li>
                    </ul>
                </div>
                <!-- END TABLE DATA -->
            </div>
        </div>
        <!-- END Portlet PORTLET-->
    </div>
    <!--  END PAGE CONTENT -->
</div>
<!--  END PAGE  -->
