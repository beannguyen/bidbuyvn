var ProfileSetting = function () {

    var handleSetting = function () {
        //
        $('.user-profile-setting').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {

                email: {
                    email: true
                },
                phone_num: {
                    number: true,
                    minlength: 10,
                    maxlength: 11
                },
                website_url: {
                    url: true
                },
                sex: {
                    //require: true
                }
            },

            messages: { // custom messages for radio buttons and checkboxes
                email: {
                    email: "Hãy nhập đúng định dạng email"
                },

                phone_num:{
                    number: "Hãy nhập đúng định dạng số",
                    minlength: "Số điện thoại ít nhất 10 số",
                    maxlength: "Số điện thoại nhiều nhất 11 số"
                },

                website_url: {
                    url: "Nhập đúng định dạng URL"
                },

                sex: {
                    //require: "Chọn giới tính của bạn"
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

            submitHandler: function (form) {
                $("span.tab1_loading").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/ajax-loading.gif'>");
                // ajax require
                var userId = $('.userId').val();
                var name = $('.name').val();
                var date_of_birth = $('.date_of_birth').val();
                var sex = $('.sex').val();
                var email = $('.email').val();
                var phone_num = $('.phone_num').val();
                var job_title = $('.job_title').val();
                var website_url = $('.website_url').val();
                var yahoo_im = $('.yahoo_im').val();
                var skype = $('.skype').val();
                var about = $('.about').val();

                var datastring = 'userId=' + userId + '&name=' + name + '&date_of_birth=' + date_of_birth + '&sex=' + sex + '&email=' + email + '&phone_num=' + phone_num + '&job_title=' + job_title + '&website_url=' + website_url + '&yahoo_im=' + yahoo_im + '&skype=' + skype + '&about=' + about;
                console.log(datastring);
                var temp = false;

                $.ajax({
                    type: "POST",
                    url: "../../user/admUpdateProfile",
                    data: datastring,
                    async: false,
                    success: function (responseText) {
                        console.log( responseText );
                        if (responseText == 1) {
                            $("span.tab1_loading").html("");
                            $('.info-updated', $('.user-profile-setting')).show();
                        } else
                            $("span.tab1_loading").html("");
                    }
                });
            }
        });

        jQuery('#save-change-userinfo').click(function() {

            if(!$('.info-updated').is(':hidden'))
            {
                $('.info-updated').hide();
            }

            if(!$('.alert-danger').is(':hidden'))
            {
                $('.alert-danger').hide();
            }

            if(!$('.error-system').is(':hidden'))
            {
                $('.error-system').hide();
            }
        });

    }

    var handlePermission = function () {
        //
        $('#change_user_permission').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {

            },

            messages: { // custom messages for radio buttons and checkboxes

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

            submitHandler: function (form) {
                $("span.tab2_loading").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/ajax-loading.gif'>");
                // ajax require
                var user_id = $('#user_id').val();
                var user_group_selected = $('#user_group').val();
                var disable_user = ($('#disable_user').is(':checked')) ? 1 : 0;
                var delete_user = ($('#delete_user').is(':checked')) ? 1 : 0;

                var datastring = 'user_id=' + user_id + '&user_level=' + user_group_selected + '&disable_user=' + disable_user + '&delete_user=' + delete_user;
                //console.log(datastring);

                $.ajax({
                    type: "POST",
                    url: "../../user/admChangeUserPermission",
                    data: datastring,
                    success: function (responseText) {
                        //console.log(responseText);
                        if (responseText == 'updated') {
                            $("span.tab2_loading").html("");
                            $('.alert-success', $('#change_user_permission')).show();
                        } else if(responseText == 'deleted')
                        {
                            $("span.tab2_loading").html("");
                            $('.warning-deleted', $('#change_user_permission')).show();
                            var i = 3;
                            var time = setInterval(function () {
                                i--;
                                document.getElementById("timer").innerHTML = "<em>Trang sẽ reload sau " + i + "s</em>";
                                if (i == 0) {
                                    clearInterval(time);
                                    var pathArray = window.location.pathname.split( '/' );
                                    var newURL = window.location.protocol + "//" + window.location.host;
                                    for(var j = 0; j < pathArray.length - 2; j++)
                                    {
                                        newURL += pathArray[j] + '/';
                                    }
                                    newURL += 'all_users';
                                    window.location = newURL;
                                }
                            }, 1000);
                        } else if(responseText == 'cant_delete' || responseText == 'error')
                        {
                            $("span.tab2_loading").html("");
                            $('.error-system', $('#change_user_permission')).show();
                        }
                    }
                });
            }
        });

        jQuery('#save-change-userpermission').click(function() {
            if(!$('.warning-deleted').is(':hidden'))
            {
                $('.warning-deleted').hide();
            }

            if(!$('.permission-updated').is(':hidden'))
            {
                $('.permission-updated').hide();
            }
        });
    }

    var handleInputMasks = function () {
        $.extend($.inputmask.defaults, {
            'autounmask': true
        });

        $("#mask_date").inputmask("d/m/y", {
            autoUnmask: true
        }); //direct mask
    }

    var handleChangePassword = function () {
        jQuery('#changepass-success').hide();
        $('.change-password').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {

                newpassword: {
                    minlength: 8,
                    required: true
                },
                renewpassword: {
                    equalTo: '#newpassword'
                }

            },

            messages: {
                newpassword: {
                    minlength: "Mật khẩu tối thiểu 8 ký tự",
                    required: "Nhập mật khẩu mới để thay đổi"
                },
                renewpassword: {
                    equalTo: "Mật khẩu không khớp"
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

            submitHandler: function (form) {

                $("span.tab3_loading").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/ajax-loading.gif'>");
                // ajax require
                var userId = $('.userId').val();
                var password = $('#newpassword').val();
                var datastring = 'userId=' + userId + '&newpassword=' + password;
                var temp = false;

                $.ajax({
                    type: "POST",
                    url: "../../user/changePassword",
                    data: datastring,
                    async: false,
                    success: function (responseText) {
                        // create the backdrop and wait for next modal to be triggered
                        if (responseText == 1) {
                            $("span.tab3_loading").html("");
                            $('.alert-success', $('.change-password')).show();
                            $('#newpassword').val('');
                            $('#renewpassword').val('');
                        } else
                            $("span.tab3_loading").html("");
                    }
                });
            }
        });

        jQuery('#save-change-changepass').click(function() {

            if(!$('.password-changed').is(':hidden'))
            {
                $('.password-changed').hide();
            }
        });
    }

    return {
        //main function to initiate the module
        init: function () {

            handleSetting();
            handlePermission();
            handleInputMasks();
            handleChangePassword();

            // Get all levels
            var datastring2 = '';
            var temp2 = '';

            $.ajax({
                type: "POST",
                url: "../../../admin/user/returnAllLevels",
                data: datastring2,
                async: false,
                success: function (responseText) {
                    if (responseText != 1) {
                        temp2 = responseText;
                    }
                }
            });

            var tags2 = temp2.split(', ');
            $(".select2_user_group").select2({
                tags: tags2
            });
        }

    };

}();
