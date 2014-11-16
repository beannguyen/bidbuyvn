var FormUserSetting = function () {

    var handleSetting = function () {
        //
        $('#general-setting').validate({
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
                form.submit();
            }
        });

    }

    return {
        //main function to initiate the module
        init: function () {

            handleSetting();

            // Get all levels
            var datastring = '';
            var temp = '';

            $.ajax({
                type: "POST",
                url: "../admin/user/returnAllLevels",
                data: datastring,
                async: false,
                success: function (responseText) {
                    if (responseText != 1) {
                        temp = responseText;
                    }
                }
            });

            var tag = temp.split(', ');
            $(".select2_default_level").select2({
                tags: tag
            });

            var tags1 = temp.split(', ');
            $(".select2_notify_group").select2({
                tags: tags1
            });

            $(".select2_restrict_email").select2({
                tags: [""]
            });

            // handle notify user group
            $('#notify-new-user-enable').click(function() {
                if ($(this).is(':checked')) {
                    $('#notify-group-select').show();
                } else {
                    $('#notify-group-select').hide();
                }
            });
        }

    };

}();