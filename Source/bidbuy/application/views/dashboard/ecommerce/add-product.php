<?php
require_once(ROOT . DS . 'application/views/dashboard/sidebar.php');
function createSubmitTypeBtn ( $postStatus )
{
    $btn = array();
    switch ( $postStatus ) {

        case 'on-process' :
            $btn['id'] = 'Update';
            $btn['name'] = 'Cập nhật';
            break;
        case 'pending' :
            $btn['id'] = 'Update';
            $btn['name'] = 'Cập nhật';
            break;
        case 'draft' :
            $btn['id'] = 'Publish';
            $btn['name'] = 'Đăng bài';
            break;
        case 'trash' :
            $btn['id'] = 'Update';
            $btn['name'] = 'Đăng lại bài';
            break;
        case 'timeout' :
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

$generic = new Generic();
?>
<!--  BEGIN PAGE  -->
<div class="page-content">
<!--  BEGIN PAGE HEADER -->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Quản lý hàng hóa
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="../admin">Dashboard</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>
                <a href="<?php echo URL::get_site_url(); ?>/admin/products">Quản lý hàng hóa</a>
                <i class="icon-angle-right"></i>
            </li>
            <li><?php if(!isset($this->info)): echo 'Thêm mới hàng hóa'; else: echo 'Chỉnh sửa hàng hóa'; endif; ?></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!--  END PAGE HEADER -->
<!-- POST ALERT -->
<div class="alert alert-success <?php if( !isset( $_SESSION['ssbidbuy']['postUpdated'] ) && !$_SESSION['ssbidbuy']['postUpdated'] ) { echo 'display-hide'; } else unset($_SESSION['ssbidbuy']['postUpdated']); ?>">
    <strong>Success!</strong> Bài viết đã được cập nhật thành công.
</div>
<div class="alert alert-success <?php if( !isset( $_SESSION['ssbidbuy']['postPublished'] ) && !$_SESSION['ssbidbuy']['postPublished'] ) { echo 'display-hide'; } else unset($_SESSION['ssbidbuy']['postPublished']); ?>">
    <strong>Success!</strong> Bài viết đã được đăng thành công.
</div>
<div id="product_validation" class="alert alert-warning alert-dismissable display-hide">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <span class="message"></span>
</div>
<!-- END POST ALERT -->
<div id="row-1" class="row">
<div id="post-detail" class="col-md-9 ">
    <div class="form-main">
        <div class="form-group">
            <!-- TITLE -->
            <div id="titlewrap">
                <input class="form-control" id="product-title" placeholder="Tên hàng hóa" type="text" value="<?=(isset($this->info['product_title'])) ? $this->info['product_title'] : ''; ?>">
                <span class="help-block"></span>
            </div>
            <!-- END TITLE -->
            <!-- PERMALINK -->
            <div class="inside">
                <!-- MODAL SLUG POST -->
                <?php if(isset($this->info)): ?>
                <div id="edit-slug-box">
                    <strong>Permalink:</strong>
                        <span id="sample-permalink" tabindex="-1"><?php echo URL::get_site_url(); ?>/san-pham/<span id="slug-category"><?php echo $this->info['category'][0]['slug']; ?></span>/<a href="#"
                                                                                                            id="permalink"
                                                                                                            data-type="text"
                                                                                                            data-pk="1"
                                                                                                            data-original-title="Permalink"><?php echo $this->info['product_name']; ?></a>.html</span>
                        <span id="view-post-btn"><a href="<?php echo URL::get_site_url(); ?>/p/<?php echo $this->info['category'][0]['slug']; ?>/<?php echo $this->info['product_name']; ?>.html"
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
                <script type="text/javascript" src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/tinymce/tinymce.min.js"></script>
                <script type="text/javascript" src="<?php echo URL::get_site_url(); ?>/public/dashboard/assets/scripts/tinymce-advanted.js"></script>

                <textarea name="content" class="post-content" style="width:100%; height: 15%; overflow-y: scroll;"><?php if(isset($this->info)) { echo $this->info['product_content']; } ?></textarea>
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
    <div class="product-more-details">
        <div class="portlet gren">
            <div class="portlet-title">
                <div class="caption"><i class="icon-reorder"></i>Chi tiết hàng hóa</div>
            </div>
            <div class="portlet-body">
                <div class="tabbable tabbable-custom boxless">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_0" data-toggle="tab">Thông tin cơ bản</a></li>
                        <li><a href="#tab_1" data-toggle="tab">Hình ảnh</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_0">
                            <form class="form-horizontal" role="form">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label  class="col-md-3 control-label">SKU</label>
                                        <div class="col-md-9">
                                            <input type="text" id="product_sku" class="form-control" value="<?=(isset($this->info['product_sku'])) ? $this->info['product_sku'] : ''; ?>" <?php if ( isset( $this->info ) && ( $this->info['product_status'] === 'on-process' || $this->info['product_status'] === 'timeout' ) ) echo 'disabled'; ?>>
                                        </div>
                                    </div>
                                    <div id="txt_price_wrap" class="form-group">
                                        <label  class="col-md-3 control-label">Giá khởi điểm <em>(nghìn đồng)</em></label>
                                        <div class="col-md-9">
                                            <!-- <input type="text" id="product_show_price" class="form-control"> -->
                                            <input type="text" id="product_price" class="form-control" value="<?=(isset($this->info['product_price'])) ? $this->info['product_price'] : ''; ?>" <?php if ( isset( $this->info ) && ( $this->info['product_status'] === 'on-process' || $this->info['product_status'] === 'timeout' ) ) echo 'disabled'; ?>/>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-md-3 control-label">Bước giá <em>(nghìn đồng)</em></label>
                                        <div class="col-md-9">
                                            <input type="text" id="product_price_step" class="form-control" value="<?=(isset($this->info['product_price_step'])) ? $this->info['product_price_step'] : ''; ?>" disabled>
                                        </div>
                                    </div>
                                    <div id="timeout" class="form-group">
                                        <label  class="col-md-3 control-label">Thời gian đấu giá</label>
                                        <div class="col-md-9">
                                            <div class="col-md-3">
                                                <input id="timeout-day" class="form-control input-small" placeholder="" type="text" value="<?=(isset($this->info['product_timeout'])) ? $this->info['product_timeout'][0] : '0'; ?>" <?php if ( isset( $this->info ) && ( $this->info['product_status'] === 'on-process' || $this->info['product_status'] === 'timeout' ) ) echo 'disabled'; ?>> ngày
                                            </div>
                                            <div class="col-md-3">
                                                <input id="timeout-hour" class="form-control input-small" placeholder="" type="text" value="<?=(isset($this->info['product_timeout'])) ? $this->info['product_timeout'][1] : '0'; ?>" <?php if ( isset( $this->info ) && ( $this->info['product_status'] === 'on-process' || $this->info['product_status'] === 'timeout' ) ) echo 'disabled'; ?>> giờ
                                            </div>
                                            <div class="col-md-3">
                                                <input id="timeout-minute" class="form-control input-small" placeholder="" type="text" value="<?=(isset($this->info['product_timeout'])) ? $this->info['product_timeout'][2] : '0'; ?>" <?php if ( isset( $this->info ) && ( $this->info['product_status'] === 'on-process' || $this->info['product_status'] === 'timeout' ) ) echo 'disabled'; ?>> phút
                                            </div>
                                            <div class="col-md-9">
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab_1">
                            <div class="alert alert-success alert-dismissable display-hide">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>WOW!</strong> Well done and everything looks OK. <a href="" class="alert-link">Please check this one as well</a>
                            </div>
                            <div class="row-1">
                                <div class="col-md-12">
                                    <h4>Upload ảnh cho sản phẩm</h4>
                                </div>
                                <hr />
                            </div>
                            <div class="row-2">
                                <div class="row">
                                    <div id="gallery-output">
                                        <?php
                                        if ( isset( $this->info ) && $this->info['product_gallery'] != false ) {

                                            foreach ( $this->info['product_gallery'] as $k => $v ) {

                                                echo '<div class="row group-'. $k .'" id="gallery-item">';
                                                echo '<div class="col-md-2">';
                                                echo '<img class="img" src="' . $generic->getFileNameWithImageSize($this->info['product_gallery'][$k], 100, 100) . '">';
                                                echo '</div>';
                                                echo '<div class="form-group col-md-6" id="input">';
                                                echo '<input disabled="disabled" value="' . $this->info['product_gallery'][$k] . '" class="form-control input-xlarge" id="item-'. $k .'">';
                                                echo '<button id="delete-gallery-item" class="btn btn-xs red" onclick="removeGalleryItem('. $k .')"><i class="icon-remove"></i> Xóa</button>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                        } else
                                            echo '<span id="gallery-status" class="help-block">Chưa có album nào được tạo</span>';
                                        ?>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <form id="uploadForm" action="#" method="post">
                                        <input id="upload-file" name="file" type="file" class="col-md-9" />
                                        <button type="submit" class="btn blue"><i class="icon-upload"></i> Tải lên <span class="loading"></span></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                        echo 'Đăng hàng hóa';
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
            <script src='<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/countdown.js' type='text/javascript'></script>
            <div id="post-status">
                <div id="misc-publishing-actions">

                    <div class="misc-pub-section misc-pub-post-status"><label class="icon-bell">Status:</label>
                        <strong id="post-status-display">
                            <?php
                            if( isset( $this->info ) ) {
                                if( $this->info['product_status'] == 'on-process' ) {

                                    echo '<span id="status-text">Đang đấu giá</span>';
                                    echo '<br />';
                                    echo '<span id="time_count_down_'. $this->productId .'" style="color: blue;"></span>';
                                    ?>
                                    <script type="text/javascript">
                                        var countdown = new Countdown({
                                            selector: '#time_count_down_<?php echo $this->productId; ?>',
                                            msgAfter: "Đã hết hạn",
                                            msgPattern: "{days} ngày, {hours} giờ {minutes} phút {seconds}",
                                            dateStart: new Date(),
                                            dateEnd: new Date('<?php echo $this->info['product_end_date']; ?>'),
                                            onEnd: function() {
                                                $('#status-text').text('Đã hết hạn');
                                                $('#product_sku').prop('disabled', true);
                                                $('#product_price').prop('disabled', true);
                                                $('#timeout-day').prop('disabled', true);
                                                $('#timeout-hour').prop('disabled', true);
                                                $('#timeout-minute').prop('disabled', true);
                                                $('#Update').addClass('disabled');
                                            }
                                        });
                                    </script>
                                    <?php
                                } else if( $this->info['product_status'] == 'pending' ) {

                                    echo 'Đợi duyệt ';
                                    if ( $generic->getPermission( UserInfo::getUserId(), 'can_manager_all_products' ) ) {

                                        echo '<a href="javascript:;" id="active-pending-product" data-action="'. $this->productId.'" style="color:red;">Kích hoạt</a>';
                                    }
                                } else if($this->info['product_status'] == 'draft') {

                                    echo 'Bản nháp';
                                } else if ($this->info['product_status'] == 'timeout') {

                                    echo 'Đã hết hạn';
                                } else
                                    echo 'Đã bị xóa';
                            }
                            ?>
                        </strong>
                    </div>
                    <!-- .misc-pub-section -->

                    <div class="misc-pub-section curtime misc-pub-curtime">
                        <span id="timestamp">
                        Cập nhật: <b><?php if(isset($this->info)) { echo date_format(date_create($this->info['product_modified']), 'd M Y H:i'); } ?></b></span>
                        <br/>
                        <?php if ( isset( $this->info ) && $this->info['product_status'] !== 'trash' && $this->info['product_status'] !== 'on-process' ): ?>
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
                <?php if ( isset( $this->info ) && $this->info['product_status'] !== 'on-process' && $this->info['product_status'] !== 'timeout' && $this->info['product_status'] !== 'trash' ) : ?>
                <a href="javascript:;" id="<?php if ( isset( $this->info['product_status'] ) ): echo createSubmitTypeBtn( $this->info['product_status'] )['id']; else: echo 'Publish'; endif; ?>" class="btn green">
                    <?php if ( isset( $this->info['product_status'] ) ): echo createSubmitTypeBtn( $this->info['product_status'])['name']; else: echo 'Đăng bài'; endif; ?>
                </a>
                <?php elseif ( !isset( $this->info ) ): ?>
                <a href="javascript:;" id="Publish" class="btn green">
                    Đăng bài
                </a>
                <?php endif; ?>
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
                        $func = new productFunction();
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
                <i class="icon-reorder"></i> Ảnh đại diện
            </div>
            <div class="tools">
                <a href="" class="collapse"></a>
            </div>
        </div>
        <div class="portlet-body form">
            <div id="feature-view">
                <?php
                if(!empty($this->info['product_feature_img']))
                {
                    echo "<img src='".$this->info['product_feature_img']."' width='245' />";
                }
                ?>
            </div>
            <input type="hidden" id="feature-url" name="feature-url" value="<?php if(!empty($this->info['product_feature_img'])) echo $this->info['product_feature_img']; ?>" />
            <div id="feature-action">
                <a id="set-feature-image-btn" class="<?php if(empty($this->info['product_feature_img'])): echo ''; else: echo 'display-hide'; endif; ?>" title="Nhấn vào để chọn ảnh đại diện cho bài viết" href="#responsive" data-toggle="modal">Chọn ảnh đại diện</a>
                <a id="remove-feature-image-btn" class="<?php if(empty($this->info['product_feature_img'])): echo 'display-hide'; else: echo ''; endif; ?>" title="Nhấn vào để xóa ảnh đại diện cho bài viết" href="javascript:;">Xóa ảnh đại diện</a>
            </div>
        </div>
    </div>
</div>
<div id="PublishForm" class="display-hide"></div>
<div id="UpdateForm" class="display-hide"></div>
<input type="hidden" id="product_id" value="<?php if( isset( $this->productId ) ) echo $this->productId; ?>" />
</div>

</div>
<!--  END PAGE  -->