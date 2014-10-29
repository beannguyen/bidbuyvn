var AllUserManaged = function () {

    var handleSubmitForm = function () {

        // tên đăng nhập chỉ chứa chữ thường, chữ hoa, chữ số, dấu gạch dưới
        $.validator.addMethod("validUsername", function (value, element) {
            return /^[0-9a-zA-Z_.-]+$/.test(value);
        }, "Tên người dùng chỉ chứa chữ hoa, thường, số và dấu gạch dưới.");

        // tên đăng nhập đã tồn tại hay chưa
        $.validator.addMethod("existedUsername", function (value, element) {

            $("span.loading").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/loading.gif'>");
            var datastring = 'username=' + value;
            // console.log(datastring);
            var temp = false;

            $.ajax({
                type: "POST",
                url: "../admin/register/isExistedUsername",
                data: datastring,
                async: false,
                success: function (responseText) {

                    if (responseText != 1) {
                        $("span.loading").html("");
                        temp = true;
                    } else {
                        $("span.loading").html("");
                    }
                }
            });
            return temp;
        }, "Tên người dùng đã được sử dụng.");

        // Email đã tồn tại hay chưa
        $.validator.addMethod("existedEmail", function (value, element) {

            $("span.email_loading").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/loading.gif'>");
            var datastring = 'email=' + value;
            var temp = false;

            $.ajax({
                type: "POST",
                url: getRootWebSitePath() + "/admin/register/isExistedEmail",
                data: datastring,
                async: false,
                success: function (responseText) {

                    if (responseText != 1) {
                        $("span.email_loading").html("");
                        temp = true;
                    } else {
                        $("span.email_loading").html("");
                    }
                }
            });
            return temp;
        }, "Địa chỉ email này đã được sử dụng.");
        //
        $('.add-new-user-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            onkeyup: false,
            onfocusout: false,
            rules: {
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
                repassword: {
                    required: true,
                    equalTo: "#password"
                },
                email: {
                    required: true,
                    existedEmail: true,
                    email: true
                },
                name: {
                    required: true
                }
            },

            messages: { // custom messages for radio buttons and checkboxes

                username: {
                    required: "Tên đăng nhập không thể bỏ trống",
                    minlength: "Tên đăng nhập dài tối thiểu 5 kỳ tự"
                },
                password: {
                    required: "Mật khẩu không thể bỏ trống",
                    minlength: "Mật khẩu dài tối thiểu 8 ký tự"
                },
                repassword: {
                    required: "Nhập lại mật khẩu",
                    equalTo: "Mật khẩu không khớp"
                },
                email: {
                    required: "Nhập email người dùng",
                    email: "Hãy nhập đúng định dạng email"
                },
                name: {
                    required: "Nhập họ tên người dùng"
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
                var username = $('#username').val();
                var password = $('#password').val();
                var name = $('#name').val();
                var email = $('#email').val();

                var datastring = 'username=' + username + '&password=' + password + '&name=' + name + '&email=' + email;
                var temp = false;

                $.ajax({
                    type: "POST",
                    url: "../admin/register/adminAddNewUser",
                    data: datastring,
                    async: false,
                    success: function (responseText) {
                        if (responseText == 1) {
                            $("span.process_loading").html("");
                            $('.note-success', '.add-new-user-form').show();
                            var i = 3;
                            var time = setInterval(function () {
                                i--;
                                document.getElementById("timer").innerHTML = "<em>Trang sẽ reload sau " + i + "s</em>";
                                if (i == 0) {
                                    clearInterval(time);
                                    window.location = $(location).attr('href');
                                }
                            }, 1000);
                        } else {
                            $("span.process_loading").html("");
                        }
                    }
                });
            }
        });
    }

    return {

        //main function to initiate the module
        init: function () {

            if (!jQuery().dataTable) {
                return;
            }

            // begin first table
            $('#all_user_manager').dataTable({

                "aLengthMenu": [
                    [10, 20, 50, -1],
                    [10, 20, 50, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 10,
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ dòng",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [
                    {
                        'bSortable': true,
                        'aTargets': [0]
                    }
                ]
            });

            jQuery('#all_user_manager_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
            jQuery('#all_user_manager_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#all_user_manager_wrapper .dataTables_length select').select2(); // initialize select2 dropdown
            $("#all_user_manager_filter").css({ float: "right" });

            handleSubmitForm();
        }
    };

}();