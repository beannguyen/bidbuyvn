function confirmPendingComment ( id ) {

    $("span.process").html("<img src='"+ getRootWebSitePath() +"/public/dashboard/assets/img/loading.gif'>");

    var datastring = 'comment_id=' + id;
    $.ajax({
        type: "POST",
        url: getRootWebSitePath() + "/admin/post/confirmPendingComment",
        data: datastring,
        success: function (responseText) {

            if (responseText == 1) {

                $("span.process").html("");
                $('.status-item-' + id).text('Đã duyệt');
                $('#confirm-'+ id +'-btn').remove();
            } else {

                $("span.process").html("");
            }
        }
    });
}

function deletePendingComment ( id ) {

    $("span.process").html("<img src='"+ getRootWebSitePath() +"/public/dashboard/assets/img/loading.gif'>");

    var datastring = 'comment_id=' + id;
    $.ajax({
        type: "POST",
        url: getRootWebSitePath() + "/admin/post/deleteComment",
        data: datastring,
        success: function (responseText) {

            if (responseText == 1) {

                $( 'tr#item-'+ id ).remove();
                $("span.process").html("");
            } else {

                $("span.process").html("");
            }
        }
    });
}