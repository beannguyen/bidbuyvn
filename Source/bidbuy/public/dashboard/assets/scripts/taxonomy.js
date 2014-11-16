var selected = [];
var Taxonomy = function () {
    var handleSubmit = function () {
        // tên đăng nhập đã tồn tại hay chưa
        $.validator.addMethod("existedCategory", function (value, element) {

            $("span.loading").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/loading.gif'>");
            var type = $('#taxonomy').val();
            var slug = $('#category_slug').val();
            var datastring = 'type=' + type +'&category_name=' + value + '&category_slug=' + slug;
            //console.log(datastring);
            var temp = true;

            $.ajax({
                type: "POST",
                url: "../taxonomy/isCategoryExisted",
                data: datastring,
                async: false,
                success: function (responseText) {
                    // console.log(responseText);
                    if (responseText == '1') {
                        $("span.loading").html("");
                        temp = false;
                    } else if(responseText == '0'){
                        $("span.loading").html("");
                    }
                }
            });
            return temp;
        }, "Tên chuyên mục hoặc đường dẫn slug đã được sử dụng.");

        // tên đăng nhập đã tồn tại hay chưa
        $.validator.addMethod("existedOtherCategory", function (value, element) {

            $("span.process_loading").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/loading.gif'>");
            var category_id = $('#category_id').val();
            var datastring = 'category_id=' + category_id + '&category_slug=' + value;
            // console.log(datastring);
            var temp = false;

            $.ajax({
                type: "POST",
                url: "../../../taxonomy/isOtherCategoryExisted",
                data: datastring,
                async: false,
                success: function (responseText) {
                    // console.log(responseText);
                    if (responseText != 1) {
                        $("span.loading").html("");
                        temp = true;
                    } else {
                        $("span.loading").html("");
                    }
                }
            });
            return temp;
        }, "Tên chuyên mục hoặc đường dẫn slug đã được sử dụng.");
        //
        $('#submit-new-taxonomy').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            onkeyup: false,
            onfocusout: false,
            rules: {
                category_name: {
                    required: true,
                    existedCategory: true
                }
            },

            messages: { // custom messages for radio buttons and checkboxes
                category_name: {
                    required: "Bạn chưa nhập tên chuyên mục"
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
                form.submit();
            }
        });

        $('#modify_taxonomy').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            onkeyup: false,
            onfocusout: false,
            rules: {
                category_name: {
                    required: true,
                    existedOtherCategory: true
                },
                category_slug: {
                    existedOtherCategory: true
                }
            },

            messages: { // custom messages for radio buttons and checkboxes
                category_name: {
                    required: "Bạn chưa nhập tên chuyên mục"
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
                $("span.process_loading").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/loading.gif'>");
                var category_id = $('#category_id').val();
                var category_name = $('#category_name').val();
                var category_slug = $('#category_slug').val();
                var category_parent = $('#category_parent').val();
                var category_description = $('#category_description').val();
                var type = $('#taxonomy').val();

                var datastring = 'category_id=' + category_id + '&category_name=' + category_name + '&category_slug=' + category_slug + '&category_parent=' + category_parent + '&category_description=' + category_description + '&type=' + type;
                var temp = false;

                $.ajax({
                    type: "POST",
                    url: "../../../taxonomy/updateTaxonomy",
                    data: datastring,
                    async: false,
                    success: function (responseText) {

                        if (responseText == 1) {

                            $("span.process_loading").html("");
                            $('.update-success').show();
                        } else {
                            $("span.process_loading").html("");
                        }
                    }
                });
            }
        });

        jQuery('#submit_change_taxonomy').click(function() {
            if(!$('#alert').is(':hidden'))
            {
                $('.update-success').hide();
            }
        });

        jQuery( "input[type=checkbox]" ).on( "click", function() {
            if($(this).val() != "on" && $(this).is(":checked"))
                selected.push($(this).val());
        } );

        jQuery('#bulk-action').click(function() {
            var action = $('#select-bulk-action').val();
            // console.log(selected);
            if(action == 'delete')
            {

                $("span.bulk_action_loading").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/loading.gif'>");
                var id = '';
                for(var i = 0; i < selected.length; i++)
                {
                    id += selected[i] + ',';
                }
                id = id.substring(0, id.length -1);

                var datastring = 'id=' + id;
                console.log(datastring);
                var temp = false;

                $.ajax({
                    type: "POST",
                    url: "../admin/taxonomy/deleteTaxonomy",
                    data: datastring,
                    async: false,
                    success: function (responseText) {
                        //console.log(responseText);
                        if (responseText == '1') {
                            $("span.bulk_action_loading").html("");
                            var pathArray = window.location.pathname.split( '/' );
                            var newURL = window.location.protocol + "//" + window.location.host;
                            for(var j = 0; j < pathArray.length - 1; j++)
                            {
                                newURL += pathArray[j] + '/';
                            }
                            newURL += $('#taxonomy').val();
                            window.location = newURL;
                        } else if(responseText == 'cant_delete') {
                            $("span.bulk_action_loading").html("");
                            $(".delete_error").show();
                        } else if(responseText == 'error')
                        {
                            $(".delete_warning").show();
                            setTimeout(function() {
                                var pathArray = window.location.pathname.split( '/' );
                                var newURL = window.location.protocol + "//" + window.location.host;
                                for(var j = 0; j < pathArray.length - 1; j++)
                                {
                                    newURL += pathArray[j] + '/';
                                }
                                newURL += $('#taxonomy').val();
                                $("span.bulk_action_loading").html("");
                                window.location = newURL;
                            }, 3000);
                        }
                    }
                });

                // giai phong mang
                selected = [];
            }
            return false;
        });

    }

    return {
        //main function to initiate the module
        init: function () {

            handleSubmit();

            // table handle

            // begin table
            $('#all_categories').dataTable({
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
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [0]
                }
                ]
            });

            jQuery('#all_categories .group-checkable').change(function () {

                //
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                    } else {
                        $(this).attr("checked", false);
                    }
                });
                jQuery.uniform.update(set);

                // load to checked array
                var checked = $('.group-checkable').is(':checked');
                if(checked)
                    for(var i = 0; i < $( "input:checked" ).length - 1; i++)
                    {
                            selected.push($('#checkbox_' + i).val());
                    }
                else
                    selected = [];
            });

            jQuery('#all_categories_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
            jQuery('#all_categories_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#all_categories_wrapper .dataTables_length select').select2(); // initialize select2 dropdown
        }

    };
} ();