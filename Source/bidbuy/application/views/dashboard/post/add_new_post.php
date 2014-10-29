<?php
require_once(ROOT . DS . 'application/views/dashboard/sidebar.php');
function createSubmitTypeBtn ( $postStatus )
{
    $btn = array();
    switch ( $postStatus ) {

        case 'publish' :
            $btn['id'] = 'Update';
            $btn['name'] = 'Cập nhật';
            break;
        case 'draft' :
            $btn['id'] = 'Update';
            $btn['name'] = 'Đăng bài';
            break;
        case 'trash' :
            $btn['id'] = 'Update';
            $btn['name'] = 'Đăng lại bài';
            break;
        default:
            $btn['id'] = 'Publish';
            $btn['name'] = 'Đăng bài';
            break;
    }
    return $btn;
}
?>
<!--  BEGIN PAGE  -->
<div class="page-content">
<!--  BEGIN PAGE HEADER -->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Quản lý bài viết
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="../admin">Dashboard</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>
                <a href="<?php echo URL::get_site_url(); ?>/admin/allpost">Quản lý bài viết</a>
                <i class="icon-angle-right"></i>
            </li>
            <li><?php if(!isset($this->info)): echo 'Viết bài mới'; else: echo 'Chỉnh sửa bài viết'; endif; ?></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!--  END PAGE HEADER -->
<!-- POST ALERT -->
<div class="alert alert-success <?php if( !isset( $this->success ) && $this->success == false) echo 'display-hide'; ?>">
    <strong>Success!</strong> Bài viết đã được đăng thành công.
</div>
<!-- END POST ALERT -->
<div id="row-1" class="row">
<div id="post-detail" class="col-md-9 ">
    <div class="form-main">
        <div class="form-group">
            <!-- TITLE -->
            <div id="titlewrap">
                <input class="form-control" id="post-title" placeholder="Tiêu đề bài viết" type="text" value="<?=(isset($this->info['post_title'])) ? $this->info['post_title'] : ''; ?>">
                <span class="help-block"></span>
            </div>
            <!-- END TITLE -->
            <!-- PERMALINK -->
            <div class="inside">
                <!-- MODAL SLUG POST -->
                <?php if(isset($this->info)): ?>
                <div id="edit-slug-box">
                    <strong>Permalink:</strong>
                        <span id="sample-permalink" tabindex="-1"><?php echo URL::get_site_url(); ?>/p/<span id="slug-category"><?php echo $this->info['category'][0]['slug']; ?></span>/<a href="#"
                                                                                                            id="permalink"
                                                                                                            data-type="text"
                                                                                                            data-pk="1"
                                                                                                            data-original-title="Permalink"><?php echo $this->info['post_name']; ?></a>.html</span>
                        <span id="change-permalinks"><a href="#" class="btn green" target="_blank">Change
                                Permalinks</a></span>
                        <span id="view-post-btn"><a href="<?php echo URL::get_site_url(); ?>/p/<?php echo $this->info['category'][0]['slug']; ?>/<?php echo $this->info['post_name']; ?>.html"
                                                    class="btn green" target="_blank">View Post</a></span>
                </div>
                <?php endif; ?>
                <!-- END MODAL SLUG POST -->
                <!-- MODAL UPLOAD IMAGES -->
                <div id="upload-media-btn">
                    <div class="btn-group">
                        <a id="upload-btn" class=" btn green display-hide" href="#responsive" data-toggle="modal">
                            Thêm ảnh <i class="icon-plus"></i>
                        </a>
                    </div>
                </div>
                <div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Tải ảnh lên</h4>
                            </div>
                            <div class="modal-body">
                                <div class="scroller" style="height:500px" data-always-visible="1" data-rail-visible1="1">
                                    <form action="<?php echo URL::get_site_url(); ?>/admin/upload/process" class="dropzone" id="my-dropzone">
                                        <input id="post-id" type="hidden" value="1" name="post-id" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END MODAL UPLOAD IMAGES -->
                <!-- MODAL EDIT IMAGES DETAIL -->
                <a id="edit-image-btn" class="display-hide" href="#edit-image" data-toggle="modal"></a>
                <div id="edit-image" class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Chỉnh sửa ảnh</h4>
                            </div>
                            <div class="modal-body">
                                <div class="scroller" style="height:500px" data-always-visible="1" data-rail-visible1="1">
                                    <form action="#" class="form-horizontal edit-image-form">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Tiêu đề</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" id="image-title" placeholder="Tiêu đề ảnh" type="text">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Alternate</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" id="image-alt" placeholder="Thẻ alt" type="text">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Chú thích</label>
                                                <div class="col-md-9">
                                                    <textarea class="form-control" id="image-caption"></textarea>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Canh lề</label>
                                                <div class="col-md-9">
                                                    <select id="image-align" class="form-control input-lg">
                                                        <option value="-1">Không</option>
                                                        <option value="left">Trái</option>
                                                        <option value="center">Giữa</option>
                                                        <option value="right">Phải</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Kích cỡ</label>
                                                <div class="col-md-9">
                                                    <select id="image-size" class="form-control input-lg">
                                                        <option value="0">Mặc định</option>
                                                        <option value="1">Trung bình</option>
                                                        <option value="2">Nhỏ</option>
                                                        <option value="thumb">Thumbnails</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Link ảnh</label>
                                                <div class="input-group col-md-9">
                                                    <input class="form-control" id="image-url" type="url" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="checkbox-list input-group col-md-9">
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" id="set-feature-image-checker" value="1"> Đặt làm ảnh đại diện?
                                                    </label>
                                                </div>
                                            </div>
                                            <input type="hidden" id="image-width" />
                                            <input type="hidden" id="image-height" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn default" data-dismiss="modal">Hủy</button>
                                <button type="button" id="add-image" class="btn blue">Thêm vào</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- MODAL EDIT IMAGES DETAIL -->
            </div>
            <!-- CONTENT -->
            <div id="post-content">
                <script type="text/javascript" src="<?php echo BASE_PATH; ?>public/dashboard/assets/plugins/tinymce/tinymce.min.js"></script>
                <script type="text/javascript" src="<?php echo BASE_PATH; ?>public/dashboard/assets/scripts/tinymce-advanted.js"></script>

                <textarea name="content" class="post-content" style="width:100%; height: 390px; overflow-y: scroll;"><?php if(isset($this->info)) { echo $this->info['post_content']; } ?></textarea>
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
</div>

<div id="post-sidebar" class="col-md-3">
    <!-- PUBLISH -->
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-reorder"></i>
                <?php
                    if(!isset($this->info)) {
                        echo 'Đăng bài';
                    } else {
                        echo'Cập nhật';
                    }
                ?>
            </div>
            <div class="tools">
                <a href="" class="collapse"></a>
            </div>
        </div>
        <div class="portlet-body form">
            <div id="post-status">
                <div id="misc-publishing-actions">

                    <div class="misc-pub-section misc-pub-post-status"><label class="icon-bell">Status:</label>
                        <strong id="post-status-display"><?php if(isset($this->info)) { if($this->info['post_status'] == 'publish') echo 'Đã đăng'; else if($this->info['post_status'] == 'draft') echo 'Bản nháp'; else echo 'Đã bị xóa'; } ?></strong>
                    </div>
                    <!-- .misc-pub-section -->

                    <div class="misc-pub-section curtime misc-pub-curtime">
                        <span id="timestamp">
                        Published on: <b><?php if(isset($this->info)) { echo date_format(date_create($this->info['post_modified']), 'd M Y H:i'); } ?></b></span>
                        <br/>
                        <?php if(isset($this->info) && $this->info['post_status'] != 'trash'): ?>
                        <a href="javascript:;" class="delete-post-btn" style="color: red">
                            Xóa bài viết
                        </a>
                        <?php elseif(!isset($this->info)): ?>
                        <a href="javascript:;" class="save-draft-btn" style="color: red">
                            Lưu bản nháp
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <a href="javascript:;" id="<?php if ( isset( $this->info['post_status'] ) ): echo createSubmitTypeBtn( $this->info['post_status'] )['id']; else: echo 'Publish'; endif; ?>" class="btn green">
                    <?php if ( isset( $this->info['post_status'] ) ): echo createSubmitTypeBtn( $this->info['post_status'])['name']; else: echo 'Đăng bài'; endif; ?>
                </a>
            </div>
        </div>
    </div>
    <!-- CATEGORY -->
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-reorder"></i> Chuyên mục
            </div>
            <div class="tools">
                <a href="" class="collapse"></a>
            </div>
        </div>
        <div id="box-category" class="portlet-body form">
            <div style="display: block;" id="category-all" class="tabs-panel">
                <input name="post_category[]" value="0" type="hidden">
                <ul id="categorychecklist">
                    <?php
                        require_once('function.php');
                        $func = new postFunction();
                        if(isset($this->info['category']))
                            $selected = $this->info['category'][0]['id'];
                        else
                            $selected = false;
                        $func->returnAllCategories($this->childCategories, $this->listCategories, $selected);
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-reorder"></i> Thẻ
            </div>
            <div class="tools">
                <a href="" class="collapse"></a>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="form-group">
                <input id="tags" type="text" class="form-control tags small" value="<?php if(isset($this->info['tag'])) echo $this->info['tag']; ?>"/>
            </div>
        </div>
    </div>
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-reorder"></i> Ảnh đại diện
            </div>
            <div class="tools">
                <a href="" class="collapse"></a>
            </div>
        </div>
        <div class="portlet-body form">
            <div id="feature-view">
                <?php
                    if(!empty($this->info['post_feature_img']))
                    {
                        echo "<img src='".$this->info['post_feature_img']."' width='245' />";
                    }
                ?>
            </div>
            <input type="hidden" id="feature-url" name="feature-url" value="<?php if(!empty($this->info['post_feature_img'])) echo $this->info['post_feature_img']; ?>" />
            <div id="feature-action">
                <a id="set-feature-image-btn" class="<?php if(empty($this->info['post_feature_img'])): echo ''; else: echo 'display-hide'; endif; ?>" title="Nhấn vào để chọn ảnh đại diện cho bài viết" href="#responsive" data-toggle="modal">Chọn ảnh đại diện</a>
                <a id="remove-feature-image-btn" class="<?php if(empty($this->info['post_feature_img'])): echo 'display-hide'; else: echo ''; endif; ?>" title="Nhấn vào để xóa ảnh đại diện cho bài viết" href="javascript:;">Xóa ảnh đại diện</a>
            </div>
        </div>
    </div>
</div>
<div id="PublishForm" class="display-hide"></div>
<div id="UpdateForm" class="display-hide"></div>
<input type="hidden" id="post_id" value="<?php if(isset($this->postId)) echo $this->postId; ?>" />
<!-- SEO ONPAGE -->
 <!--   <div class="col-md-9">
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-reorder"></i> Tối ưu hóa công cụ tìm kiếm
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="tabbable tabbable-custom boxless">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_0" data-toggle="tab">Tổng quan</a></li>
                        <li><a href="#tab_1" data-toggle="tab">Tab 2</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Tab 3</a></li>
                        <li><a href="#tab_3" data-toggle="tab">Tab 4</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_0">
                            <form class="form-horizontal" role="form">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Focus Keyword</label>

                                        <div class="col-md-9">
                                            <input type="text" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">SEO Title</label>

                                        <div class="col-md-9">
                                            <input type="text" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Meta description</label>

                                        <div class="col-md-9">
                                            <textarea class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Meta Keyword</label>

                                        <div class="col-md-9">
                                            <input type="text" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="tab_1"></div>
                        <div id="tab_2"></div>
                        <div id="tab_3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
<!-- END SEO ONPAGE -->
</div>
</div>
<!--  END PAGE  -->