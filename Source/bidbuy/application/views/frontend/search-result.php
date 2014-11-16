<section class="list-product">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 colums-9">
                <div class="tab-links-bid">
                    <ul>
                        <li class="active"><a href="javascript:;">Kết quả tìm kiếm</a></li>
                    </ul>
                </div>

                <script src='<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/countdown.js' type='text/javascript'></script>
                <div class="items-pro">
                    <div class="row">
                        <?php
                        $themeFunc = new ThemeFunction();
                        $themeFunc->loadProducts( $this->searchResult );
                        ?>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="paging">
                                <ul class="text-right">
                                    <?php
                                    echo $this->searchResult['navigation'];
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