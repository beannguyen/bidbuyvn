<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<?php
if ( $this->error === 'not_found' || $this->error === 'link_not_found' ) {

    $msg = '<div class="alert alert-error"> Liên kết kích hoạt của bạn không đúng.</div>'
        .'<h5> Làm gì bây giờ? </h5>'
        .'<p>Kiểm tra lại liên kết trong email, hoặc <strong><a href="' . URL::get_site_url() . '/admin/login/index/resendpage" >nhấn vào đây</a></strong> để gửi lại link kích hoạt cho bạn!</p>';
} else {
    $msg = "<div class=\'alert alert-success\'>Tài khoản của bạn đã được kích hoạt! </div> Vui lòng đợi trong 3 giây, hệ thống đang chuyển hướng về trang đăng nhập...";
?>
    <script type="text/javascript">
        var i = 3;
        var time = setInterval(function () {
            i--;
            if (i == 0) {
                clearInterval(time);
                window.location = '<?php echo(URL::get_site_url().'/admin/login'); ?>';
            }
        }, 1000);
    </script>
<?php
}

echo $msg;
?>

</body>
</html>