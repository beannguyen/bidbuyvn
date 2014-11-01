<?php
class dashboardController extends Controller
{
    function __construct()
    {
        global $url;
        parent::__construct();
        if ( $url == 'login' ) {
            // nothing to do
        }
        elseif ( $url == 'register' ) {
            // nothing to do
        }
        elseif ( !parent::guestOnly() ) { // Only administrator can view this page
            URL::redirect_to( URL::get_site_url().'/admin/login' );
            exit();
        }
    }

    function index()
    {
        // if user can not access to dashboard
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_login_dashboard' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }

        $this->view->title = "Trang quản trị";
        $this->view->activehome = 'active';

        $this->view->render('dashboard/header');
        $this->view->render('dashboard/index');
        $this->view->render('dashboard/footer');
    }

    function logout($flag = null)
    {
        /** Check if the browser set a referrer. */
        $redirect = getenv('HTTP_REFERER') ? getenv('HTTP_REFERER') : URL::get_site_url();

        /** See if the admin wants to redirect to a specific page or not. */
        $redirect = $this->gen->getOption('signout-redirect-referrer-enable')
            ? $redirect
                : $this->gen->getOption('signout-redirect-url');

        /**
         * Begin removing their existence.
         *
         * Good bye friend :(. Promise you'll come back?!
         */
        if (isset($_SESSION['jigowatt']['username'])) :
            session_unset();
            session_destroy();
        endif;

        /** Voila! Here we shall gently nudge them somewhere else. */
        if(empty($flag))
        {
            header('Location: ' . $redirect);
            exit();
        }
    }

    function all_users($createSuccess = false)
    {
        // if user can not view member information
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_manager_users' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }

        $this->view->title = 'Quản lý người dùng';
        $this->view->activeuser = 'active';
        $this->view->active_alluser = 'active';
        if ($createSuccess != false)
            $this->view->createSuccess = 1;

        // load js
        $this->view->js[0] = 'scripts/all-user.js';
        $this->view->js[1] = 'plugins/data-tables/jquery.dataTables.js';
        $this->view->js[2] = 'plugins/data-tables/jquery.dataTables.columnFilter.js';
        $this->view->js[3] = 'plugins/data-tables/DT_bootstrap.js';
        $this->view->loadJS[0] = 'AllUserManaged';
        // load css
        $this->view->css[0] = 'plugins/data-tables/DT_bootstrap.css';
        $this->view->css[1] = 'plugins/data-tables/jquery.dataTables.css';


        $this->view->render('dashboard/header');
        $this->view->render('dashboard/user-manager/all_users');
        $this->view->render('dashboard/footer');
    }

    function activeSeller($userId = false)
    {
        // if user can not view member information
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_active_seller_account' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }

        $this->view->title = 'Kích hoạt tài khoản';
        $this->view->activeuser = 'active';
        $this->view->active_seller = 'active';

        // load js
        $this->view->js[0] = 'scripts/active-seller.js';
        $this->view->js[1] = 'plugins/data-tables/jquery.dataTables.js';
        $this->view->js[2] = 'plugins/data-tables/jquery.dataTables.columnFilter.js';
        $this->view->js[3] = 'plugins/data-tables/DT_bootstrap.js';
        $this->view->loadJS[0] = 'ActivationSeller';
        // load css
        $this->view->css[0] = 'plugins/data-tables/DT_bootstrap.css';
        $this->view->css[1] = 'plugins/data-tables/jquery.dataTables.css';


        $this->view->render('dashboard/header');
        $this->view->render('dashboard/user-manager/active_seller');
        $this->view->render('dashboard/footer');
    }

    /* function user_group()
    {
        // if user can not moderate all website
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_moderate_all_website' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }

        $this->view->title = 'Quản lý người dùng';
        $this->view->activeuser = 'active';
        $this->view->active_usergroup = 'active';

        // load js
        $this->view->js[0] = 'plugins/data-tables/jquery.dataTables.js';
        $this->view->js[1] = 'plugins/data-tables/jquery.dataTables.columnFilter.js';
        $this->view->js[2] = 'plugins/data-tables/DT_bootstrap.js';
        $this->view->js[3] = 'scripts/user-group.js';
        $this->view->loadJS[0] = 'UserGroupManaged';

        // load css
        $this->view->css[0] = 'plugins/data-tables/DT_bootstrap.css';
        $this->view->css[1] = 'plugins/data-tables/jquery.dataTables.css';

        $this->view->render('dashboard/header');
        $this->view->render('dashboard/user-manager/user_group');
        $this->view->render('dashboard/footer');
    }

    function user_group_modify($levelId = 1)
    {
        // if user can not moderate all website
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_moderate_all_website' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }

        $this->view->title = 'Chỉnh sửa nhóm người dùng';
        $this->view->activeuser = 'active';
        $this->view->active_usergroup = 'active';

        // load js
        $this->view->js[0] = 'plugins/fuelux/js/spinner.min.js';
        $this->view->js[1] = 'scripts/user-group-modify.js';
        $this->view->loadJS[0] = 'UserGroupModify';

        // is Admin?
        $this->view->isAdmin = true;
        if($levelId != 1)
            $this->view->isAdmin = false;
        // load information
        $this->loadModel('user');
        $level = $this->model->getLevel($levelId);
        if($level == false) {
            $this->view->error = "level_not_found";
            return;
        }
        else
            $this->view->info = $level;

        $this->view->render('dashboard/header');
        $this->view->render('dashboard/user-manager/user_group_modify');
        $this->view->render('dashboard/footer');
    } */

    function user_profile($userId = false, $msgflag = false)
    {
        // if user can not moderate all website
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_modify_own_profile' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }
        $this->loadModel('user');
        $this->view->title = 'Trang cá nhân';
        $this->view->activeuser = 'active';
        $this->view->active_userprofile = 'active';

        // load css
        $this->view->css[0] = 'css/pages/profile.css';
        $this->view->css[1] = 'plugins/jquery-tags-input/jquery.tagsinput.css';

        // load js
        $this->view->js[] = 'scripts/profile_setting_form.js';
        $this->view->loadJS[] = 'ProfileSetting';

        if($userId == false) {
            $this->view->error = "user_not_found";
        } else {
            $this->view->isAdmin = false;
            $isExistUser = $this->model->getUser($userId);
            $this->view->error = '';
            if($isExistUser == false) {
                $this->view->error = "user_not_found";
            } else {
                if($userId != 1)
                {
                    $this->view->profile_setting = 1;
                    $this->view->userId = $userId;
                    $this->view->user_info = $this->model->getUserInfo($userId);
                    $this->view->user_meta = $this->model->getUserMeta($userId);
                }
                else
                {
                    $this->view->userId = 1;
                    $this->view->isAdmin = true;

                    $this->view->user_info = $this->model->getUserInfo();
                    $this->view->user_meta = $this->model->getUserMeta();

                }
            }

        }

        $this->view->render('dashboard/header');
        $this->view->render('dashboard/user-manager/user_profile');
        $this->view->render('dashboard/footer');
    }

    function user_setting()
    {
        // if user can not moderate all website
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_change_user_system_settings' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }
        $this->view->title = 'Cài đặt hệ thống người dùng';
        $this->view->activeuser = 'active';
        $this->view->active_usersetting = 'active';

        // load js
        $this->view->js[] = 'scripts/form-user-setting.js';
        $this->view->loadJS[] = 'FormUserSetting';

        $this->view->render('dashboard/header');
        $this->view->render('dashboard/user-manager/user_setting');
        $this->view->render('dashboard/footer');
    }

    function general_setting()
    {
        // if user can not moderate all website
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_change_site_settings' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }
        $this->view->title = 'Cài đặt hệ thống';
        $this->view->activesetting = 'active';
        $this->view->active_setting = 'active';

        $this->loadModel('setting');
        $this->view->settings['site_title'] = $this->model->getSettings('site_title');
        $this->view->settings['admin_email'] = $this->model->getSettings('admin_email');

        $this->view->js[] = 'scripts/general_setting.js';
        $this->view->loadJS[] = 'General_Setting';

        $this->view->render('dashboard/header');
        $this->view->render('dashboard/setting/general_setting');
        $this->view->render('dashboard/footer');
    }

    function mailserv_setting()
    {
        // if user can not moderate all website
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_change_site_settings' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }
        $this->view->title = 'Cài đặt hệ thống';
        $this->view->activesetting = 'active';
        $this->view->active_mail_setting = 'active';

        $this->loadModel('setting');
        $this->view->settings = array(
            'mailserver_url' => $this->model->getSettings('mailserver_url'),
            'mailserver_login' => $this->model->getSettings('mailserver_login'),
            'mailserver_pass' => $this->model->getSettings('mailserver_pass'),
            'mailserver_port' => $this->model->getSettings('mailserver_port')
        );

        $this->view->js[] = 'scripts/general_setting.js';
        $this->view->loadJS[] = 'General_Setting';

        $this->view->render('dashboard/header');
        $this->view->render('dashboard/setting/mail_server_setting');
        $this->view->render('dashboard/footer');
    }

    function category()
    {
        // if user can not post new thread
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_manager_categories' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }

        $this->view->title = 'Chuyên mục';
        $this->view->active_post = 'active';
        $this->view->category = 'active';
        $this->view->taxonomy = 'category';

        // load css
        $this->view->css[0] = 'plugins/data-tables/DT_bootstrap.css';
        $this->view->css[1] = 'plugins/data-tables/jquery.dataTables.css';

        // load js
        $this->view->js[] = 'plugins/data-tables/jquery.dataTables.js';
        $this->view->js[] = 'plugins/data-tables/jquery.dataTables.columnFilter.js';
        $this->view->js[] = 'plugins/data-tables/DT_bootstrap.js';
        $this->view->js[] = 'scripts/taxonomy.js';
        $this->view->loadJS[] = 'Taxonomy';

        $this->view->render('dashboard/header');
        $this->view->render('dashboard/ecommerce/taxonomy');
        $this->view->render('dashboard/footer');
    }

    function modify_taxonomy($term_id = false, $type)
    {
        // if user can not post new thread
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_edit_category' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }

        $this->loadModel('taxonomy');
        $this->view->title = 'Chỉnh sửa chuyên mục';
        $this->view->active_post = 'active';
        $this->view->taxonomy = $type;
        if($type == 'category')
            $this->view->category = 'active';
        else
            $this->view->post_tag = 'active';
        if($term_id == false || !$this->model->getTaxonomy($term_id))
            $this->view->termNotFound = true;
        else
        {
            $this->view->term_id = $term_id;
            $this->view->info = $this->model->getTaxonomy($term_id);
            $parent = $this->model->getParentTaxonomy($term_id);
            if($parent != false)
            {
                $this->view->parent = $parent;
            }
        }
        $this->view->js[] = 'scripts/taxonomy.js';
        $this->view->loadJS[] = 'Taxonomy';
        $this->view->render('dashboard/header');
        $this->view->render('dashboard/ecommerce/modify_taxonomy');
        $this->view->render('dashboard/footer');
    }

    function theme_option( $response = false )
    {
        // if user can not post new thread
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_change_site_settings' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }

        $this->view->title = 'Chỉnh sửa giao diện';
        $this->view->activeTheme = 'active';
        $this->view->activeGeneral = 'active';

        $this->view->js[] = 'plugins/jquery-multi-select/js/jquery.multi-select.js';
        $this->view->js[] = 'plugins/jquery-multi-select/js/jquery.quicksearch.js';
        $this->view->js[] = 'scripts/theme-option.js';
        $this->view->loadJS[] = 'ThemeOptions';

        $this->view->css[] = 'plugins/jquery-multi-select/css/multi-select.css';

        // get response text
        if ( $response === 'updated' ) {
            $this->view->updateStatus = 'updated';
        } elseif ( $response === 'failed' ) {
            $this->view->updateStatus = 'failed';
        }

        $this->view->render('dashboard/header');
        $this->view->render('dashboard/theme/theme-option');
        $this->view->render('dashboard/footer');
    }

    function menus() {

        // if user can not post new thread
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_change_site_settings' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }

        $this->view->title = 'Chỉnh sửa menus';
        $this->view->activeMenus = 'active';
        $this->view->activeTheme = 'active';

        $this->view->css[] = 'plugins/jquery-nestable/jquery.nestable.css';
        $this->view->js[] = 'plugins/jquery-nestable/jquery.nestable.js';
        $this->view->js[] = 'scripts/theme-menus.js';
        $this->view->loadJS[] = 'ThemeMenus';

        // get category list
        $this->loadModel('taxonomy');
        $this->view->listCategories = $this->model->loadListCategory(true);
        $this->view->childCategories = $this->model->loadListCategory();
        // echo nestable menu list
        $this->loadModel( 'theme' );
        $this->view->menuList = $this->model->getMenu( 'dashboard' );
        $this->view->menuOptionItem = $this->model->getMenu( 'option' );

        $this->view->render( 'dashboard/header' );
        $this->view->render( 'dashboard/theme/menus' );
        $this->view->render( 'dashboard/footer' );
    }

    function orders()
    {
        $this->view->title = "Quản lý hóa đơn";
        $this->view->orders = "active";
        $this->view->active_post = "active";

        $this->view->render( 'dashboard/header' );
        $this->view->render( 'dashboard/ecommerce/orders' );
        $this->view->render( 'dashboard/footer' );
    }

    function products( $filterString = '' )
    {

        // if user can not post new thread
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_manager_own_products' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }
        // get filter
        if ( $filterString !== '' ) {

            $filters = parent::getFilters( $filterString );
        } else {

            // set default settings
            $filters['status'] = 'on-process';
            $filters['page'] = 1;
        }

        // get list post
        $this->loadModel( 'product' );
        $products = $this->model->getAllProducts( $filters, $filterString );
        $archives = $this->model->getArchives();
        // render to view
        if ( $products != false )
            $this->view->productInfo = $products;
        $this->view->filters = $filters;
        $this->view->archives = $archives;
        $this->view->generic = $this->gen;

        // load css
        $this->view->css[] = 'css/pages/coming-soon.css';
        // load js
        $this->view->js[] = 'plugins/moment.js';
        $this->view->js[] = 'plugins/countdown.js';
        $this->view->js[] = 'scripts/all-products.js';
        $this->view->loadJS[] = 'Products';

        $this->view->title = "Quản lý hóa đơn";
        $this->view->products = "active";
        $this->view->active_post = "active";

        $this->view->render( 'dashboard/header' );
        $this->view->render( 'dashboard/ecommerce/products' );
        $this->view->render( 'dashboard/footer' );
    }

    function add_product()
    {
        // if user can not post new thread
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_add_product' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }

        $this->view->title = 'Thêm hàng hóa';
        $this->view->addproducts = 'active';
        $this->view->active_post = 'active';

        //load css
        $this->view->css[] = 'plugins/dropzone/css/dropzone.css';
        $this->view->css[] = 'plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css';
        $this->view->css[] = 'plugins/jquery-tags-input/jquery.tagsinput.css';
        $this->view->css[] = 'plugins/bootstrap-fileupload/bootstrap-fileupload.css';
        //load js
        $this->view->js[] = 'plugins/jquery-tags-input/jquery.tagsinput.min.js';
        $this->view->js[] = 'plugins/numeral/min/numeral.min.js';
        $this->view->js[] = 'plugins/nicescroll/jquery.nicescroll.js';
        $this->view->js[] = 'plugins/jquery.mockjax.js';
        $this->view->js[] = 'plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.min.js';
        $this->view->js[] = 'plugins/bootstrap-fileupload/bootstrap-fileupload.js';
        $this->view->js[] = 'plugins/dropzone/dropzone.js';
        $this->view->js[] = 'scripts/form-dropzone.js';
        $this->view->loadJS[] = 'FormDropzone';

        // get category list
        $this->loadModel('taxonomy');
        $this->view->listCategories = $this->model->loadListCategory(true);
        $this->view->childCategories = $this->model->loadListCategory();

        $this->view->render('dashboard/header');
        $this->view->render('dashboard/ecommerce/add-product');
        $this->view->render('dashboard/footer');
    }

    function edit_product( $productId )
    {
        // if user can not post new thread
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_add_product' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }

        $this->loadModel('product');
        // if post not found
        if( empty( $productId ) || !$this->model->isExistProduct( $productId ) )
            URL::redirect_to(URL::get_site_url().'/admin/products');
        else
            $this->view->productId = $productId;

        // check product timeout
        $this->model->checkSingleProductTimeout( $productId );

        // get product information
        $this->view->info = $this->model->getProductInfo( $productId );

        // if you are not product author or not administrator
        if ( UserInfo::getUserId() != 1 && UserInfo::getUserId() != $this->view->info['product_author']['id'] ) {

            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }

        $this->view->title = 'Chỉnh hàng hóa';
        $this->view->addproducts = 'active';
        $this->view->active_post = 'active';

        //load css
        $this->view->css[] = 'plugins/dropzone/css/dropzone.css';
        $this->view->css[] = 'plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css';
        $this->view->css[] = 'plugins/jquery-tags-input/jquery.tagsinput.css';
        $this->view->css[] = 'plugins/bootstrap-fileupload/bootstrap-fileupload.css';
        //load js
        $this->view->js[] = 'plugins/jquery-tags-input/jquery.tagsinput.min.js';
        $this->view->js[] = 'plugins/numeral/min/numeral.min.js';
        $this->view->js[] = 'plugins/nicescroll/jquery.nicescroll.js';
        $this->view->js[] = 'plugins/jquery.mockjax.js';
        $this->view->js[] = 'plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.min.js';
        $this->view->js[] = 'plugins/bootstrap-fileupload/bootstrap-fileupload.js';
        $this->view->js[] = 'plugins/dropzone/dropzone.js';
        $this->view->js[] = 'scripts/form-dropzone.js';
        $this->view->loadJS[] = 'FormDropzone';

        // get category list
        $this->loadModel('taxonomy');
        $this->view->listCategories = $this->model->loadListCategory(true);
        $this->view->childCategories = $this->model->loadListCategory();

        $this->view->render('dashboard/header');
        $this->view->render('dashboard/ecommerce/add-product');
        $this->view->render('dashboard/footer');
    }

    function product_settings()
    {
        // if user can not post new thread
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_manager_all_products' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }

        $this->view->js[] = 'scripts/storeSettings.js';
        $this->view->loadJS[] = 'StoreSettings';

        $this->view->title = 'Tùy chỉnh';
        $this->view->productSettings = 'active';
        $this->view->active_post = 'active';

        $this->view->render('dashboard/header');
        $this->view->render('dashboard/ecommerce/settings');
        $this->view->render('dashboard/footer');
    }

    function accessdeny()
    {
        $this->view->title = 'Truy cập bị từ chối';
        $this->view->errName = 'Bạn không đủ quyền để truy câp trang này';
        $this->view->errDetail = 'Cấp bậc thành viên của bạn không đủ để truy cập vào trang này.<br /> Vui lòng quay lại hoặc liên hệ QTV để biết thêm chi tiết.';

        $this->view->render('dashboard/header');
        $this->view->render('dashboard/error/showError');
        $this->view->render('dashboard/footer');

    }
}