var ThemeOptions = function () {

    var handleMultiSelect = function () {
        $('#home_box_multi_select').multiSelect();
    }

    return {
        init: function() {
            handleMultiSelect();
        }
    };
}();