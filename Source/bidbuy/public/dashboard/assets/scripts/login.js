var Login = function () {

    var handleLogin = function () {
        $('.login-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                username: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                },
                remember: {
                    required: false
                }
            },

            messages: {
                username: {
                    required: "Nhập tên đăng nhập."
                },
                email: {
                    required: "Nhập email để đăng nhập",
                    email: "Email bạn nhập không đúng"
                },
                password: {
                    required: "Nhập mật khẩu."
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                $('.alert-error', $('.login-form')).show();
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function (form) {
                $("span.loading").html("<img src='"+ getRootWebSitePath() +"'/public/dashboard/assets/img/loading.gif'>");

                var username = $('#username').val();
                var email = $('#email').val();
                var password = $('#password').val();
                var token = $('#token').val();

                var datastring = 'login=1';
                if (document.getElementById('username') == null)
                    datastring += '&email=' + email + '&password=' + password;
                else
                    datastring += '&username=' + username + '&password=' + password;
                if ($('#remember').is(":checked"))
                    datastring += '&remember=1';
                datastring += '&token=' + token;

                $.ajax({
                    type: "POST",
                    url: "login/process",
                    data: datastring,
                    success: function (responseText) {
                        if (responseText == 'invalid_token') {

                            $("span.loading").html("");
                            $('#invalid_token').show();
                            $('#username').val('');
                            $('#email').val('');
                            $('#password').val('');
                        } else if (responseText == 'error_found') {

                            $("span.loading").html("");
                            $("#error_found").show();
                            $('#username').val('');
                            $('#email').val('');
                            $('#password').val('');
                        } else if (responseText == 'incorrect_password') {

                            $("span.loading").html("");
                            $("#incorrect_password").show();
                            $('#password').val('');
                        } else if (responseText == 'banned_user') {

                            $("span.loading").html("");
                            $("#banned_user").show();
                            $('#username').val('');
                            $('#email').val('');
                            $('#password').val('');
                        } else if (responseText == 'disable-login') {

                            $("span.loading").html("");
                            $("#disable-login").show();
                            $('#username').val('');
                            $('#email').val('');
                            $('#password').val('');
                        } else if (responseText == 'not_active') {

                            $("span.loading").html("");
                            $("#not_active").show();
                            $('#password').val('');
                        } else if (responseText == 'success') {

                            window.location = getRootWebSitePath() + '/admin';
                        }
                    }
                });
            }
        });

        $('.login-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit();
                }
                return false;
            }
        });
    }
    var handleForgetPassword = function () {
        $('.forget-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },

            messages: {
                email: {
                    required: "Chưa nhập email."
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit

            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function (form) {

                $("span.loading").html("<img src='"+ getRootWebSitePath() +"/public/dashboard/assets/img/loading.gif'>");
                var email = $('#email-reset-password').val();
                var dataString = 'email=' + email;

                $.ajax({
                    type: "POST",
                    url: "../admin/login/forgotPassword",
                    data: dataString,
                    success: function (responseText) {

                        // console.log(responseText);
                        $("span.loading").html("");
                        if (responseText === 'changed') {
                            $('.alert-success').html('Một email đã được hệ thống gửi đến hộp thư của bạn, vui lòng kiểm tra và làm theo hướng dẫn!');
                        } else if ( responseText === 'email_not_send' ) {
                            $('.alert-error').html('Hiện tại hệ thống mail của chung tôi gặp sự cố, vui lòng thử lại sau!');
                        } else if ( responseText === 'not_changed' || responseText === 'error' ) {
                            $('.alert-error').html( 'Hệ thống đang gặp sự cố, vui lòng thử lại sau' );
                        } else if ( responseText === 'email_not_found' ) {
                            $('.alert-error').html( 'Email này không tồn tại trong hệ thống, vui lòng kiểm tra lại!' );
                        }
                    },
                    error: function (data) {
                        $('.alert-error', $('.login-form')).show();
                    }
                })
            }
        });

        $('.forget-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('.forget-form').validate().form()) {
                    $('.forget-form').submit();
                }
                return false;
            }
        });

        jQuery('#forget-password').click(function () {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
        });

        jQuery('#forget-password-require').click(function () {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
        });

        jQuery('#back-btn').click(function () {
            jQuery('.login-form').show();
            jQuery('.forget-form').hide();
        });

        jQuery('#back-login-btn').click(function () {
            jQuery('.login-form').show();
            jQuery('.resend-key-form').hide();
        });

        jQuery('#resend-btn').click(function () {
            jQuery('.login-form').hide();
            jQuery('.resend-key-form').show();
        });

    }

    var handleResendKey = function () {
        $('.resend-key-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },

            messages: {
                email: {
                    required: "Chưa nhập email."
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit

            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function (form) {
                $("span.loading").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/loading.gif'>");
                var email = $('.resend-key-form #email-to-resend').val();

                var dataString = 'email-to-resend=' + email;
                //alert(dataString);

                $.ajax({
                    type: "POST",
                    url: "login/resend",
                    data: dataString,
                    success: function (responseText) {

                        $("span.loading").html("");
                        if (responseText === 'not_exist_user') {
                            $('#not_exist_user').show();
                        } else if ( responseText === 'key_not_found' ) {
                            $('#key_not_found').show();
                        } else if ( responseText === 'email_not_send' ) {
                            $('#email_not_send').show();
                        }
                    },
                    error: function (data) {
                        $('.alert-error', $('.resend-key-form')).show();
                    }
                })
            }
        });

        $('.forget-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('.resend-key-form').validate().form()) {
                    $('.resend-key-form').submit();
                }
                return false;
            }
        });

    }

    var handleRegister = function () {

        function format(state) {
            if (!state.id) return state.text; // optgroup
            return "<img class='flag' src='assets/img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
        }


        $("#select2_sample4").select2({
            placeholder: '<i class="icon-map-marker"></i>&nbsp;Select a Country',
            allowClear: true,
            formatResult: format,
            formatSelection: format,
            escapeMarkup: function (m) {
                return m;
            }
        });


        $('#select2_sample4').change(function () {
            $('.register-form').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });


        $('.register-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {

                fullname: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                address: {
                    required: true
                },
                city: {
                    required: true
                },
                country: {
                    required: true
                },

                username: {
                    required: true
                },
                password: {
                    required: true
                },
                rpassword: {
                    equalTo: "#register_password"
                },

                tnc: {
                    required: true
                }
            },

            messages: { // custom messages for radio buttons and checkboxes
                tnc: {
                    required: "Please accept TNC first."
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit

            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function (error, element) {
                if (element.attr("name") == "tnc") { // insert checkbox errors after the container
                    error.insertAfter($('#register_tnc_error'));
                } else if (element.closest('.input-icon').size() === 1) {
                    error.insertAfter(element.closest('.input-icon'));
                } else {
                    error.insertAfter(element);
                }
            },

            submitHandler: function (form) {
                form.submit();
            }
        });

        $('.register-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('.register-form').validate().form()) {
                    $('.register-form').submit();
                }
                return false;
            }
        });

        jQuery('#register-btn').click(function () {
            jQuery('.login-form').hide();
            jQuery('.register-form').show();
        });

        jQuery('#register-back-btn').click(function () {
            jQuery('.login-form').show();
            jQuery('.register-form').hide();
        });
    }

    return {
        //main function to initiate the module
        init: function () {

            handleLogin();
            handleForgetPassword();
            handleResendKey();
            //handleRegister();

            jQuery('.forget-btn').click(function () {
                $('#incorrect_password').hide();
            });
        }

    };

}();