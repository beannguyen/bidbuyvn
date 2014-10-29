<?php require_once(ROOT . DS . 'application/views/dashboard/sidebar.php'); ?>
<?php
    $generic = new Generic();
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
                <a href="index.html">Dashboard</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>
                <a href="#">Quản lý người dùng</a>
                <i class="icon-angle-right"></i>
            </li>
            <li><a href="#">Cài đặt</a></li>
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
                    <i class="icon-cog"></i>
                    Tổng quan
                </a>
                <span class="after"></span>
            </li>
            <li><a data-toggle="tab" href="#tab_3-3"><i class="icon-envelope"></i> Email mẫu</a></li>
            <!-- <li><a data-toggle="tab" href="#tab_4-4"><i class="icon-eye-open"></i> Tích hợp</a></li> -->
        </ul>
    </div>
    <div class="col-md-9">
        <div class="tab-content">
            <div id="tab_1-1" class="tab-pane active">
                <form role="form" action="<?php echo URL::get_site_url(); ?>/admin/user/updateGeneralOptions" id="general-setting" method="post">
                    <div class="alert alert-success display-hide">
                        <button class="close" data-dismiss="alert"></button>
                        Sửa đổi của bạn đã được lưu thành công!
                    </div>
                    <legend><strong>Cài đặt tổng quan</strong></legend>
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess">Admin email</label>
                        <i class="icon-info-sign tooltips" data-original-title="Email này dùng để gửi tất cả các thư" data-container="body"></i>
                        <div class="input-icon right">
                            <input class="form-control" type="email" id="admin_email" name="admin_email" value="<?php echo $generic->getOption('admin_email'); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess">Thời gian của một phiên đăng nhập</label>
                        <i class="icon-info-sign tooltips" data-original-title="Số phút mặc định mà 1 user có thể đăng nhập vào hệ thống, nhập 0 để đưa user thoát ra khỏi hệ thống khi họ tắt trình duyệt" data-container="body"></i>
                        <div class="input-icon right">
                            <input class="form-control" type="text" id="default_session" name="default_session" value="<?php echo $generic->getOption('default_session'); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Nhóm người dùng mặc định</label>
                        <i class="icon-info-sign tooltips" data-original-title="Nhóm mặc định cho người dùng khi họ đăng ký mới" data-container="body"></i>
                        <div class="input-icon right">
                            <?php UserInfo::returnLevels(); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="">Điểu chỉnh</label>
                        <div class="checkbox-list">
                            <label>
                                <input type="checkbox" id="email-as-username-enable" name="email-as-username-enable" <?php echo $generic->getOption('email-as-username-enable', true); ?>> Sử dụng email thay cho tên đăng nhập khi đăng nhập hệ thống
                            </label>
                            <label>
                                <input type="checkbox" id="disable-registrations-enable" name="disable-registrations-enable" <?php echo $generic->getOption('disable-registrations-enable', true); ?>> Không cho phép người dùng đăng ký mới
                            </label>
                            <label>
                                <input type="checkbox" id="disable-logins-enable" name="disable-logins-enable" <?php echo $generic->getOption('disable-logins-enable', true); ?>> Không cho phép người dùng đăng nhập
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="">Người dùng mới</label>
                        <div class="checkbox-list">
                            <label>
                                <input type="checkbox" id="user-activation-enable" name="user-activation-enable" <?php echo $generic->getOption('user-activation-enable', true); ?>> Yêu cầu xác nhận email cho người dùng đăng ký mới
                            </label>
                            <label>
                                <input type="checkbox" id="email-welcome-disable" name="email-welcome-disable" <?php echo $generic->getOption('email-welcome-disable', true); ?>> Không gửi email chào mừng khi người dùng đăng ký mới
                            </label>
                            <label>
                                <input type="checkbox" id="notify-new-user-enable" name="notify-new-user-enable" <?php echo $notify = $generic->getOption('notify-new-user-enable', true); ?>> Thông báo cho một nhóm người dùng việc đăng ký mới
                                <div id="notify-group-select" class="input-icon right <?php $notify = $generic->getOption('notify-new-user-enable'); echo ($notify != 1) ? 'display-hide' : ''; ?>">
                                    <?php UserInfo::returnLevels('notify-new-users'); ?>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess">Hạn chế tên miền email</label>
                        <i class="icon-info-sign tooltips" data-original-title="Hạn chế những tên miền email" data-container="body"></i>
                        <div class="input-icon right">
                            <input type="hidden" id="restrict-signups-by-email" name="restrict-signups-by-email" placeholder="VD: hotmail.com, gmail.com" class="form-control select2_restrict_email" value="<?php echo UserInfo::get_domains(); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="">Mã hóa mật khẩu</label>
                        <div class="checkbox-list">
                            <label>
                                <input type="checkbox" id="pw-encrypt-force-enable" name="pw-encrypt-force-enable" <?php echo $generic->getOption('pw-encrypt-force-enable', true); ?>> Yêu cầu người dùng thay đổi mật khẩu nếu không sử dụng đúng cách mã hóa hiện tại
                            </label>
                        </div>
                        <div class="radio-list">
                            <?php $pw_encryption = $generic->getOption('pw-encryption'); ?>
                            <?php $e = array('MD5', 'SHA256'); ?>
                            <?php foreach ($e as $value) : ?>
                                <label>
                                    <input type="radio" name="pw-encryption" id="<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($pw_encryption == $value) echo 'checked'; ?> > <?php echo $value; ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <input type="hidden" name="general-options-form" value="1">
                    <div class="margiv-top-10">
                        <button type="submit" class="btn green">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
            <div id="tab_3-3" class="tab-pane">
                <form role="form" action="<?php echo URL::get_site_url(); ?>/admin/user/updateGeneralOptions/tab_3-3" id="email-form-setting" method="post">
                    <legend><strong>Welcome email</strong></legend>
                    <div class="form-group">
                        <label  class="control-label">Welcome</label>
                        <i class="icon-info-sign tooltips" data-original-title="Người dùng sẽ nhận được email này khi hoàn tất đăng ký" data-container="body"></i>
                        <span class="help-block">Tiêu đề</span>
                        <input type="text" class="form-control" id="email-welcome-subj" name="email-welcome-subj" value="<?php echo $generic->getOption('email-welcome-subj'); ?>">
                        <span class="help-block">Nội dung</span>
                        <div class="input-icon right">
                            <textarea class="form-control" id="email-welcome-msg" name="email-welcome-msg" rows="10"><?php echo $generic->getOption('email-welcome-msg'); ?></textarea>
                        </div>
                        <div class="help-inline">
                            <p><strong>Shortcodes:</strong></p>
                            <p>Site address: <code>{{site_address}}</code></p>
                            <p>Full name: <code>{{full_name}}</code></p>
                            <p>Username: <code>{{username}}</code></p>
                            <p>Email: <code>{{email}}</code></p>
                            <p>Activation link: <code>{{activate}}</code></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="control-label">Notification</label>
                        <i class="icon-info-sign tooltips" data-original-title="Nhóm người dùng sẽ nhận dược thông báo khi có đăng ký mới nếu đã bất chế độ này trong Cài đặt tổng quan" data-container="body"></i>
                        <span class="help-block">Tiêu đề</span>
                        <input type="text" class="form-control" id="email-new-user-subj" name="email-new-user-subj" value="<?php echo $generic->getOption('email-new-user-subj'); ?>">
                        <span class="help-block">Nội dung</span>
                        <div class="input-icon right">
                            <textarea class="form-control" id="email-new-user-msg" name="email-new-user-msg" rows="10"><?php echo $generic->getOption('email-new-user-msg'); ?></textarea>
                        </div>
                        <div class="help-inline">
                            <p><strong>Shortcodes:</strong></p>
                            <p>Site address: <code>{{site_address}}</code></p>
                            <p>Full name: <code>{{full_name}}</code></p>
                            <p>Username: <code>{{username}}</code></p>
                            <p>Email: <code>{{email}}</code></p>
                        </div>
                    </div>
                    <legend><strong>Activation emails</strong></legend>
                    <div class="form-group">
                        <label  class="control-label">Resend link</label>
                        <i class="icon-info-sign tooltips" data-original-title="Người dùng sẽ nhận được email này khi yêu cầu gửi lại link kích hoạt" data-container="body"></i>
                        <span class="help-block">Tiêu đề</span>
                        <input type="text" class="form-control" id="email-activate-resend-subj" name="email-activate-resend-subj" value="<?php echo $generic->getOption('email-activate-resend-subj'); ?>">
                        <span class="help-block">Nội dung</span>
                        <div class="input-icon right">
                            <textarea class="form-control" id="email-activate-resend-msg" name="email-activate-resend-msg" rows="10"><?php echo $generic->getOption('email-activate-resend-msg'); ?></textarea>
                        </div>
                        <div class="help-inline">
                            <p><strong>Shortcodes:</strong></p>
                            <p>Site address: <code>{{site_address}}</code></p>
                            <p>Full name: <code>{{full_name}}</code></p>
                            <p>Username: <code>{{username}}</code></p>
                            <p>Activation link: <code>{{activate}}</code></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="control-label">Activated </label>
                        <i class="icon-info-sign tooltips" data-original-title="Người dùng sẽ nhận được email này sau khi kích hoạt thành công tài khoản của họ" data-container="body"></i>
                        <span class="help-block">Tiêu đề</span>
                        <input type="text" class="form-control" id="email-activate-subj" name="email-activate-subj" value="<?php echo $generic->getOption('email-activate-subj'); ?>">
                        <span class="help-block">Nội dung</span>
                        <div class="input-icon right">
                            <textarea class="form-control" id="email-activate-msg" name="email-activate-msg" rows="10"><?php echo $generic->getOption('email-activate-msg'); ?></textarea>
                        </div>
                        <div class="help-inline">
                            <p><strong>Shortcodes:</strong></p>
                            <p>Site address: <code>{{site_address}}</code></p>
                            <p>Full name: <code>{{full_name}}</code></p>
                            <p>Username: <code>{{username}}</code></p>
                        </div>
                    </div>
                    <legend><strong>Account recovery emails</strong></legend>
                    <div class="form-group">
                        <label  class="control-label">Recover request</label>
                        <i class="icon-info-sign tooltips" data-original-title="Người dùng sẽ nhận email này khi họ yêu cầu tên đăng nhập hay mật khẩu" data-container="body"></i>
                        <span class="help-block">Tiêu đề</span>
                        <input type="text" class="form-control" id="email-forgot-subj" name="email-forgot-subj" value="<?php echo $generic->getOption('email-forgot-subj'); ?>">
                        <span class="help-block">Nội dung</span>
                        <div class="input-icon right">
                            <textarea class="form-control" id="email-forgot-msg" name="email-forgot-msg" rows="10"><?php echo $generic->getOption('email-forgot-msg'); ?></textarea>
                        </div>
                        <div class="help-inline">
                            <p><strong>Shortcodes:</strong></p>
                            <p>Site address: <code>{{site_address}}</code></p>
                            <p>Full name: <code>{{full_name}}</code></p>
                            <p>Username: <code>{{username}}</code></p>
                            <p>Reset link: <code>{{reset}}</code></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="control-label">Recovered </label>
                        <i class="icon-info-sign tooltips" data-original-title="Người dùng sẽ nhận email này khi họ reset thành công mật khẩu của họ" data-container="body"></i>
                        <span class="help-block">Tiêu đề</span>
                        <input type="text" class="form-control" id="email-forgot-success-subj" name="email-forgot-success-subj" value="<?php echo $generic->getOption('email-forgot-success-subj'); ?>">
                        <span class="help-block">Nội dung</span>
                        <div class="input-icon right">
                            <textarea class="form-control" id="email-forgot-success-msg" name="email-forgot-success-msg" rows="10"><?php echo $generic->getOption('email-forgot-success-msg'); ?></textarea>
                        </div>
                        <div class="help-inline">
                            <p><strong>Shortcodes:</strong></p>
                            <p>Site address: <code>{{site_address}}</code></p>
                            <p>Full name: <code>{{full_name}}</code></p>
                            <p>Username: <code>{{username}}</code></p>
                        </div>
                    </div>
                    <legend><strong>Add user</strong></legend>
                    <div class="form-group">
                        <label  class="control-label">Add user</label>
                        <i class="icon-info-sign tooltips" data-original-title="Khi Admin tạo mới tài khoản trong Admin panel, người dùng sẽ nhận được email này" data-container="body"></i>
                        <span class="help-block">Tiêu đề</span>
                        <input type="text" class="form-control" id="email-add-user-subj" name="email-add-user-subj" value="<?php echo $generic->getOption('email-add-user-subj'); ?>">
                        <span class="help-block">Nội dung</span>
                        <div class="input-icon right">
                            <textarea class="form-control" id="email-add-user-msg" name="email-add-user-msg" rows="10"><?php echo $generic->getOption('email-add-user-msg'); ?></textarea>
                        </div>
                        <div class="help-inline">
                            <span class="help-block">Chú ý: Mật khẩu được tạo ngẫu nhiên và nên bao gồm cả email</span>
                            <p><strong>Shortcodes:</strong></p>
                            <p>Site address: <code>{{site_address}}</code></p>
                            <p>Full name: <code>{{full_name}}</code></p>
                            <p>Username: <code>{{username}}</code></p>
                            <p>Password: <code>{{password}}</code></p>
                        </div>
                    </div>
                    <legend><strong>'My Account' changes</strong></legend>
                    <p><b>Note:</b> Chỉ gửi khi người dùng thay đổi Email / Password của họ.</p>
                    <div class="form-group">
                        <label  class="control-label">Verify change</label>
                        <i class="icon-info-sign tooltips" data-original-title="Khi Admin tạo mới tài khoản trong Admin panel, người dùng sẽ nhận được email này" data-container="body"></i>
                        <span class="help-block">Tiêu đề</span>
                        <input type="text" class="form-control" id="email-acct-update-subj" name="email-acct-update-subj" value="<?php echo $generic->getOption('email-acct-update-subj'); ?>">
                        <span class="help-block">Nội dung</span>
                        <div class="input-icon right">
                            <textarea class="form-control" id="email-acct-update-msg" name="email-acct-update-msg" rows="10"><?php echo $generic->getOption('email-acct-update-msg'); ?></textarea>
                        </div>
                        <div class="help-inline">
                            <p><strong>Shortcodes:</strong></p>
                            <p>Site address: <code>{{site_address}}</code></p>
                            <p>Full name: <code>{{full_name}}</code></p>
                            <p>Username: <code>{{username}}</code></p>
                            <p>Confirmation link: <code>{{confirm}}</code></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="control-label">Updated </label>
                        <i class="icon-info-sign tooltips" data-original-title="Người dùng sẽ nhận email này khi họ xác nhận sự thay đổi" data-container="body"></i>
                        <span class="help-block">Tiêu đề</span>
                        <input type="text" class="form-control" id="email-acct-update-success-subj" name="email-acct-update-success-subj" value="<?php echo $generic->getOption('email-acct-update-success-subj'); ?>">
                        <span class="help-block">Nội dung</span>
                        <div class="input-icon right">
                            <textarea class="form-control" id="email-acct-update-success-msg" name="email-acct-update-success-msg" rows="10"><?php echo $generic->getOption('email-acct-update-success-msg'); ?></textarea>
                        </div>
                        <div class="help-inline">
                            <p><strong>Shortcodes:</strong></p>
                            <p>Site address: <code>{{site_address}}</code></p>
                            <p>Full name: <code>{{full_name}}</code></p>
                            <p>Username: <code>{{username}}</code></p>
                        </div>
                    </div>
                    <div class="margiv-top-10">
                        <button type="submit" class="btn green">Lưu thay đổi</button>
                    </div>
                </form>

            </div>
            <!-- <div id="tab_4-4" class="tab-pane">

                <form action="#" class="">
                    <legend><strong>Social login</strong></legend>
                    <p>Kích hoạt một số phương thức cho phép người dùng đăng nhập thông qua chúng</p>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="inputSuccess">Twitter</label>
                        <div class="checkbox-list col-md-9">
                            <label>
                                <input type="checkbox"> Kích hoạt
                            </label>
                        </div>
                        <div class="input-icon right col-md-9">
                            <input class="form-control" type="text" placeholder="Consumer key"><br />
                            <input class="form-control" type="text" placeholder="Consumer secret">
                            <p>Đầu tiên, bạn phải <a href="https://dev.twitter.com/apps/new">cài đặt 1 Twitter App</a>.</p>
                            <p>Khi cài đặt ứng dụng của bạn, Callback URL sẽ là <code>http://localhost</code></p>
                        </div>
                    </div><br />
                    <div class="form-group">
                        <label class="control-label col-md-3" for="inputSuccess">Facebook</label>
                        <div class="checkbox-list col-md-9">
                            <label>
                                <input type="checkbox"> Kích hoạt
                            </label>
                        </div>
                        <div class="input-icon right col-md-9">
                            <input class="form-control" type="text" placeholder="App ID"><br />
                            <input class="form-control" type="text" placeholder="App Secret">
                            <p>Đầu tiên bạn phải <a href="https://developers.facebook.com/apps">cài đặt một Facebook App</a>.</p>
                        </div>
                    </div><br />
                    <div class="form-group">
                        <label  class="col-md-3 control-label">OpenID Networks</label>
                        <div class="col-md-9">
                            <div class="checkbox-list">
                                <label>
                                    <input type="checkbox"> Google
                                </label>
                                <label>
                                    <input type="checkbox"> Yahoo
                                </label>
                            </div>
                        </div>
                    </div>
                    <legend><strong>Captcha signup</strong></legend>
                    <div class="form-group">
                        <label  class="col-md-3 control-label">Captcha</label>
                        <div class="col-md-9">
                            <div class="radio-list">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked> Disable captcha
                                </label>
                            </div>
                            <div class="radio-list">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked> Kích hoạt <a href="http://www.google.com/recaptcha">reCAPTCHA</a>
                                </label>
                            </div>
                            <div class="input-icon right">
                                <input class="form-control" type="text" placeholder="App ID"><br />
                                <input class="form-control" type="text" placeholder="App Secret">
                                <p>You must first <a href="http://www.google.com/recaptcha/whyrecaptcha">create a reCAPTCHA key</a>.</p>
                            </div><br />
                            <div class="radio-list">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked> Kích hoạt <a href="http://areyouahuman.com/?utm_source=Jigowatt&amp;utm_medium=Jigowatt&amp;utm_campaign=Jigowatt">PlayThru</a>
                                </label>
                            </div>
                            <div class="input-icon right">
                                <input class="form-control" type="text" placeholder="App ID"><br />
                                <input class="form-control" type="text" placeholder="App Secret">
                                <p>You must first <a href="http://portal.areyouahuman.com/signup?utm_source=Jigowatt&amp;utm_medium=Jigowatt&amp;utm_campaign=Jigowatt">signup to get a site key</a>.</p>
                            </div><br />
                        </div>
                    </div>
                    <!--end profile-settings-->
                    <!-- <div class="margin-top-10">
                        <a href="#" class="btn green">Save Changes</a>
                    </div>
                </form>
            </div> -->
        </div>
    </div>
    <!--end col-md-9-->
</div>
<!-- END PAGE CONTENT-->
</div>
<!-- END PAGE -->