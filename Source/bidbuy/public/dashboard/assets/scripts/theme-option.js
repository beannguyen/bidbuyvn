var ThemeOptions = function () {

    var handleButtonClick = function() {

        jQuery('#slider_form_submit_1').click(function () {

            $('#slider_1_form').submit();
        });

        jQuery('#slider_form_submit_2').click(function () {

            $('#slider_2_form').submit();
        });

        jQuery('#slider_form_submit_3').click(function () {

            $('#slider_3_form').submit();
        });

        jQuery('#slider_form_submit_4').click(function () {

            $('#slider_4_form').submit();
        });

        jQuery('#slider_form_submit_5').click(function () {

            $('#slider_5_form').submit();
        });
    }

    return {
        init: function() {

            handleButtonClick();
        }
    };
}();