var SingleProduct = function () {

    var newComment = function () {

        $('#post-comment').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {

                comment_author: {
                    required: true,
                    maxlength: 60
                },

                comment_author_email: {
                    required: true,
                    email: true
                },

                comment_content: {
                    required: true
                }
            },

            messages: { // custom messages for radio buttons and checkboxes

                comment_author: {
                    required: 'Bạn phải nhập Tên',
                    maxlength: 'Tên chỉ được phép dài 60 ký tự'
                },

                comment_author_email: {
                    required: 'Bạn phải nhập địa chỉ email chính xác',
                    email: 'Địa chỉ email không hợp lệ'
                },

                comment_content: {
                    required: 'Bạn phải nhập nội dung'
                }
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

                var comment_author = $('#comment_author').val();
                var comment_author_email = $("#comment_author_email").val();
                var comment_content = $('#comment_content').val();
                var comment_post_ID = $('#post_id').val();

                var datastring = 'comment_post_ID=' + comment_post_ID +'&comment_author=' + comment_author + '&comment_author_email=' + comment_author_email + '&comment_content=' + comment_content;
                $.ajax({
                    type: "POST",
                    url: getRootWebSitePath() + "/admin/post/postComment",
                    data: datastring,
                    success: function (responseText) {
                        //console.log( responseText );
                        if ( responseText != 0 ) {

                            alert('Thành công, vui lòng đợi BQT duyệt bình luận');
                            $('#comment_author').val('');
                            $("#comment_author_email").val('');
                            $('#comment_content').val('');
                        } else {

                            $('#comment_message').val('Xin lỗi, đã có lỗi xảy ra vui lòng thử lại!');
                        }
                    }
                });
            }
        });
    }

    var bidHandle = function () {

        // bid amount must be larger than price + price step
        $.validator.addMethod("validBidAmount", function (value, element) {

            if ( value >= $('#bid_amount_require').val() )
                return true;
            return false;
        }, "Số tiền cháo giá của bạn phải lớn hơn số tiền chúng tôi đề nghị ("+ $('#bid_amount_require').val() +" đ).");

        $('#submit-new-bid').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {

                bid_amount: {
                    required: true,
                    number: true,
                    validBidAmount: true
                }
            },

            messages: { // custom messages for radio buttons and checkboxes

                bid_amount: {
                    required: 'Bạn không được bỏ trống',
                    number: 'Bạn phải nhập gía trị số'
                }
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

    var loadListBid = function () {

        //ajax demo:
        var $modal = $('#ajax-modal');

        $('#ajax-demo').on('click', function() {

            var productId = $('#post_id').val();
            $modal.load( getRootWebSitePath() + '/admin/biding/loadListBid/' + productId).fadeIn('slow');
        });
    }
    return {

        init: function () {

            newComment();
            bidHandle();
            loadListBid();
        }
    }
}();