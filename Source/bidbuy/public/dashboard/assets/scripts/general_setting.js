var General_Setting = function ()
{
    var handleGeneralSettingSubmit = function () {
        $('#general_setting_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                site_tile: {
                    required: true,
                    maxlength: 60
                },
                email_address: {
                    required: true,
                    email: true
                }
            },

            messages: { // custom messages for radio buttons and checkboxes

                site_tile: {
                    required: "Hãy nhập tiêu đề Website",
                    maxlength: "Tiêu đề trang quá dài"
                },
                email_address: {
                    required: "Hãy nhập email của quản trị viên",
                    email: "Hãy nhập đúng định dạng email"
                }
            },

            invalidHandler: function (event, validator) { //dtisplay error alert on form submit

            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            submitHandler: function (form) {
                $("span.process_loading").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/loading.gif'>");
                var site_title = $('#site_title').val();
                var email = $('#email_address').val();

                var datastring = 'site_title=' + site_title + '&admin_email=' + email;
                var temp = false;

                $.ajax({
                    type: "POST",
                    url: "../admin/setting/updateSetting",
                    data: datastring,
                    async: false,
                    success: function (responseText) {
                        if (responseText == 1) {
                            $("span.process_loading").html("");
                            $('.alert-success', '#general_setting_form').show();
                        } else {
                            $("span.process_loading").html("");
                            $('.alert-warning', '#general_setting_form').show();
                        }
                    }
                });
            }
        });


    }

    var handleMailServSubmit = function () {
        $('#mailserv_setting_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                mailserver_url: {
                    required: true
                },
                mailserver_port: {
                    required: true
                },
                mailserver_login: {
                    required: true
                },
                mailserver_pass: {
                    required: true
                }
            },

            messages: { // custom messages for radio buttons and checkboxes

                mailserver_url: {
                    required: "Không bỏ trống mục này"
                },
                mailserver_port: {
                    required: "Không bỏ trống mục này"
                },
                mailserver_login: {
                    required: "Không bỏ trống mục này"
                },
                mailserver_pass: {
                    required: "Không bỏ trống mục này"
                }
            },

            invalidHandler: function (event, validator) { //dtisplay error alert on form submit

            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            submitHandler: function (form) {
                $("span.process_loading").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/loading.gif'>");
                var mailserver_url = $('#mailserver_url').val();
                var mailserver_port = $('#mailserver_port').val();
                var mailserver_login = $('#mailserver_login').val();
                var mailserver_pass = $('#mailserver_pass').val();

                var datastring = 'mailserver_url=' + mailserver_url + '&mailserver_port=' + mailserver_port + '&mailserver_port=' + mailserver_login + '&mailserver_pass=' + mailserver_pass;
                var temp = false;

                $.ajax({
                    type: "POST",
                    url: "../admin/setting/updateSetting",
                    data: datastring,
                    async: false,
                    success: function (responseText) {
                        if (responseText == 1) {
                            $("span.process_loading").html("");
                            $('.alert-success', '#general_setting_form').show();
                        } else {
                            $("span.process_loading").html("");
                            $('.alert-warning', '#general_setting_form').show();
                        }
                    }
                });
            }
        });
    }

    var handleBtnClick = function () {
        jQuery('#btn-submit-form').click(function () {
            if(!$('.alert-success').is(':hidden'))
            {
                $('.alert-success').hide();
            }
            if(!$('.alert-warning').is(':hidden'))
            {
                $('.alert-warning').hide();
            }
        });
    }

    return {
        init : function () {
            handleGeneralSettingSubmit();
            handleMailServSubmit();
            handleBtnClick();
        }
    }
}();
