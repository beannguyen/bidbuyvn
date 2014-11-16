<?php require_once(ROOT . DS . 'application/views/dashboard/sidebar.php'); ?>
<?php require("function.php"); ?>
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
            Quản lý người dùng
            <small>Nhóm người dùng</small>
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="../dashboard">Dashboard</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>
                <a href="#">Quản lý nhóm người dùng</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>Chỉnh sửa nhóm người dùng</li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!--  END PAGE HEADER -->
<!--  BEGIN PAGE CONTENT -->
<div class="note note-success display-hide">
    <h4 class="block">Cập nhật thành công!</h4>

    <p>
        Thông tin nhóm người dùng này đã được cập nhật thành công.
    </p>
</div>
<div class="error-system alert alert-danger display-hide">
    <strong>Error!</strong> Đã phát sinh lỗi hệ thống. Vui lòng kiểm tra lại!
</div>
<div class="alert alert-danger display-hide">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Lỗi!</strong> Nhóm người dùng này đang được sử dụng. Hãy bỏ tick để lưu thay đổi!<br/>
    <strong>Hướng dẫn:</strong><em> Nếu bạn muốn xóa vĩnh viễn, hay chuyển tất cả người dùng trong nhóm này sang một
        nhóm khác.</em>
</div>
<?php if (isset($this->error) && $this->error == "level_not_found") : ?>
    <div class="note note-danger">
        <h4 class="block">Lỗi!</h4>

        <p>
            Level mà bạn chọn không tồn tại.
        </p>

        <p>
            <a class="btn red" href="<?php echo URL::get_site_url() . '/dashboard/user_group'; ?>">Quay lại</a>
        </p>
    </div>
<?php endif; ?>
<div class="alert alert-warning display-hide">
    <h4 class="block">Nhóm đã được xóa thành công</h4>

    <div id="timer"><em>Trang sẽ chuyển hướng sau 3s</em></div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption"><i class="icon-reorder"></i>Thông tin cơ bản</div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" id="basic-information" class="form-horizontal form-row-sepe">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Tên nhóm</label>

                            <div class="col-md-6">
                                <input id="level_name" name="level_name" class="form-control"
                                       value="<?php echo $this->info['level_name']; ?>" type="text">
                                <span class="level_name_loading"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Cấp độ</label>

                            <div class="col-md-6">
                                <div id="spinner-level">
                                    <div class="input-group input-small">
                                        <input type="text" id="level_level" name="level_level"
                                               class="spinner-input form-control"
                                               value="<?php echo $this->info['level_level']; ?>" maxlength="3" readonly>
                                            <span
                                                class="level_level_loading"></span>

                                        <div class="spinner-buttons input-group-btn btn-group-vertical">
                                            <button type="button"
                                                    class="btn spinner-up btn-xs blue" <?php echo ($this->isAdmin) ? 'disabled' : ''; ?>>
                                                <i class="icon-angle-up"></i>
                                            </button>
                                            <button type="button"
                                                    class="btn spinner-down btn-xs blue" <?php echo ($this->isAdmin) ? 'disabled' : ''; ?>>
                                                <i class="icon-angle-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3"></label>

                            <div class="col-md-9">
                                <div class="checkbox-list">
                                    <label>
                                        <input type="checkbox" id="disable"
                                               name="disable" <?php echo ($this->info['level_disabled'] == 1) ? 'checked' : ''; ?> <?php echo ($this->isAdmin) ? 'disabled' : ''; ?>>
                                        Cấm nhóm người dùng này truy cập trang web
                                    </label>
                                    <label>
                                        <input type="checkbox" id="delete"
                                               name="delete" <?php echo ($this->isAdmin) ? 'disabled' : ''; ?>> Xóa vĩnh
                                        viễn nhóm người dùng
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="level_id" name="level-id" value="<?php echo $this->info['id']; ?>"/>

                    <div class="modal-footer">
                        <span class="process_loading"></span>
                        <button type="submit" id="save-change" class="btn green" data-dismiss="modal">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END FORM-->
<div class="row">
<div class="col-md-12">
<div class="portlet box blue">
<div class="portlet-title">
    <div class="caption"><i class="icon-reorder"></i>Phân quyền</div>
    <div class="tools">
        <a href="javascript:;" class="collapse"></a>
    </div>
</div>
<div class="portlet-body form">
<!-- BEGIN FORM-->
<form id="user_permission" action="#" class="form-horizontal form-row-sepe">
<div class="form-actions top">
    <h4>Quyền xem website</h4>
</div>
<div class="form-body">
    <div class="form-group">
        <label class="control-label col-md-6">Có thể xem website</label>

        <div class="col-md-6">
            <div class="radio-list">
                <label class="radio-inline">
                    <input type="radio" name="can-view-wesite" id="can_view_wesite_yes"
                           value="1"
                           <?php echo ($generic->getOption('can_view_website', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Có
                </label>
                <label class="radio-inline">
                    <input type="radio" name="can-view-wesite" id="can_view_wesite_no"
                           value="0" <?php echo (!$generic->getOption('can_view_website', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>>
                    Không
                </label></div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-6">Có thể xem nội dung bài viết</label>

        <div class="col-md-6">
            <div class="radio-list">
                <label class="radio-inline">
                    <input type="radio" name="can-view-thread-content"
                           id="can_view_thread_content_yes" value="1"
                        <?php echo ($generic->getOption('can_view_thread_content', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Có
                </label>
                <label class="radio-inline">
                    <input type="radio" name="can-view-thread-content"
                           id="can_view_thread_content_no" value="0"
                        <?php echo (!$generic->getOption('can_view_thread_content', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Không
                </label></div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-6">Có thể xem thông báo xóa bài viết</label>

        <div class="col-md-6">
            <div class="radio-list">
                <label class="radio-inline">
                    <input type="radio" name="can-view-deletion-notice"
                           id="can_view_deletion_notice_yes" value="1"
                        <?php echo ($generic->getOption('can_view_deletion_notice', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Có
                </label>
                <label class="radio-inline">
                    <input type="radio" name="can-view-deletion-notice"
                           id="can_view_deletion_notice_no" value="0"
                        <?php echo (!$generic->getOption('can_view_deletion_notice', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Không
                </label></div>
        </div>
    </div>
</div>
<div class="form-actions top">
    <h4>Quyền viết bài</h4>
</div>
<div class="form-body">
    <div class="form-group">
        <label class="control-label col-md-6">Có thể viết bài mới</label>

        <div class="col-md-6">
            <div class="radio-list">
                <label class="radio-inline">
                    <input type="radio" name="can-post-new-thread" id="can_post_new_thread_yes"
                           value="1"
                        <?php echo ($generic->getOption('can_post_new_thread', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Có
                </label>
                <label class="radio-inline">
                    <input type="radio" name="can-post-new-thread" id="can_post_new_thread_no"
                           value="0"
                        <?php echo (!$generic->getOption('can_post_new_thread', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Không
                </label></div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-6">Có thể chỉnh sửa bài viết của chính họ</label>

        <div class="col-md-6">
            <div class="radio-list">
                <label class="radio-inline">
                    <input type="radio" name="can-edit-own-thread" id="can_edit_own_thread_yes"
                           value="1" <?php echo ($generic->getOption('can_edit_own_thread', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Có
                </label>
                <label class="radio-inline">
                    <input type="radio" name="can-edit-own-thread" id="can_edit_own_thread_no"
                           value="0"
                        <?php echo (!$generic->getOption('can_edit_own_thread', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Không
                </label></div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-6">Có thể xóa bài viết của chính họ</label>

        <div class="col-md-6">
            <div class="radio-list">
                <label class="radio-inline">
                    <input type="radio" name="can-delete-own-thread" id="can_delete_own_thread_yes"
                           value="1"
                        <?php echo ($generic->getOption('can_delete_own_thread', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Có
                </label>
                <label class="radio-inline">
                    <input type="radio" name="can-delete-own-thread" id="can_delete_own_thread_no"
                           value="0"
                        <?php echo (!$generic->getOption('can_delete_own_thread', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Không
                </label></div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-6">Có thể mở hoặc đóng bài viết của họ</label>

        <div class="col-md-6">
            <div class="radio-list">
                <label class="radio-inline">
                    <input type="radio" name="can-open-close-own-thread"
                           id="can_open_close_own_thread_yes" value="1"
                        <?php echo ($generic->getOption('can_open_close_own_thread', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Có
                </label>
                <label class="radio-inline">
                    <input type="radio" name="can-open-close-own-thread"
                           id="can_open_close_own_thread_no" value="0"
                        <?php echo (!$generic->getOption('can_open_close_own_thread', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Không
                </label></div>
        </div>
    </div>
</div>
<div class="form-actions top">
    <h4>Quyền quản trị website</h4>
</div>
<div class="form-body">
    <div class="form-group">
        <label class="control-label col-md-6">Có thể điểu chỉnh toàn website</label>

        <div class="col-md-6">
            <div class="radio-list">
                <label class="radio-inline">
                    <input type="radio" name="can-moderate-all-website"
                           id="can_moderate_all_website_yes"
                           value="1" <?php echo ($generic->getOption('can_moderate_all_website', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Có
                </label>
                <label class="radio-inline">
                    <input type="radio" name="can-moderate-all-website"
                           id="can_moderate_all_website_no"
                           value="0"
                        <?php echo (!$generic->getOption('can_moderate_all_website', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Không
                </label></div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-6">Có thể truy cập trang quản trị</label>

        <div class="col-md-6">
            <div class="radio-list">
                <label class="radio-inline">
                    <input type="radio" name="can-access-admin-dashboard"
                           id="can_access_admin_dashboard_yes"
                           value="1" <?php echo ($generic->getOption('can_access_admin_dashboard', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Có
                </label>
                <label class="radio-inline">
                    <input type="radio" name="can-access-admin-dashboard"
                           id="can_access_admin_dashboard_no"
                           value="0" <?php echo (!$generic->getOption('can_access_admin_dashboard', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Không
                </label></div>
        </div>
    </div>
</div>
<div class="form-actions top">
    <h4>Phân quyền chung</h4>
</div>
<div class="form-body">
    <div class="form-group">
        <label class="control-label col-md-6">Có thể xem thông tin thành viên</label>

        <div class="col-md-6">
            <div class="radio-list">
                <label class="radio-inline">
                    <input type="radio" name="can-view-member-info"
                           id="can_view_member_info_yes"
                           value="1" <?php echo ($generic->getOption('can_view_member_info', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Có
                </label>
                <label class="radio-inline">
                    <input type="radio" name="can-view-member-info"
                           id="can_view_member_info_no"
                           value="0" <?php echo (!$generic->getOption('can_view_member_info', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Không
                </label></div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-6">Có thể chỉnh sửa thông tin cá nhân của họ</label>

        <div class="col-md-6">
            <div class="radio-list">
                <label class="radio-inline">
                    <input type="radio" name="can-edit-own-profile"
                           id="can_edit_own_profile_yes"
                           value="1" <?php echo ($generic->getOption('can_edit_own_profile', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Có
                </label>
                <label class="radio-inline">
                    <input type="radio" name="can-edit-own-profile"
                           id="can_edit_own_profile_no"
                           value="0" <?php echo (!$generic->getOption('can_edit_own_profile', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Không
                </label></div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-6">Có thể gửi tin nhắn cho thành viên khác</label>

        <div class="col-md-6">
            <div class="radio-list">
                <label class="radio-inline">
                    <input type="radio" name="can-send-private-message"
                           id="can_send_private_message_yes" value="1" <?php echo ($generic->getOption('can_send_private_message', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Có
                </label>
                <label class="radio-inline">
                    <input type="radio" name="can-send-private-message"
                           id="can_send_private_message_no" value="0"
                        <?php echo (!$generic->getOption('can_send_private_message', false, false, true, $this->info['id']) == 1) ? 'checked' : '' ?>> Không
                </label></div>
        </div>
    </div>
</div>
<input type="hidden" id="level_id" name="level-id" value="<?php echo $this->info['id']; ?>"/>
<div class="modal-footer">
    <span class="permission_process_loading"></span>
    <button type="submit" id="save-change-permission" class="btn green" data-dismiss="modal">Lưu thay đổi</button>
</div>
</form>
</div>
</div>
</div>
</div>
<!-- END FORM-->
</div>