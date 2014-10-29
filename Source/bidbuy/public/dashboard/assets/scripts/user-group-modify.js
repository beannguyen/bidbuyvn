var UserGroupModify = function () {

    var handleSpinners = function () {
        $('#spinner-level').spinner();
    }
    var handleSubmitInfo = function ()
    {
        // tên đăng nhập đã tồn tại hay chưa
        $.validator.addMethod("isExistedLevelName", function (value, element) {

            $("span.level_name_loading").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/loading.gif'>");
            var level_id = $('#level_id').val();
            var datastring = 'modify=1' + '&level-id=' + level_id + '&level-name=' + value;
            var temp = true;

            $.ajax({
                type: "POST",
                url: "../../register/isExistedLevelName",
                data: datastring,
                async: false,
                success: function (responseText) {

                    if (responseText == 'existed') {
                        $("span.level_name_loading").html("");
                        temp = false;
                    } else {
                        $("span.level_name_loading").html("");
                    }
                }
            });
            return temp;
        }, "Tên nhóm người dùng mới của bạn đã được sử dụng.");
        // Email đã tồn tại hay chưa
        $.validator.addMethod("isExistedLevel", function (value, element) {

            $("span.level_level_loading").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/loading.gif'>");
            var level_id = $('#level_id').val();
            var datastring = 'modify=1' + '&level-id=' + level_id + '&level-level=' + value;
            var temp = true;

            $.ajax({
                type: "POST",
                url: "../../register/isExistedLevel",
                data: datastring,
                async: false,
                success: function (responseText) {

                    if (responseText == 'existed') {
                        $("span.level_level_loading").html("");
                        temp = false;
                    } else {
                        $("span.level_level_loading").html("");
                    }
                }
            });
            return temp;
        }, "Cấp độ  mới của bạn đã tồn tại.");
        $('#basic-information').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            onkeyup: false,
            onfocusout: false,
            rules: {
                level_name: {
                    required: true,
                    isExistedLevelName: true
                },
                level_level: {
                    required: true,
                    number: true,
                    isExistedLevel: true
                }
            },

            messages: { // custom messages for radio buttons and checkboxes

                level_name: {
                    required: "Bạn chưa nhập tên nhóm"
                },
                level_level: {
                    required: "Bạn chưa nhập cấp độ nhóm",
                    number: "Cấp độ phải là số"
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
                var level_id = $('#level_id').val();
                var level_name = $('#level_name').val();
                var level_level = $('#level_level').val();
                var disable_level = ($('#disable').is(':checked')) ? 1 : 0;
                var delete_level = ($('#delete').is(':checked')) ? 1 : 0;

                var datastring = 'modify=1&level-id=' + level_id + '&level-name=' + level_name + '&level-level=' + level_level + '&disable-level=' + disable_level + '&delete-level=' + delete_level;

                var temp = false;

                $.ajax({
                    type: "POST",
                    url: "../../register/adminAddNewGroup",
                    data: datastring,
                    async: false,
                    success: function (responseText) {
                        console.log( responseText );
                        if (responseText == 'updated') {

                            $("span.process_loading").html("");
                            $('.note-success').show();

                        } else if(responseText == 'cant_delete') {

                            $("span.process_loading").html("");
                            $('.alert-danger').show();

                        } else if(responseText == 'deleted') {

                            $("span.process_loading").html("");
                            $('.alert-warning').show();
                            var i = 3;
                            var time = setInterval(function () {
                                i--;
                                document.getElementById("timer").innerHTML = "<em>Trang sẽ chuyển hướng sau " + i + "s</em>";
                                if (i == 0) {
                                    clearInterval(time);
                                    var pathArray = window.location.pathname.split( '/' );
                                    var newURL = window.location.protocol + "//" + window.location.host;
                                    for(var j = 0; j < pathArray.length - 2; j++)
                                    {
                                        newURL += pathArray[j] + '/';
                                    }
                                    newURL += 'user_group';
                                    window.location = newURL;
                                }
                            }, 1000);

                        } else
                        {
                            $("span.process_loading").html("");
                            $('.note-success').show();
                        }
                    }
                });
            }
        });
    }
    var handleSubmitPermission = function () {

        $('#user_permission').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            onkeyup: false,
            onfocusout: false,
            rules: {

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
                $("span.permission_process_loading").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/loading.gif'>");

                // prepare
                var level_id = $('#level_id').val();
                var can_view_website = $('input[name=can-view-wesite]:checked').val();
                var can_view_thread_content = $('input[name=can-view-thread-content]:checked').val();
                var can_view_deletion_notice = $('input[name=can-view-deletion-notice]:checked').val();
                var can_post_new_thread = $('input[name=can-post-new-thread]:checked').val();
                var can_edit_own_thread = $('input[name=can-edit-own-thread]:checked').val();
                var can_delete_own_thread = $('input[name=can-delete-own-thread]:checked').val();
                var can_open_close_own_thread = $('input[name=can-open-close-own-thread]:checked').val();
                var can_moderate_all_website = $('input[name=can-moderate-all-website]:checked').val();
                var can_access_admin_dashboard = $('input[name=can-access-admin-dashboard]:checked').val();
                var can_view_member_info = $('input[name=can-view-member-info]:checked').val();
                var can_edit_own_profile = $('input[name=can-edit-own-profile]:checked').val();
                var can_send_private_message = $('input[name=can-send-private-message]:checked').val();

                var datastring = 'permission=1' + '&level_id=' + level_id +
                    '&can_view_website=' + can_view_website +
                    '&can_view_thread_content=' + can_view_thread_content +
                    '&can_view_deletion_notice=' + can_view_deletion_notice +
                    '&can_post_new_thread=' + can_post_new_thread +
                    '&can_edit_own_thread=' + can_edit_own_thread +
                    '&can_delete_own_thread=' + can_delete_own_thread +
                    '&can_open_close_own_thread=' + can_open_close_own_thread +
                    '&can_moderate_all_website=' + can_moderate_all_website +
                    '&can_access_admin_dashboard=' + can_access_admin_dashboard +
                    '&can_view_member_info=' + can_view_member_info +
                    '&can_edit_own_profile=' + can_edit_own_profile +
                    '&can_send_private_message=' + can_send_private_message;

                $.ajax({
                    type: "POST",
                    url: "../../register/modifyPermission",
                    data: datastring,
                    async: false,
                    success: function ( responseText ) {
                        if(responseText == 1)
                        {
                            $("span.permission_process_loading").html('');
                            $('.note-success').show();
                        }
                        else
                        {
                            $("span.permission_process_loading").html('');
                            $('.error-system').show();
                        }
                    }
                });
            }
        });

        jQuery('#save-change').click(function() {
            if(!$('.note-success').is(':hidden'))
            {
                $('.note-success').hide();
            }

            if(!$('.error-system').is(':hidden'))
            {
                $('.error-system').hide();
            }
        });

        jQuery('#save-change-permission').click(function() {
            if(!$('.note-success').is(':hidden'))
            {
                $('.note-success').hide();
            }
            if(!$('.error-system').is(':hidden'))
            {
                $('.error-system').hide();
            }
        });
    }
    return {
        //main function to initiate the module
        init: function () {
            handleSubmitInfo();
            handleSubmitPermission();
            handleSpinners();
        }
    };
}();