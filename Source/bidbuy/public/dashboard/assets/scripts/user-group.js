var UserGroupManaged = function () {

    var handleSubmitForm = function () {

        // tên đăng nhập đã tồn tại hay chưa
        $.validator.addMethod("existedLevelName", function (value, element) {

            $("span.level_name_loading").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/loading.gif'>");
            var datastring = 'level-name=' + value;
            // console.log(datastring);
            var temp = true;

            $.ajax({
                type: "POST",
                url: "../admin/register/isExistedLevelName",
                data: datastring,
                async: false,
                success: function (responseText) {
                    // console.log(responseText);
                    if (responseText == 'existed') {
                        $("span.level_name_loading").html("");
                        temp = false;
                    } else {
                        $("span.level_name_loading").html("");
                    }
                }
            });
            return temp;
        }, "Tên nhóm người dùng đã được sử dụng.");
        // Email đã tồn tại hay chưa
        $.validator.addMethod("existedLevel", function (value, element) {

            $("span.level_level_loading").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/loading.gif'>");
            var datastring = 'level-level=' + value;
            var temp = true;

            $.ajax({
                type: "POST",
                url: "../admin/register/isExistedLevel",
                data: datastring,
                async: false,
                success: function (responseText) {
                    // console.log(responseText);
                    if (responseText == 'existed') {
                        $("span.level_level_loading").html("");
                        temp = false;
                    } else {
                        $("span.level_level_loading").html("");
                    }
                }
            });
            return temp;
        }, "Cấp độ này đã tồn tại.");
        //
        $('.add-new-group').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            onkeyup: false,
            onfocusout: false,
            rules: {
                level_name: {
                    required: true,
                    existedLevelName: true
                },
                level_level: {
                    required: true,
                    number: true,
                    existedLevel: true
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
                var level_name = $('#level_name').val();
                var level_level = $('#level_level').val();

                var datastring = 'level-name=' + level_name + '&level-level=' + level_level;
                var temp = false;

                $.ajax({
                    type: "POST",
                    url: "../admin/register/adminAddNewGroup",
                    data: datastring,
                    async: false,
                    success: function (responseText) {
                        console.log(responseText);
                        if (responseText == 1) {
                            $("span.process_loading").html("");
                            $('.note-success', '.add-new-group').show();
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
            $('#user_group_manager').dataTable({

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

            jQuery('#user_group_manager_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
            jQuery('#user_group_manager_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#user_group_manager_wrapper .dataTables_length select').select2(); // initialize select2 dropdown
            $("#user_group_manager_filter").css({ float: "right" });

            handleSubmitForm();
        }
    };

}();