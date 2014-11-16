<?php
require_once('function.php');
$themeFunc = new ThemeFunction();
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

    <!-- Basic Page Needs
  ================================================== -->
    <meta charset="utf-8">
    <title><?= (isset($this->title)) ? $this->title : 'bidbuy.vn'; ?></title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
  ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
  ================================================== -->
    <link href="<?php echo URL::get_site_url() ?>/public/dashboard/assets/plugins/font-awesome/css/font-awesome.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?php echo URL::get_site_url() ?>/public/dashboard/assets/plugins/uniform/css/uniform.default.css"
          rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="<?php echo URL::get_site_url(); ?>/public/frontend/assets/css/bootstrap.css">
    <link href="<?php echo URL::get_site_url() ?>/public/dashboard/assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="<?php echo URL::get_site_url(); ?>/public/frontend/assets/style.css">
    <script src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
    <!--[if lt IE 9]>
    <script src="<?php echo URL::get_site_url(); ?>/public/frontend/assets/js/html5.js"></script>
    <![endif]-->

    <!-- Favicons
    ================================================== -->
    <link rel="shortcut icon" href="<?php echo URL::get_site_url(); ?>/public/frontend/assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo URL::get_site_url(); ?>/public/frontend/assets/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo URL::get_site_url(); ?>/public/frontend/assets/images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo URL::get_site_url(); ?>/public/frontend/assets/images/apple-touch-icon-114x114.png">

</head>
<body>
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="top-link">
                    <span><a href="#">Trợ giúp</a></span>
                    <span>Hotline: <b><?php $themeFunc->get( 'hotline_support' ); ?></b></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="logo">
                    <a href="<?php echo URL::get_site_url(); ?>">
                        <img src="<?php echo URL::get_site_url(); ?>/public/frontend/assets/images/logo.png" alt="Bid buy">
                    </a>
                </div>
            </div>
            <!-- end -->

            <div class="col-sm-9">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-form">
                            <?php include('search-bar.php'); ?>
                            <?php if ( isset( $_SESSION['ssbidbuy']['user_id'] ) ) : ?>
                            <div class="button-bid">
                                <a href="<?php echo URL::get_site_url(); ?>/admin/mybids">My bids</a>
                            </div>
                            <?php endif; ?>
                            <div class="user-menu-zone">
                                <i class="fa fa-user"></i>
                                <?php if ( !isset( $_SESSION['ssbidbuy']['user_id'] ) ) : ?>
                                    <ul>
                                        <li>
                                            <a href="<?php echo URL::get_site_url() ?>/admin/register">Đăng kí</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo URL::get_site_url() ?>/admin/login">Đăng Nhập</a>
                                        </li>
                                    </ul>
                                <?php else: ?>
                                    <ul>
                                        <li>
                                            <span>Chào <a href="<?php echo URL::get_site_url() . '/admin/dashboard/user_profile/' . UserInfo::getUserId(); ?>"><?php echo UserInfo::getUsername(); ?></a></span>
                                        </li>
                                        <li>
                                            <a href="<?php echo URL::get_site_url() ?>/admin/dashboard/logout">Đăng xuất</a>
                                        </li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end -->
        </div>
    </div>
</header>
<!-- end header	 -->

<main>
    <nav class="main-nav">
        <div class="container">
            <ul class="main-nav-tab">
                <?php
                $themeFunc->getMenu();
                ?>
            </ul>
            <script type="text/javascript">
                jQuery(document).ready(function() {

                    var url = window.location.href;
                    $('.menu-item a').filter(function() {

                        return this.href == url;
                    }).parent('li').addClass('active');
                });
            </script>

            <div class="feature">
                <div class="row">
                    <div class="col-sm-12 col-md-9 colums-9">
                        <div class="main-slider">
                            <ul id="main-slider-inner" class="bxslider">
                                <?php
                                $themeFunc->loadFeatureSlide();
                                ?>
                            </ul>
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-3 colums-3">
                        <div class="inner" style="width: 220px; height: 303px; background-color: #C5CCC4">
                            <h1 style="padding: 30px; text-align: center; font-size: 43px;">QUẢNG <br />CÁO</h1>
                        </div>
                    </div>

                </div>
            </div>
            <!-- end feature -->
        </div>
    </nav>
    <!-- end main-nav	 -->