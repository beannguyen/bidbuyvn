<?php
    require_once(ROOT . DS . 'application/views/dashboard/sidebar.php');
    require_once('function.php');
    $func = new postFunction();
    if(isset($this->info))
    {
        foreach($this->info as $k => $v)
        {
            $taxInfo[$k] = $v;
        }
    } else
    {
        $taxInfo = array();
    }
?>
<!-- BEGIN PAGE -->
<div class="page-content">
    <div class="alert alert-warning alert-dismissable delete_error display-hide">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        <strong>Warning!</strong> Chuyên mục đang chứa bài viết, hãy chuyển tất cả bài viết sang chuyên mục khác để xóa.
    </div>
    <div class="alert alert-warning alert-dismissable delete_warning display-hide">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        <strong>Warning!</strong> Một số chuyên mục không thể xóa vì chứa bài viết hoặc bạn đang cố xóa chuyên mục mặc định.
    </div>
    <!-- BEGIN PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
                Chuyên mục
            </h3>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="<?php echo URL::get_site_url(); ?>/admin">Dashboard</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <a href="#">Tất cả bài viết</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li><a href="#">Chuyên mục</a></li>
            </ul>
            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>
    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-4 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-reorder"></i><?php echo ($this->taxonomy == 'category') ? 'Thêm chuyên mục' : 'Thêm thẻ' ?>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form id="submit-new-taxonomy" role="form" method="POST"
                          action="<?php echo URL::get_site_url(); ?>/admin/taxonomy/newTaxonomy">
                        <div class="form-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên</label>
                                <input class="form-control" name="category_name" id="category_name" type="text">
                                <span class="help-block">Tên của chuyên mục.</span>
                            </div>
                            <div class="form-group">
                                <label>Slug (đường dẫn)</label>

                                <div class="input-group">
                                    <input name="category_slug" id="category_slug" class="form-control" type="text">
                                    <span class="help">“Slug” là đường dẫn đã được tối ưu SEO của chuyên mục. Nó chỉ chứa chử thường, số và dấu gạch ngang (-).</span>

                                </div>
                            </div>
                            <?php if($this->taxonomy == 'category') : ?>
                            <div class="form-group">
                                <label>Chuyên mục cha</label>
                                <select name="category_parent" class="form-control">
                                    <option value="0">Không có</option>
                                    <?php $func->returnAllTaxonomy($this->taxonomy); ?>
                                </select>
                                <span
                                    class="help">Chuyên mục, không giống như Thẻ, nó có thể có hệ thống phân cấp.</span>
                            </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea class="form-control" id="description" name="category_description"
                                          rows="3"></textarea>
                                <span class="help">Ở chế độ mặc định, phần mô tả chuyên mục sẽ không được hiên thị; Tuy nhiên, một vài giao diện có thể hiển thị nó.</span>
                            </div>
                            <input type="hidden" id="taxonomy" name="taxonomy" value="<?php echo $this->taxonomy; ?>" />
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn blue" id="addnewcategory"><?php echo ($this->taxonomy == 'category') ? 'Thêm chuyên mục' : 'Thêm thẻ' ?></button>
                            <span class="loading"></span>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>
        <div class="col-md-8 ">
            <table class="table table-striped table-bordered table-hover" id="all_categories">
                <thead>
                <tr>
                    <th style="width: 8px;" class="table-checkbox">
                        <input type="checkbox" class="group-checkable" data-set="#all_categories .checkboxes"/>
                    </th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Slug</th>
                    <th>Post</th>
                </tr>
                </thead>
                <tbody>
                <?php $func->returnAllTaxonomy($this->taxonomy, true); ?>
                </tbody>
            </table>
            <div class="top-conten-right input-group input-small">
                <select id="select-bulk-action" name="select-bulk-action" class="form-control input-small">
                    <option value="-1" selected="selected">Bulk Actions</option>
                    <option value="delete">Delete</option>

                </select>
                      <span class="input-group-btn">
                            <button id="bulk-action" class="btn green" type="button">Apply</button>
                          <span class="bulk_action_loading"></span>
                      </span>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE -->

