var Register = function () {

    var handleRegister = function () {

        $("#country_select").select2({
            placeholder: '<i class="icon-map-marker"></i>&nbsp;Select a Country',
            allowClear: true
        });

        $('#country_select').change(function () {
            $('.register-form').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });

        // tên đăng nhập chỉ chứa chữ thường, chữ hoa, chữ số, dấu gạch dưới
        $.validator.addMethod("validUsername", function (value, element) {

            return /^[0-9a-zA-Z_.-]+$/.test(value);
        }, "Tên người dùng chỉ chứa chữ hoa, thường, số và dấu gạch dưới.");

        // phone number must be number
        $.validator.addMethod("validPhoneNumber", function (n, element) {

            return !isNaN(parseFloat(n)) && isFinite(n);
        }, "Bạn phải nhập đúng số điện thoại.");

        // tên đăng nhập đã tồn tại hay chưa
        $.validator.addMethod("existedUsername", function (value, element) {

            var datastring = 'username=' + value;
            var temp = false;

            $.ajax({
                type: "POST",
                url: "../admin/register/isExistedUsername",
                data: datastring,
                async: false,
                success: function (responseText) {

                    if (responseText != 1) {
                        temp = true;
                    }
                }
            });
            return temp;
        }, "Tên người dùng đã được sử dụng.");

        // check if the email are existed or not
        $.validator.addMethod("existedEmail", function (value, element) {

            var datastring = 'email=' + value;
            var temp = false;

            $.ajax({
                type: "POST",
                url: "../admin/register/isExistedEmail",
                data: datastring,
                async: false,
                success: function (responseText) {

                    if (responseText != 1) {
                        temp = true;
                    }
                }
            });
            return temp;
        }, "Email đã được sử dụng.");

        //
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
                    email: true,
                    existedEmail: true
                },

                phonenum: {
                    required: true,
                    validPhoneNumber: true
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
                    required: true,
                    minlength: 5,
                    validUsername: true,
                    existedUsername: true
                },

                password: {
                    required: true,
                    minlength: 8
                },

                rpassword: {
                    required: true,
                    equalTo: "#register_password"
                },

                tnc: {
                    required: true
                }
            },

            messages: { // custom messages for radio buttons and checkboxes
                fullname: {
                    required: "Bạn chưa nhập họ tên."
                },

                email: {
                    required: "Bạn chưa nhập email.",
                    email: "Hãy nhập đúng định dạng email"
                },

                address: {
                    required: "Bạn chưa nhập địa chỉ"
                },

                phonenum: {
                    required: "Bạn chưa nhập số điện thoại"
                },

                city: {
                    required: "Bạn chưa nhập Tình/Thành phố"
                },

                country: {
                    required: "Bạn chưa chọn quốc gia"
                },

                username: {
                    required: "Bạn chưa nhập tên đăng nhập",
                    minlength: "Tên đăng nhập chứa ít nhất 5 ký tự"
                },

                password: {
                    required: "Bạn chưa nhập mật khẩu",
                    minlength: "Mật khẩu ít nhất 8 ký tự"
                },

                rpassword: {
                    required: "Bạn chưa nhập lại mật khẩu",
                    equalTo: "Mật khẩu không trùng khớp"
                },

                tnc: {
                    required: "Vui lòng đồng ý với điều khoản sử dụng."
                }
            },

            invalidHandler: function (event, validator) { //dtisplay error alert on form submi

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

    }

    return {
        //main function to initiate the module
        init: function () {

            handleRegister();

        }

    };

}();
