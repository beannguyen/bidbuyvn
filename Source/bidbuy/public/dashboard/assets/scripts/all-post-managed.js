var AllPostManaged = function () {
    var tableHandle = function () {
        // begin second table
        $('#all_post_manager').dataTable({
            "aLengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "iDisplayLength": 5,
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

        jQuery('#all_post_manager .group-checkable').change(function () {
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
        });

        jQuery('#all_post_manager_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
        jQuery('#all_post_manager_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
        jQuery('#all_post_manager_wrapper .dataTables_length select').select2(); // initialize select2 dropdown
    }
    var buttonClickHandle = function() {
    }
    return {
        init: function () {
            tableHandle();
        }
    }
}();