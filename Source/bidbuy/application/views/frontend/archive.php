<section class="list-product">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 colums-9">
                <?php if ( !$this->notfound ) : ?>
                <div class="tab-links-bid">
                    <ul>
                        <li class="active"><a href="javascript:;">Chuyên mục: <?php echo $this->title; ?></a></li>
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
                <?php else : ?>
                <div class="tab-links-bid">
                    <ul>
                        <li class="active"><a href="javascript:;">404 - Lỗi không tìm thấy</a></li>
                    </ul>
                </div>
                <div class="items-pro">
                    <div class="row">
                        <p class="product-not-found">Không tìm thấy liên kết bạn yêu cầu!</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <?php require_once( 'sidebar.php' ); ?>
        </div>
    </div>
</section>