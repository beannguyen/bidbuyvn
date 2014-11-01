var Products = function() {

    var handleFilter = function() {

        jQuery('#product-status-filter').change(function() {

            var status = $('#product-status-filter :selected').val();
            if ( status !== '-1' )
                window.location = getRootWebSitePath() + "/admin/dashboard/products/status=" + status;
            else
                window.location = getRootWebSitePath() + "/admin/dashboard/products";
        });

        jQuery('#product-archive-filter').change(function() {

            var text = $('#product-archive-filter :selected').text();
            var time = text.split(" ");
            var filterList = 'archive=' + time[0] + '-' + time[1] + '-' + time[2];
            if ( text !== 'Tất cả các ngày' )
                window.location = getRootWebSitePath() + "/admin/dashboard/products/" + filterList;
            else
                window.location = getRootWebSitePath() + "/admin/dashboard/products";
        });

        jQuery('#seller-filter').change(function() {

            var userId = $('#seller-filter :selected').val();
            if ( userId != '' ) {

                window.location = getRootWebSitePath() + "/admin/dashboard/products/seller=" + userId;
            } else {

                window.location = getRootWebSitePath() + "/admin/dashboard/products";
            }
        });
    }
    return {

        init: function() {

            handleFilter();
            /** set value for filter input **/
            // set status filter
            var status = $('#status-selected').val();
            $("#product-status-filter option").filter(function() {

                //may want to use $.trim in here
                return $(this).val() == status;
            }).prop('selected', true);
            // set date time archive filter
            var time = $('#archive-selected').val();
            $('#product-archive-filter option').filter(function() {

                //may want to use $.trim in here
                return $(this).text() == time;
            }).prop('selected', true);
            // set seller filter
            var sellerId = $('#selected_seller').val();
            $('#seller-filter').select2({
                placeholder: "Chọn tên người bán...",
                allowClear: true
            }).select2('val', sellerId);
        }
    }
}();
