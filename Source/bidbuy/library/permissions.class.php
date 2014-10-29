<?php

class Permission extends BitField
{
    protected $roles = array(
        'can_login_dashboard'                   => 1,
        'can_manager_users'                     => 2,
        'can_reset_password'                    => 4,
        'can_modify_own_profile'                => 8,
        'can_modify_user_profile'               => 16,
        'can_active_seller_account'             => 32,
        'can_ban_user'                          => 64,
        'can_change_user_system_settings'       => 128,
        'can_edit_email_templates'              => 256,
        'can_manager_categories'                => 512,
        'can_add_category'                      => 1024,
        'can_edit_category'                     => 2048,
        'can_delete_category'                   => 4096,
        'can_manager_all_products'              => 8192,
        'can_manager_own_products'              => 16384,
        'can_active_product_to_bid'             => 32768,
        'can_add_product'                       => 65536,
        'can_edit_product'                      => 131072,
        'can_move_product_to_trash'             => 262144,
        'can_manager_invoices'                  => 524288,
        'can_manager_comments'                  => 1048576,
        'can_post_comment'                      => 2097152,
        'can_bid'                               => 4194304,
        'can_change_site_settings'              => 8388608
    );
}