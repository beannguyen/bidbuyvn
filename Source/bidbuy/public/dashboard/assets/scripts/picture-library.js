var PictureLibrary = function () {

    return {

        //main function to initiate the module
        init: function () {

            if (!jQuery().dataTable) {
                return;
            }

            // begin first table
            $('#picture_library').dataTable({
                "aoColumns": [
                    { "bSortable": false },
                    null,
                    { "bSortable": false },
                    null,
                    { "bSortable": false },
                    { "bSortable": false }
                ],
                "aLengthMenu": [
                    [15, 25, 50, -1],
                    [15, 25, 50, "All"] // change per page values here
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

            jQuery('#picture_library .group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                    } else {
                        $(this).attr("checked", false);
                    }
                    $(this).parents('tr').toggleClass("active");
                });
                jQuery.uniform.update(set);

            });

            jQuery('#picture_library tbody tr .checkboxes').change(function(){
                $(this).parents('tr').toggleClass("active");
            });

            jQuery('#picture_library_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
            jQuery('#picture_library_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#picture_library_wrapper .dataTables_length select').select2(); // initialize select2 dropdown

        }

    };

}();