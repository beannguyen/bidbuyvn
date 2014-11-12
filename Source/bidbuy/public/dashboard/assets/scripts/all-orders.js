var Orders = function() {

    var handleFilter = function() {

        jQuery('#orders-archive-filter').change(function() {

            var text = $('#orders-archive-filter :selected').text();
            var rootURL = $('#type-orders').val();
            if ( rootURL === 'seller' )
                rootURL = '/admin/dashboard/ordersforseller/';
            else
                rootURL = '/admin/dashboard/ordersforbuyer/';
            var time = text.split(" ");
            var filterList = 'archive=' + time[0] + '-' + time[1] + '-' + time[2];
            if ( text !== 'Tất cả các ngày' )
                window.location = getRootWebSitePath() + rootURL + filterList;
            else
                window.location = getRootWebSitePath() + rootURL;
        });
    }
    return {

        init: function() {

            handleFilter();
            /** set value for filter input **/
            // set date time archive filter
            var time = $('#archive-selected').val();
            $('#orders-archive-filter option').filter(function() {

                //may want to use $.trim in here
                return $(this).text() == time;
            }).prop('selected', true);
        }
    }
}();
