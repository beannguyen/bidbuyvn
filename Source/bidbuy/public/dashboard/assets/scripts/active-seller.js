var ActivationSeller = function () {

    return {

        //main function to initiate the module
        init: function () {

            if (!jQuery().dataTable) {
                return;
            }

            // begin first table
            $('#all_user_manager').dataTable({

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

            jQuery('#all_user_manager_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
            jQuery('#all_user_manager_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#all_user_manager_wrapper .dataTables_length select').select2(); // initialize select2 dropdown
            $("#all_user_manager_filter").css({ float: "right" });

            handleSubmitForm();
        }
    };
}();