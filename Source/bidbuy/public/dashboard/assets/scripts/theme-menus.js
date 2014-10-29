/**
 * Handle action Menus Option page
 */

var ThemeMenus = function () {
    var categoryIdSelected = [];
    var updateOutput = function (e) {
        var list = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };
    var handleCustomMenu = function () {
        $('#custom-menu-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                custom_link: {
                    required: true
                },
                custom_menu_item: {
                    required: true
                }
            },

            messages: {
                custom_link: {
                    required: "Bạn chưa nhập liên kết"
                },
                custom_menu_item: {
                    required: "Bạn chưa nhập tên menu"
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
                var custom_link = $('#custom_link').val();
                var custom_menu_item = $('#custom_menu_item').val();

                var dataString = 'type=custom&content=' + custom_link + '&menu_item=' + custom_menu_item;

                $.ajax({
                    type: "POST",
                    url: "../admin/theme/createMenu",
                    data: dataString,
                    success: function (responseText) {

                        $("span.loading").html("");
                        if (responseText === 'db_error') {

                            alert('error');
                        } else {

                            var details = JSON.parse(responseText);
                            // add to remove list
                            $('#remove-item-list').append('<option class="item-' + details.menu_id + '" value="' + details.menu_id + '">'+ details.menu_name +'</option>');
                            // add new item to menu list
                            $('ol#main_list').append(
                                "<li class='dd-item dd3-item' data-id='" + details.menu_id + "'>"
                                    + "<div class='dd-handle dd3-handle'></div>"
                                    + "<div class='dd3-content'>" + details.menu_name + " <em>(" + details.menu_type + ")</em>" + "</div>"
                                    + "</li>"
                            );
                            // clear text in input
                            $('#custom_link').val('http://');
                            $('#custom_menu_item').val('');
                            // output update serialised data
                            updateOutput($('#main_menu_list').data('output', $('#nestable_list_1_output')));
                        }
                    },
                    error: function (data) {
                        $('.alert-error', $('#custom-menu-form')).show();
                    }
                })
            }
        });
    }
    var handleCategoryMenu = function () {

        jQuery('.categorychecklist').click(function () {

            categoryIdSelected = [];
            $('#categorychecklist input:checked').each(function () {
                categoryIdSelected.push(this.value);
            });
        });

        jQuery('#category-menu-btn').click(function () {

            if (categoryIdSelected.length != 0) {
                $("span.loading_category").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/loading.gif'>");

                var categoryList = categoryIdSelected.join();

                var dataString = 'type=category&menu_item=&content=' + categoryList;

                $.ajax({
                    type: "POST",
                    url: "../admin/theme/createMenu",
                    data: dataString,
                    success: function (responseText) {
                        // console.log(responseText);
                        $("span.loading_category").html("");
                        if (responseText === 'db_error') {

                            alert('error');
                        } else {

                            var details = JSON.parse(responseText);
                            for (var i = 0; i < details.length; i++) {

                                // add new item to menu list
                                $('ol#main_list').append(
                                    "<li class='dd-item dd3-item' data-id='" + details[i].menu_id + "'>"
                                        + "<div class='dd-handle dd3-handle'></div>"
                                        + "<div class='dd3-content'>" + details[i].menu_name + " <em>(" + details[i].menu_type + ")</em>" + "</div>"
                                        + "</li>"
                                );
                                $('#remove-item-list').append('<option class="item-' + details[i].menu_id + '" value="' + details[i].menu_id + '">'+ details[i].menu_name +'</option>');
                            }

                            // output update serialised data
                            updateOutput($('#main_menu_list').data('output', $('#nestable_list_1_output')));
                        }
                    },
                    error: function (data) {
                        $('.alert-error', $('#custom-menu-form')).show();
                    }
                });
            } else {
                alert('Select a category to added to menu');
            }
        });
    }
    var handleNestable = function () {

        $('#main_menu_list').nestable({
            group: 1
        })
            .on('change', updateOutput);
        // output initial serialised data
        updateOutput($('#main_menu_list').data('output', $('#nestable_list_1_output')));

        jQuery('#save-menu-btn').click( function() {

            $("span.loading_save").html("<img src='http://localhost/batdongsan/public/dashboard/assets/img/loading.gif'>");
            var json_menuList = $('#nestable_list_1_output').val();
            var dataString = 'json_menu_list=' + json_menuList;

            $.ajax({
                type: "POST",
                url: "../admin/theme/updateMenuOption",
                data: dataString,
                success: function (responseText) {
                    // console.log(responseText);
                    $("span.loading_save").html("");
                    if (responseText === 'db_error') {

                        alert('error');
                    } else if ( responseText === 'success' ) {

                        alert('updated');
                    }
                },
                error: function (data) {
                    $('.alert-error', $('#custom-menu-form')).show();
                }
            });
        } );
        jQuery('#remove-item').click(function() {

            selectItem = $('#remove-item-list').val();
            if ( selectItem != -1 ) { // if select an item

                dataString = 'id=' + selectItem;

                $.ajax({
                    type: "POST",
                    url: "../admin/theme/deleteMenuItem",
                    data: dataString,
                    success: function (responseText) {

                        $("span.loading_save").html("");
                        if (responseText === 'db_error') {

                            alert('error');
                        } else if ( responseText === 'deleted' ) {

                            alert('deleted');
                            window.location = $(location).attr('href');
                        }
                    },
                    error: function (data) {
                        $('.alert-error', $('#custom-menu-form')).show();
                    }
                });
            }
        });
    }
    return {
        init: function () {

            // handle nestable
            handleNestable();
            // handle form
            handleCustomMenu();
            handleCategoryMenu();
        }
    }
}();
