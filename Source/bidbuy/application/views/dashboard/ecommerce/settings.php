<?php require_once(ROOT . DS . 'application/views/dashboard/sidebar.php'); ?>

<!--  BEGIN PAGE  -->
<div class="page-content">
    <!--  BEGIN PAGE HEADER -->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
                Quản lý giỏ hàng
            </h3>
            <ul class="page-breadcrumb breadcrumb">

                <li>
                    <i class="icon-home"></i>
                    <a href="../dashboard">Dashboard</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <a href="#">Cài đặt giỏ hàng</a>
                </li>
            </ul>
            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>
    <!--  END PAGE HEADER -->

    <!-- PAGE CONTENT -->
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption"><i class="icon-reorder"></i>Cấu hình bước giá</div>
            <div class="actions">
                <div class="btn-group">
                    <a class="btn btn-sm purple" href="#" data-toggle="dropdown">
                        <i class="icon-cogs"></i> Công cụ
                        <i class="icon-angle-down "></i>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li><a id="create-new-price-step" href="javascript:;"><i class="icon-plus"></i> Tạo mới</a></li>
                        <li><a id="edit-pricing-step" href="javascript:;"><i class="icon-pencil"></i> Chỉnh sửa</a></li>
                        <li><a id="delete-pricing-step" href="javascript:;"><i class="icon-trash"></i> Xóa</a></li>
                        <li class="divider"></li>
                        <li><a href="javascript:;"><i class="icon-wrench"></i> Tối ưu</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- BEGIN PORTLET BODY -->
        <div class="portlet-body">
            <div class="alert alert-info">
                <strong>Lưu ý:</strong>
                <ul>
                    <li>Mức giá dưới của bước giá đầu tiên mặc định là 0</li>
                    <li>Mức gá dưới của bước giá kề sau phải bằng mức giá trên của bước giá trước đó</li>
                    <li>Mức giá trên của mỗi bước giá không thể bằng hoặc nhỏ hơn mức giá dưới của bước giá đó</li>
                    <li>Nhập <strong>-8</strong> ở bước giá cuối cùng: nghĩa là bước giá sẽ lớn hơn mức giá dưới và tiến đên vô cùng</li>
                    <li>Khi đã tạo bước giá cuối cùng, bạn không thể tạo mới thêm. Hãy sửa mức giá trên của bước giá cuối cùng thành một số khác -8</li>
                </ul>
            </div>
            <hr />
            <!-- BEGIN ADDING FORM -->
            <form id="create-price-step-form" class="form-inline">
                <div id="add_pricing_step_error" class="alert alert-warning display-hide"><ul></ul></div>
                <div id="update-success" class="alert alert-success display-hide">
                    <strong>Cập nhật thành công!</strong>
                </div>
                <div class="form-body">
                    <div class="form-group">
                        <label class="sr-only">Mức dưới</label>
                        <input class="form-control" id="smaller_number" name="smaller_number" placeholder="Mức dưới" type="text" disabled />
                    </div>
                    <div class="form-group">
                        <label class="sr-only" >Mức trên</label>
                        <input class="form-control" id="larger_number" name="larger_number" placeholder="Mức trên" type="text" disabled />
                    </div>
                    <div class="form-group">
                        <label class="sr-only" >Mức trên</label>
                        <input class="form-control" id="pricing_step" name="pricing_step" placeholder="Bước giá" type="text" disabled />
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="step-id" />
                        <input type="hidden" id="step-stt" />
                        <input type="hidden" id="type-action" />
                    </div>
                    <button type="button" id="submit_pricing_step" class="btn btn-default" disabled>Tạo <span class="loading"></span></button>
                </div>
            </form>
            <!-- END ADDING FORM -->
            <hr />
            <!-- BEGIN LIST PRICING STEP -->
            <table id="steps-list" class="table table-bordered table-striped table-condensed flip-content">
                <thead class="flip-content">
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th class="numeric">Mức dưới</th>
                        <th class="numeric">Mức trên</th>
                        <th class="numeric">Bước giá</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                require_once('function.php');
                $func = new productFunction();
                $func->loadPricingStep();
                ?>
                </tbody>
            </table>
            <!-- END LIST PRICING STEP -->
        </div>
        <!-- BEGIN PORTLET BODY -->
    </div>
    <!-- END PAGE CONTENT -->
</div>