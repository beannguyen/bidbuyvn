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
    <!-- BEGIN PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
                Quản lý chuyên mục
                <small>Chỉnh sửa chuyên mục</small>
            </h3>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="<?php echo URL::get_site_url(); ?>/dashboard">Dashboard</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <a href="#">Bài Viết</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <a href="#">Chỉnh sửa chuyên mục</a>
                </li>
            </ul>
            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <?php if(isset($this->termNotFound) && $this->termNotFound == true) : ?>
        <div class="alert alert-danger">
            <strong>Error!</strong> Không tìm thấy chuyên mục bạn yêu cầu.
        </div>
    <?php return; endif; ?>
    <div id="alert" class="alert alert-success update-success display-hide">
        <strong>Success!</strong> Thay đổi của bạn đã được cập nhật thành công.
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tabbable tabbable-custom boxless">

                <div class="tab-content">


                    <div class="tab-pane active" id="tab_4">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-reorder"></i>Chỉnh sửa chuyên mục</div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form id="modify_taxonomy" action="#" method="POST" class="form-horizontal form-row-seperated">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Tên</label>

                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $taxInfo['name']; ?>">
                                                <span class="help">Tên của chuyên mục.</span>
                                                <span class="loading"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Slug (đường dẫn)</label>

                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="category_slug" name="category_slug" value="<?php echo $taxInfo['slug']; ?>">
                                                <span class="help">“Slug” là đường dẫn đã được tối ưu SEO của chuyên mục. Nó chỉ chứa chử thường, số và dấu gạch ngang (-).</span>
                                                <span class="loading"></span>
                                            </div>
                                        </div>
                                        <?php if($this->taxonomy == 'category'): ?>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Chuyên mục cha</label>

                                            <div class="col-md-9">
                                                <select class="form-control" id="category_parent" name="category_parent">
                                                    <?php
                                                        if(isset($this->parent))
                                                        {
                                                            echo "<option value='".$this->parent['term_id']."'>".$this->parent['name']."</option>";
                                                            echo "<option value='0'>Không có</option>";
                                                            $func->returnAllTaxonomy('category', false, $this->parent['term_id'], $this->term_id);
                                                        }
                                                        else
                                                        {
                                                            echo "<option value='0'>Không có</option>";
                                                            $func->returnAllTaxonomy('category', false, false, $this->term_id);
                                                        }
                                                    ?>
                                                </select>
                                                <span class="help">Chuyên mục, không giống như Thẻ, nó có thể có hệ thống phân cấp.</span>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Mô tả</label>

                                            <div class="col-md-9">
                                                <textarea class="form-control" id="category_description" name="category_description" cols="0" rows="5"><?php echo $taxInfo['description']; ?></textarea>
                                            </div>
                                        </div>

                                        <input type="hidden" id="category_id" name="category_id" value="<?php echo $this->term_id; ?>" />
                                        <input type="hidden" id="taxonomy" name="taxonomy" value="<?php echo $this->taxonomy; ?>" />
                                    </div>
                                    <div class="form-actions fluid">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button id="submit_change_taxonomy" type="submit" class="btn green">Lưu thay đổi</button>
                                                    <span class="process_loading"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- END FORM-->
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>