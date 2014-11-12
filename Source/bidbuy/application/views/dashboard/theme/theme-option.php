<?php
require_once(ROOT . DS . 'application/views/dashboard/sidebar.php');
require_once('function.php');
?>
<!-- BEGIN PAGE -->
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
                Quản lý người dùng
                <small>Cài đặt</small>
            </h3>
            <ul class="page-breadcrumb breadcrumb">

                <li>
                    <i class="icon-home"></i>
                    <a href="<?php echo URL::get_site_url(); ?>/admin">Dashboard</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <a href="#">Chỉnh sửa giao diện</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li><a href="#tab_2-2">Tùy chỉnh giao diện</a></li>
            </ul>
            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row user-setting">
        <div class="col-md-3">
            <ul class="ver-inline-menu tabbable margin-bottom-10">
                <li class="active">
                    <a data-toggle="tab" href="#tab_1-1">
                        <i class=" icon-play"></i>
                        Main Slider
                    </a>
                    <span class="after"></span>
                </li>
                <li>
                    <a data-toggle="tab" href="#tab_2-2">
                        <i class="icon-globe"></i>
                        Social Network
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#tab_3-3">
                        <i class="icon-th-large"></i>
                        Footer
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-9">
            <div class="tab-content">
                <!-- ALERT -->
                <?php
                if ( isset( $_SESSION['ssbidbuy']['updated'] ) ) {

                    $alert = $_SESSION['ssbidbuy']['updated'];
                    if ( $alert ) {
                        ?>
                        <div class="alert alert-success">
                            <strong>Cập nhật thành công!</strong>
                        </div>
                    <?php
                    } else {

                        ?>
                        <div class="alert alert-danger">
                            <strong>Đã xảy ra lỗi!</strong> Vui lòng làm mới trang và thử lại!
                        </div>
                    <?php

                    }
                    unset( $_SESSION['ssbidbuy']['updated'] );
                }
                ?>
                <!--\\ ALERT -->
                <div id="tab_1-1" class="tab-pane active">
                    <!-- BEGIN SLIDER 1 -->
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption"><i class="icon-reorder"></i>Slider 1</div>
                            <div class="actions">
                                <a href="javascript:;" id="slider_form_submit_1" class="btn default btn-sm"><i class="icon-save"></i> Lưu</a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <!-- BEGIN FORM SLIDE 1 -->
                            <form id="slider_1_form" class="form-horizontal" role="form" action="<?php echo URL::get_site_url(); ?>/admin/theme/updateSlideSettings" method="post" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Tiêu đề</label>
                                        <div class="col-md-9">
                                            <input class="form-control" name="slider_title" placeholder="Nhập tiêu đề cho slide" type="text" value="<?php if ( isset( $this->options['main_slide'] ) ) { echo $this->options['main_slide']['slider_title_1']; } ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Mô tả</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="slider_description" rows="3"><?php if ( isset( $this->options['main_slide'] ) ) { echo $this->options['main_slide']['slider_description_1']; } ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile" class="col-md-3 control-label">Ảnh</label>
                                    <div class="col-md-9">
                                        <div class="img_review">
                                            <?php if ( isset( $this->options['main_slide'] ) && $this->options['main_slide']['slider_image_1'] != '' ) : ?>
                                            <img src="<?php echo $this->options['main_slide']['slider_image_1']; ?>" width="50%" height="50%">
                                            <?php endif; ?>
                                        </div>
                                        <input name="file" type="file">
                                        <p class="help-block">Ảnh hiện thị tốt nhất với size 960x282</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Hiển thị</label>
                                    <div class="col-md-9">
                                        <div class="radio-list">
                                            <label>
                                                <input type="radio" name="slider_enabled" value="1" <?php if ( isset( $this->options['main_slide'] ) && $this->options['main_slide']['slider_enabled_1'] == 1 ) { echo 'checked'; } ?>> Có
                                            </label>
                                            <label>
                                                <input type="radio" name="slider_enabled" value="0" <?php if ( isset( $this->options['main_slide'] ) && $this->options['main_slide']['slider_enabled_1'] == 0 ) { echo 'checked'; } ?>> Không
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="slider" value="1" />
                            </form>
                            <!-- END FORM SLIDE 1 -->
                        </div>
                    </div>
                    <!-- END SLIDER 1 -->

                    <!-- BEGIN SLIDER 2 -->
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption"><i class="icon-reorder"></i>Slider 2</div>
                            <div class="actions">
                                <a href="javascript:;" id="slider_form_submit_2" class="btn default btn-sm"><i class="icon-save"></i> Lưu</a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <!-- BEGIN FORM SLIDE 2 -->
                            <form id="slider_2_form" class="form-horizontal" role="form" action="<?php echo URL::get_site_url(); ?>/admin/theme/updateSlideSettings" method="post" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Tiêu đề</label>
                                        <div class="col-md-9">
                                            <input class="form-control" name="slider_title" placeholder="Nhập tiêu đề cho slide" type="text" value="<?php if ( isset( $this->options['main_slide'] ) ) { echo $this->options['main_slide']['slider_title_2']; } ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Mô tả</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="slider_description" rows="3"><?php if ( isset( $this->options['main_slide'] ) ) { echo $this->options['main_slide']['slider_description_2']; } ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile" class="col-md-3 control-label">Ảnh</label>
                                    <div class="col-md-9">
                                        <div class="img_review">
                                            <?php if ( isset( $this->options['main_slide'] ) && $this->options['main_slide']['slider_image_2'] != '' ) : ?>
                                                <img src="<?php echo $this->options['main_slide']['slider_image_2']; ?>" width="50%" height="50%">
                                            <?php endif; ?>
                                        </div>
                                        <input name="file" type="file">
                                        <p class="help-block">Ảnh hiện thị tốt nhất với size 960x282</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Hiển thị</label>
                                    <div class="col-md-9">
                                        <div class="radio-list">
                                            <label>
                                                <input type="radio" name="slider_enabled" value="1" <?php if ( isset( $this->options['main_slide'] ) && $this->options['main_slide']['slider_enabled_2'] == 1 ) { echo 'checked'; } ?>> Có
                                            </label>
                                            <label>
                                                <input type="radio" name="slider_enabled" value="0" <?php if ( isset( $this->options['main_slide'] ) && $this->options['main_slide']['slider_enabled_2'] == 0 ) { echo 'checked'; } ?>> Không
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="slider" value="2" />
                            </form>
                            <!-- END FORM SLIDE 2 -->
                        </div>
                    </div>
                    <!-- END SLIDER 2 -->

                    <!-- BEGIN SLIDER 3 -->
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption"><i class="icon-reorder"></i>Slider 3</div>
                            <div class="actions">
                                <a href="javascript:;" id="slider_form_submit_3" class="btn default btn-sm"><i class="icon-save"></i> Lưu</a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <!-- BEGIN FORM SLIDE 3 -->
                            <form id="slider_3_form" class="form-horizontal" role="form" action="<?php echo URL::get_site_url(); ?>/admin/theme/updateSlideSettings" method="post" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Tiêu đề</label>
                                        <div class="col-md-9">
                                            <input class="form-control" name="slider_title" placeholder="Nhập tiêu đề cho slide" type="text" value="<?php if ( isset( $this->options['main_slide'] ) ) { echo $this->options['main_slide']['slider_title_3']; } ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Mô tả</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="slider_description" rows="3"><?php if ( isset( $this->options['main_slide'] ) ) { echo $this->options['main_slide']['slider_description_3']; } ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="file" class="col-md-3 control-label">Ảnh</label>
                                    <div class="col-md-9">
                                        <div class="img_review">
                                            <?php if ( isset( $this->options['main_slide'] ) && $this->options['main_slide']['slider_image_3'] != '' ) : ?>
                                                <img src="<?php echo $this->options['main_slide']['slider_image_3']; ?>" width="50%" height="50%">
                                            <?php endif; ?>
                                        </div>
                                        <input name="file" type="file">
                                        <p class="help-block">Ảnh hiện thị tốt nhất với size 960x282</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Hiển thị</label>
                                    <div class="col-md-9">
                                        <div class="radio-list">
                                            <label>
                                                <input type="radio" name="slider_enabled" value="1" <?php if ( isset( $this->options['main_slide'] ) && $this->options['main_slide']['slider_enabled_3'] == 1 ) { echo 'checked'; } ?>> Có
                                            </label>
                                            <label>
                                                <input type="radio" name="slider_enabled" value="0" <?php if ( isset( $this->options['main_slide'] ) && $this->options['main_slide']['slider_enabled_3'] == 0 ) { echo 'checked'; } ?>> Không
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="slider" value="3" />
                            </form>
                            <!-- END FORM SLIDE 3 -->
                        </div>
                    </div>
                    <!-- END SLIDER 3 -->

                    <!-- BEGIN SLIDER 4 -->
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption"><i class="icon-reorder"></i>Slider 4</div>
                            <div class="actions">
                                <a href="javascript:;" id="slider_form_submit_4" class="btn default btn-sm"><i class="icon-save"></i> Lưu</a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <!-- BEGIN FORM SLIDE 4 -->
                            <form id="slider_4_form" class="form-horizontal" role="form" action="<?php echo URL::get_site_url(); ?>/admin/theme/updateSlideSettings" method="post" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Tiêu đề</label>
                                        <div class="col-md-9">
                                            <input class="form-control" name="slider_title" placeholder="Nhập tiêu đề cho slide" type="text" value="<?php if ( isset( $this->options['main_slide'] ) ) { echo $this->options['main_slide']['slider_title_4']; } ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Mô tả</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="slider_description" rows="3"><?php if ( isset( $this->options['main_slide'] ) ) { echo $this->options['main_slide']['slider_description_4']; } ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile" class="col-md-3 control-label">Ảnh</label>
                                    <div class="col-md-9">
                                        <div class="img_review">
                                            <?php if ( isset( $this->options['main_slide'] ) && $this->options['main_slide']['slider_image_4'] != '' ) : ?>
                                                <img src="<?php echo $this->options['main_slide']['slider_image_4']; ?>" width="50%" height="50%">
                                            <?php endif; ?>
                                        </div>
                                        <input name="file" type="file">
                                        <p class="help-block">Ảnh hiện thị tốt nhất với size 960x282</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Hiển thị</label>
                                    <div class="col-md-9">
                                        <div class="radio-list">
                                            <label>
                                                <input type="radio" name="slider_enabled" value="1" <?php if ( isset( $this->options['main_slide'] ) && $this->options['main_slide']['slider_enabled_4'] == 1 ) { echo 'checked'; } ?>> Có
                                            </label>
                                            <label>
                                                <input type="radio" name="slider_enabled" value="0" <?php if ( isset( $this->options['main_slide'] ) && $this->options['main_slide']['slider_enabled_4'] == 0 ) { echo 'checked'; } ?>> Không
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="slider" value="4" />
                            </form>
                            <!-- END FORM SLIDE 4 -->
                        </div>
                    </div>
                    <!-- END SLIDER 4 -->

                    <!-- BEGIN SLIDER 5 -->
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption"><i class="icon-reorder"></i>Slider 5</div>
                            <div class="actions">
                                <a href="javascript:;" id="slider_form_submit_5" class="btn default btn-sm"><i class="icon-save"></i> Lưu</a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <!-- BEGIN FORM SLIDE 5 -->
                            <form id="slider_5_form" class="form-horizontal" role="form" action="<?php echo URL::get_site_url(); ?>/admin/theme/updateSlideSettings" method="post" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Tiêu đề</label>
                                        <div class="col-md-9">
                                            <input class="form-control" name="slider_title" placeholder="Nhập tiêu đề cho slide" type="text" value="<?php if ( isset( $this->options['main_slide'] ) ) { echo $this->options['main_slide']['slider_title_5']; } ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Mô tả</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="slider_description" rows="3"><?php if ( isset( $this->options['main_slide'] ) ) { echo $this->options['main_slide']['slider_description_5']; } ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile" class="col-md-3 control-label">Ảnh</label>
                                    <div class="col-md-9">
                                        <div class="img_review">
                                            <?php if ( isset( $this->options['main_slide'] ) && $this->options['main_slide']['slider_image_5'] != '' ) : ?>
                                                <img src="<?php echo $this->options['main_slide']['slider_image_5']; ?>" width="50%" height="50%">
                                            <?php endif; ?>
                                        </div>
                                        <input name="file" type="file">
                                        <p class="help-block">Ảnh hiện thị tốt nhất với size 960x282</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Hiển thị</label>
                                    <div class="col-md-9">
                                        <div class="radio-list">
                                            <label>
                                                <input type="radio" name="slider_enabled" value="1" <?php if ( isset( $this->options['main_slide'] ) && $this->options['main_slide']['slider_enabled_5'] == 1 ) { echo 'checked'; } ?>> Có
                                            </label>
                                            <label>
                                                <input type="radio" name="slider_enabled" value="0" <?php if ( isset( $this->options['main_slide'] ) && $this->options['main_slide']['slider_enabled_5'] == 0 ) { echo 'checked'; } ?>> Không
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="slider" value="5" />
                            </form>
                            <!-- END FORM SLIDE 5 -->
                        </div>
                    </div>
                    <!-- END SLIDER 5 -->

                    <!-- ACTION BUTTON -->
                    <hr />
                    <button id="save_slide_setting_change" type="button" class="btn green">Lưu thay đổi</button>
                    <!-- END ACTION BUTTON -->
                </div>
                <div id="tab_2-2" class="tab-pane">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet">
                                <div class="portlet-title">
                                    <div class="caption">Kết nối với bidbuy.vn</div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form class="form-horizontal" action="<?php echo URL::get_site_url(); ?>/admin/theme/updateFooterWidget" method="post" role="form">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label  class="col-md-3 control-label">Facebook link</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="icon-facebook-sign"></i></span>
                                                        <input type="text" name="facebook_link" class="form-control" value="<?php if ( isset( $this->social ) ) echo $this->social['facebook_link']; ?>" placeholder="Nhập liên kết facebook">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label  class="col-md-3 control-label">Youtube link</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="icon-youtube"></i></span>
                                                        <input type="text" name="youtube_link" class="form-control" value="<?php if ( isset( $this->social ) ) echo $this->social['youtube_link']; ?>" placeholder="Nhập liên kết youtube">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label  class="col-md-3 control-label">Google+ link</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="icon-google-plus"></i></span>
                                                        <input type="text" name="googleplus_link" class="form-control" value="<?php if ( isset( $this->social ) ) echo $this->social['googleplus_link']; ?>" placeholder="Nhập liên kết Google+">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label  class="col-md-3 control-label">Google Play</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="icon-android"></i></span>
                                                        <input type="text" name="googleplay_link" class="form-control" value="<?php if ( isset( $this->social ) ) echo $this->social['googleplay_link']; ?>" placeholder="Nhập liên kết Google Play">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label  class="col-md-3 control-label">Appstore</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="icon-apple"></i></span>
                                                        <input type="text" name="appstore_link" class="form-control" value="<?php if ( isset( $this->social ) ) echo $this->social['appstore_link']; ?>" placeholder="Nhập liên kết Appstore">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions fluid">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" class="btn green">Lưu thay đổi</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END SAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                </div>
                <div id="tab_3-3" class="tab-pane">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet">
                                <div class="portlet-title">
                                    <div class="caption">Tùy chỉnh widget Footer</div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form class="form-horizontal" action="<?php echo URL::get_site_url(); ?>/admin/theme/updateFooterWidget" method="post" role="form">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label  class="col-md-3 control-label">Footer Text</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="footer_text" class="form-control" value='<?php if ( isset( $this->footer ) ) echo $this->footer['footer_text']; ?>'>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Cột 3</label>
                                                <div class="col-md-9">
                                                    <textarea name="footer_column_3" class="form-control" rows="3"><?php if ( isset( $this->footer ) ) echo $this->footer['footer_column_3']; ?></textarea>
                                                    <span class="help-block">Hỗ trợ HTML</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Cột 4</label>
                                                <div class="col-md-9">
                                                    <textarea name="footer_column_4" class="form-control" rows="3"><?php if ( isset( $this->footer ) ) echo $this->footer['footer_column_4']; ?></textarea>
                                                    <span class="help-block">Hỗ trợ HTML</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions fluid">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" class="btn green">Lưu thay đổi</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END SAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--end col-md-9-->
</div>
<!-- END PAGE CONTENT-->
</div>
<!-- END PAGE -->