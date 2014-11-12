<section class="list-product">
<div class="container">
<div class="row">
<div class="col-sm-9 colums-9">
<div class="tab-links-bid">
    <ul>
        <li class="<?php if ( isset ( $this->all ) ) echo $this->all; ?>"><a href="<?php echo URL::get_site_url(); ?>">Tất cả đấu giá</a></li>
        <li class="<?php if ( isset ( $this->topBid ) ) echo $this->topBid; ?>"><a href="<?php echo URL::get_site_url(); ?>/trang-chu/tab-top-bid.html">Nhiều nhất</a></li>
        <li class="<?php if ( isset ( $this->endingBid ) ) echo $this->endingBid; ?>"><a href="<?php echo URL::get_site_url(); ?>/trang-chu/tab-ending-bid.html">Sắp kết thúc</a></li>
    </ul>
</div>

<script src='<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/countdown.js' type='text/javascript'></script>
<div class="items-pro">
<div class="row">
<?php
    $themeFunc = new ThemeFunction();
    $themeFunc->loadProducts( $this->products );
?>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="paging">
            <ul class="text-right">
                <?php
                echo $this->products['navigation'];
                ?>
            </ul>
        </div>
    </div>
</div>
</div>
</div>

    <?php require_once( 'sidebar.php' ); ?>
</div>
</div>
</section>