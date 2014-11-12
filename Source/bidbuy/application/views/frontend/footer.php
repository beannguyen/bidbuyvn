</main>

<footer class="footer">
    <section class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <a href="#">
                        <img src="<?php echo URL::get_site_url(); ?>/public/frontend/assets/images/logo.png" alt="">
                    </a>

                    <div class="bid-app">
                        <p>Bid Apps:</p>
                        <?php
                        $themeFunc = new ThemeFunction();
                        $themeFunc->loadBidApps();
                        ?>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="social">
                        <h2>Kết nối với bidbuy.vn</h2>
                        <ul>
                            <?php
                            $themeFunc->loadSocialBox();
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <?php
                    $themeFunc->loadFooterCol( 3 );
                    ?>
                </div>
                <div class="col-sm-6 col-md-3">
                    <?php
                    $themeFunc->loadFooterCol( 4 );
                    ?>
                </div>
            </div>
        </div>
    </section>

    <section class="bot-footer">
        <div class="container">
            <div class="links-bot text-center">
                <?php
                $themeFunc->loadFooterCol();
                ?>
            </div>

        </div>
    </section>
</footer>
<!-- end footer -->

<!-- jQuery
================================================== -->
<script src="<?php echo URL::get_site_url(); ?>/public/frontend/assets/js/jquery.min.js"></script>
<script src="<?php echo URL::get_site_url(); ?>/public/frontend/assets/js/fancySelect.js"></script>
<script src="<?php echo URL::get_site_url(); ?>/public/frontend/assets/js/jquery.bxslider.min.js"></script>
<script src="<?php echo URL::get_site_url(); ?>/public/frontend/assets/js/main.js"></script>
<script src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/scripts/generic.js" type="text/javascript"></script>

<?php
if(isset($this->js))
{
    $i = 0;
    while(isset($this->js[$i]))
    {
        echo "<script src='".URL::get_site_url()."/public/frontend/assets/".$this->js[$i]."' type='text/javascript'></script>\n";
        $i++;
    }
}
?>
<script>
    jQuery(document).ready(function() {
        <?php
            if(isset($this->loadJS))
            {
                $i = 0;
                while(isset($this->loadJS[$i]))
                {
                    echo $this->loadJS[$i].".init();\n";
                    $i++;
                }
            }
        ?>
    });
</script>
</body>
</html>