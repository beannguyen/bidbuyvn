</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="footer">
    <div class="footer-inner">
        2014 &copy; Coder: BeanNguyen.
    </div>
    <div class="footer-tools">
         <span class="go-top">
         <i class="icon-angle-up"></i>
         </span>
    </div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/plugins/respond.min.js"></script>
<script src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>
<script src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/plugins/jquery.cookie.min.js" type="text/javascript"></script>
<script src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
<script src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/plugins/select2/select2.min.js"></script>
<!-- END CORE PLUGINS -->

<!-- PLUGINS -->
<script src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/scripts/generic.js" type="text/javascript"></script>
<script src="<?php echo URL::get_site_url() ?>/public/dashboard/assets/scripts/serialize.js" type="text/javascript"></script>
<?php
if(isset($this->js))
{
    $i = 0;
    while(isset($this->js[$i]))
    {
        echo "<script src='".URL::get_site_url()."/public/dashboard/assets/".$this->js[$i]."' type='text/javascript'></script>\n";
        $i++;
    }
}
?>
<!-- END -->

<script>
    jQuery(document).ready(function() {
        App.init(); // initlayout and core plugins
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

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>