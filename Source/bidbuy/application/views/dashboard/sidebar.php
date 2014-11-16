<?php
$generic = new Generic();
?>
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <ul class="page-sidebar-menu">
        <li>
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <div class="sidebar-toggler hidden-phone"></div>
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        </li>
        <li class="start <?= (isset($this->activehome)) ? $this->activehome : ''; ?>">
            <a href="<?php echo URL::get_site_url(); ?>/admin/">
                <i class="icon-home"></i>
                <span class="title">Trang chủ</span>
                <span class="selected"></span>
            </a>
        </li>
        <?php if ($generic->getPermission(UserInfo::getUserId(), 'can_bid')): ?>
            <li class="<?= (isset($this->active_post)) ? $this->active_post : ''; ?>">
                <a href="javascript:;">
                    <i class="icon-file-text"></i>
                    <span class="title">Sản phẩm</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <?php if ($generic->getPermission(UserInfo::getUserId(), 'can_bid')): ?>
                        <li class="<?= (isset($this->activeorders)) ? $this->activeorders : ''; ?>">
                            <a href="javascript:;">
                                Hóa đơn
                                <span class="arrow "></span>
                            </a>
                            <ul style="display: none;" class="sub-menu">
                                <?php if ($generic->getPermission(UserInfo::getUserId(), 'can_add_product')): ?>
                                <li class="<?= (isset($this->activesellerorders)) ? $this->activesellerorders : ''; ?>"><a href="<?php echo URL::get_site_url(); ?>/admin/ordersforseller">Hóa đơn bán</a></li>
                                <?php endif; ?>
                                <?php if ($generic->getPermission(UserInfo::getUserId(), 'can_bid')): ?>
                                <li class="<?= (isset($this->activebuyerorders)) ? $this->activebuyerorders : ''; ?>"><a href="<?php echo URL::get_site_url(); ?>/admin/ordersforbuyer">Hóa đơn mua</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if ($generic->getPermission(UserInfo::getUserId(), 'can_add_product')): ?>
                        <li class="<?= (isset($this->products)) ? $this->products : ''; ?>">
                            <a href="<?php echo URL::get_site_url(); ?>/admin/products">
                                Sản phẩm
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($generic->getPermission(UserInfo::getUserId(), 'can_bid')): ?>
                        <li class="<?= (isset($this->mybids)) ? $this->mybids : ''; ?>">
                            <a href="<?php echo URL::get_site_url(); ?>/admin/mybids">
                                Sản phẩm đã đấu giá
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($generic->getPermission(UserInfo::getUserId(), 'can_add_product')): ?>
                        <li class="<?= (isset($this->addproducts)) ? $this->addproducts : ''; ?>">
                            <a href="<?php echo URL::get_site_url(); ?>/admin/add_product">
                                Thêm sản phẩm
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($generic->getPermission(UserInfo::getUserId(), 'can_manager_categories')): ?>
                        <li class="<?= (isset($this->category)) ? $this->category : ''; ?>">
                            <a href="<?php echo URL::get_site_url(); ?>/admin/category">
                                Danh mục</a>
                        </li>
                    <?php endif; ?>
                    <?php if ($generic->getPermission(UserInfo::getUserId(), 'can_manager_all_products')): ?>
                        <li class="<?= (isset($this->productSettings)) ? $this->productSettings : ''; ?>">
                            <a href="<?php echo URL::get_site_url(); ?>/admin/product_settings">
                                Cài đặt</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>

        <?php if ($generic->getPermission(UserInfo::getUserId(), 'can_manager_comments')): ?>
            <li class="<?= (isset($this->active_comment)) ? $this->active_comment : ''; ?>">
                <a href="<?php echo URL::get_site_url(); ?>/admin/comments">
                    <i class="icon-file-text"></i>
                    <span class="title">Nhận xét</span>
                </a>
            </li>
        <?php endif; ?>
        <li class="<?= (isset($this->activeuser)) ? $this->activeuser : ''; ?>">
            <a href="javascript:;">
                <i class="icon-user"></i>
                <span class="title">Người dùng</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <?php if ($generic->getPermission(UserInfo::getUserId(), 'can_manager_users')): ?>
                    <li class="<?= (isset($this->active_alluser)) ? $this->active_alluser : ''; ?>">
                        <a href="<?php echo URL::get_site_url(); ?>/admin/all_users">
                            Tất cả người dùng</a>
                    </li>
                <?php endif; ?>
                <?php if ($generic->getPermission(UserInfo::getUserId(), 'can_active_seller_account')): ?>
                    <li class="<?= (isset($this->active_seller)) ? $this->active_seller : ''; ?>">
                        <a href="<?php echo URL::get_site_url(); ?>/admin/activeSeller">
                            Kích hoạt seller</a>
                    </li>
                <?php endif; ?>
                <?php if ($generic->getPermission(UserInfo::getUserId(), 'can_modify_own_profile')): ?>
                    <li class="<?= (isset($this->active_userprofile)) ? $this->active_userprofile : ''; ?>">
                        <a href="<?php echo URL::get_site_url(); ?>/admin/dashboard/user_profile/<?php echo UserInfo::getUserId(); ?>">
                            Trang cá nhân</a>
                    </li>
                <?php endif; ?>
                <?php if ($generic->getPermission(UserInfo::getUserId(), 'can_change_user_system_settings')): ?>
                    <li class="<?= (isset($this->active_usersetting)) ? $this->active_usersetting : ''; ?>">
                        <a href="<?php echo URL::get_site_url(); ?>/admin/user_setting">
                            Cài đặt</a>
                    </li>
                <?php endif; ?>
            </ul>
        </li>
        <?php if ($generic->getPermission(UserInfo::getUserId(), 'can_change_site_settings')): ?>
            <li class="<?= (isset($this->activeTheme)) ? $this->activeTheme : ''; ?>">
                <a href="javascript:;" target="_blank">
                    <i class="icon-gift"></i>
                    <span class="title">Giao diện</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li class="<?= (isset($this->activeGeneral)) ? $this->activeGeneral : ''; ?>">
                        <a href="<?php echo URL::get_site_url(); ?>/admin/theme_option">
                            Tùy chỉnh giao diện</a>
                    </li>
                    <li class="<?= (isset($this->activeMenus)) ? $this->activeMenus : ''; ?>">
                        <a href="<?php echo URL::get_site_url(); ?>/admin/menus">
                            Menus</a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

        <?php if ($generic->getPermission(UserInfo::getUserId(), 'can_change_site_settings')): ?>
            <li class="<?= (isset($this->activesetting)) ? $this->activesetting : ''; ?>">
                <a href="javascript:;">
                    <i class="icon-cogs"></i>
                    <span class="title">Cài đặt</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li class="<?= (isset($this->active_setting)) ? $this->active_setting : ''; ?>">
                        <a href="<?php echo URL::get_site_url(); ?>/admin/general_setting">
                            Tổng quan</a>
                    </li>
                    <!-- <li>
                        <a href="admin/permalink_setting">
                            Permalinks</a>
                    </li> -->
                    <li class="<?= (isset($this->active_mail_setting)) ? $this->active_mail_setting : ''; ?>">
                        <a href="<?php echo URL::get_site_url(); ?>/admin/mailserv_setting">
                            Mail Server</a>
                    </li>
                    <!-- <li>
                        <a href="admin/pingservices_setting">
                            Ping Services</a>
                    </li> -->
                </ul>
            </li>
        <?php endif; ?>
    </ul>
    <!-- END SIDEBAR MENU -->
</div>
<!-- END SIDEBAR -->