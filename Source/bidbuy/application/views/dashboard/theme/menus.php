<?php
require_once(ROOT . DS . 'application/views/dashboard/sidebar.php');
require_once(ROOT . DS . 'application/views/dashboard/post/function.php');
require_once(ROOT . DS . 'application/views/dashboard/theme/function.php');
?>
<!-- BEGIN PAGE -->
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="<?php URL::get_site_url(); ?>/admin">Dashboard</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <a href="#">Giao diện</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li><a href="#">Tủy chỉnh Menus</a></li>
            </ul>
            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>
    <!-- END PAGE HEADER-->
    <div class="row">
        <!-- BEGIN OPTION -->
        <div class="col-md-6">
            <div class="portlet box yellow">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-reorder"></i>Tùy chỉnh</div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div id="menu-optional-box" class="portlet-body">
                    <div class="panel-group accordion scrollable" id="accordion2">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2"
                                       href="#collapse_2_1">
                                        Liên kết
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse_2_1" class="panel-collapse in">
                                <div class="panel-body form">
                                    <form id="custom-menu-form" class="form-horizontal" role="form" method="post"
                                          action="">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Liên kết</label>

                                                <div class="col-md-9">
                                                    <input id="custom_link" name="custom_link" class="form-control"
                                                           value="http://" type="text">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Tên liên kết</label>

                                                <div class="col-md-9">
                                                    <input id="custom_menu_item" name="custom_menu_item"
                                                           class="form-control" placeholder="Menu item" type="text">
                                                </div>
                                            </div>
                                            <input id="submit-custom-menu" type="submit" class="btn green" value="Thêm"><span
                                                class="loading"></span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2"
                                       href="#collapse_2_4">
                                        Chuyên mục
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse_2_4" class="panel-collapse collapse">
                                <div class="panel-body form">
                                    <div style="display: block;" id="category-all" class="tabs-panel">
                                        <input name="post_category[]" value="0" type="hidden">
                                        <ul id="categorychecklist">
                                            <?php
                                            $func = new postFunction();
                                            if (isset($this->info['category']))
                                                $selected = $this->info['category'][0]['id'];
                                            else
                                                $selected = false;
                                            $func->returnAllCategories($this->childCategories, $this->listCategories, $selected);
                                            ?>
                                        </ul>
                                    </div>
                                    <button id="category-menu-btn" class="btn green">Thêm</button><span class="loading_category"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END OPTION -->
        <!-- BEGIN MENUS SHOW -->
        <div class="col-md-6">
            <div class="portlet box yellow">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-comments"></i>Main Menu</div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div id="menu-optional-box" class="portlet-body">
                    <div id="remove_menu_item" style="min-height: 50px">
                        <form>
                            <div class="form-group col-md-6">
                                <select id="remove-item-list" class="form-control input-medium">
                                    <option value="-1">Chọn item để xóa</option>
                                    <?php
                                    echo $this->menuOptionItem;
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <input id="remove-item" class="btn green" value="Xóa" />
                            </div>
                        </form>
                    </div>
                    <div class="dd" id="main_menu_list">
                        <ol id="main_list" class="dd-list">
                            <?php
                            echo $this->menuList;
                            ?>
                        </ol>
                    </div>
                    <input type="hidden" id="nestable_list_1_output" disabled />
                    <button id="save-menu-btn" class="btn green">Lưu thay đổi</button><span class="loading_save"></span>
                </div>
            </div>
        </div>
        <!-- END MENUS SHOW -->
    </div>
</div>
<!-- END PAGE -->