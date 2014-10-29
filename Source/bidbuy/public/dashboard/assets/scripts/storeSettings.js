var StoreSettings = function() {

    var findLastedPricingStep = function() {

        var dataString = "";
        var result = false;
        $.ajax({
            type: "POST",
            url: getRootWebSitePath() + "/admin/product/findLastedPricingStep",
            data: dataString,
            async: false,
            success: function (responseText) {

                console.log( responseText );
                if ( responseText === 'found' ) {

                    result = true;
                }
            },
            error: function (data) {}
        });

        return result;
    }

    var handleButtonClick = function() {

        jQuery('#create-new-price-step').click(function() {

            // find lasted step
            if ( findLastedPricingStep() == true ) {

                // disable all input
                $("#larger_number").prop('disabled', true);
                $("#pricing_step").prop('disabled', true);
                $("#submit_pricing_step").prop('disabled', true);
                // show error
                $('#add_pricing_step_error li').remove()
                $('#add_pricing_step_error ul').append(

                    ('<li>Vui lòng chỉnh sửa bước giá cuối trước khi thêm mới</li>')
                );

                $('#add_pricing_step_error').show().fadeIn();
                return false;
            }

            // enable all input
            $("#smaller_number").prop('disabled', false);
            $("#larger_number").prop('disabled', false);
            $("#pricing_step").prop('disabled', false);
            $("#submit_pricing_step").prop('disabled', false);

            // suggest smaller number
            var dataString = "";
            $.ajax({
                type: "POST",
                url: getRootWebSitePath() + "/admin/product/suggestSmallNumber",
                data: dataString,
                success: function (responseText) {

                    $("#smaller_number").val(responseText);
                    $('#type-action').val('create');
                    $("#smaller_number").prop('disabled', true);
                },
                error: function (data) {
                    $("#smaller_number").prop('disabled', false);
                }
            });
        });

        var pricingStepList = [];
        jQuery('.select-step').click(function () {

            if ($('.select-step').is(':checked')) {

                var checked = $('#steps-list input:checked').val();
                if (checked != null)
                    var oldCategory = checked;
                else
                    var oldCategory = 0;
                $('#choose-step-' + oldCategory).click();
                var newCategory = $(this).val();
                $('#choose-step-' + newCategory).click();
                pricingStepList[1] = newCategory;
            }
        });

        jQuery('#edit-pricing-step').click(function() {

            // get step id
            var stepId = pricingStepList[1];
            // get information
            var dataString = 'step_id=' + stepId;
            $.ajax({
                type: "POST",
                url: getRootWebSitePath() + "/admin/product/getPricingStepDetail",
                data: dataString,
                success: function (responseText) {

                    if ( responseText === 'not-found' ) {

                        // show error
                        $('#add_pricing_step_error li').remove()
                        $('#add_pricing_step_error ul').append(

                            ('<li>Hệ thống đã xảy ra lỗi hoặc không tìm thấy bước giá, vui lòng Refresh trang và thử lại</li>')
                        );

                        $('#add_pricing_step_error').show().fadeIn();
                    } else {

                        // convert response text to json format
                        var data = JSON.parse( responseText );
                        // put data to form
                        $('#smaller_number').val( data.min );
                        $('#larger_number').val( data.max );
                        $('#pricing_step').val( data.step );
                        $('#type-action').val('edit');
                        $('#step-stt').val( data.stt );
                        $('#step-id').val( data.ID );
                        $('#submit_pricing_step').text('Sửa');
                        // enable all input
                        // if this is first step, the smaller number can not edit
                        if ( data.min != 0 ) {

                            $("#smaller_number").prop('disabled', false);
                        }
                        $("#larger_number").prop('disabled', false);
                        $("#pricing_step").prop('disabled', false);
                        $("#submit_pricing_step").prop('disabled', false);
                        $('.select-step').prop('disabled', true);
                    }
                },
                error: function (data) {

                }
            });
        });

        jQuery('#delete-pricing-step').click(function() {

            var res = confirm('Bạn có muốn xóa?');
            if ( res ) { // say yeah

                $("span.loading").html("<img src='"+ getRootWebSitePath() +"/public/dashboard/assets/img/loading.gif'>");
                // get step id
                var stepId = pricingStepList[1];
                // get information
                var dataString = 'step_id=' + stepId;
                $.ajax({
                    type: "POST",
                    url: getRootWebSitePath() + "/admin/product/deletePricingStep",
                    data: dataString,
                    success: function (responseText) {

                        console.log( responseText );
                        if ( responseText === 'deleted' ) {

                            setTimeout(function() {

                                window.location = $(location).attr('href');
                            }, 1000);
                        } else if ( responseText === 'error' ) {

                            $("span.loading").html("");
                            // show error
                            var msg = ["Xảy ra lỗi, vui lòng thử lại!"];
                            $('#add_pricing_step_error ul').append(

                                ('<li>'+ msg[i] +'</li>')
                            );
                            $('#add_pricing_step_error').show().fadeIn();
                        }
                    },
                    error: function (data) {

                    }
                });
            }
        });
    }

    var handleCreatePricingStepForm = function () {

        $('#submit_pricing_step').click(function() {

            var smallerNumber = $('#smaller_number').val();
            var largerNumber = $('#larger_number').val();
            var pricingStep = $('#pricing_step').val();
            var type = $('#type-action').val();

            // form validation
            var msg = [];

            if ( smallerNumber === '' ) {

                msg.push("Bạn chưa nhập mức giá dưới");
            } else {

                if ( !isNumeric( smallerNumber ) ) {

                    msg.push("Bạn phải nhập số");
                } else if ( parseInt(smallerNumber) < 0 ) {

                    msg.push("Bạn phải nhập giá trị dương");
                }
            }

            if ( largerNumber === '' ) {

                msg.push("Bạn chưa nhập mức giá trên");
            } else if ( largerNumber !== '-8' ) {

                if ( !isNumeric( largerNumber ) ) {

                    msg.push("Bạn phải nhập số");
                } else if ( parseInt( largerNumber ) < 0 ) {

                    msg.push("Bạn phải nhập giá trị dương");
                }

                if ( parseInt( largerNumber ) <= parseInt( smallerNumber ) ) {

                    msg.push("Mức giá trên và dưới không hợp lệ");
                }
            }

            if ( pricingStep === '' ) {

                msg.push("Bạn phải nhập bước giá");
            } else {

                if ( !isNumeric( pricingStep ) ) {

                    msg.push("Bạn phải nhập số");
                } else if ( parseInt( pricingStep ) < 0 ) {

                    msg.push("Bạn phải nhập giá trị dương");
                }

                if ( largerNumber !== '-8' && parseInt(pricingStep) > parseInt(largerNumber) ) {

                    msg.push("Bước giá không thể lớn hơn mức giá trên");
                }
            }

            // show the error
            if ( msg.length > 0 ) {

                $('#add_pricing_step_error li').remove()
                for ( var i = 0; i < msg.length; i++ ) {


                    $('#add_pricing_step_error ul').append(

                        ('<li>'+ msg[i] +'</li>')
                    );
                }

                $('#add_pricing_step_error').show().fadeIn();
                msg = [];
            } else {

                // hide error message
                $('#add_pricing_step_error').hide();

                if ( type === 'create' ) {

                    // submit form
                    $("span.loading").html("<img src='"+ getRootWebSitePath() +"/public/dashboard/assets/img/loading.gif'>");
                    var dataString = "smaller=" + smallerNumber + "&larger=" + largerNumber + "&step=" + pricingStep;

                    $.ajax({
                        type: "POST",
                        url: getRootWebSitePath() + "/admin/product/addPricingStep",
                        data: dataString,
                        success: function (responseText) {

                            if ( responseText === 'error' ) {

                                $("span.loading").html("");
                                msg = ["Xảy ra lỗi, vui lòng thử lại!"];
                                $('#add_pricing_step_error ul').append(

                                    ('<li>'+ msg[i] +'</li>')
                                );
                                $('#add_pricing_step_error').show().fadeIn();
                            } else {

                                $('#steps-list tbody').append(

                                    $('<tr />').append(

                                        ('<td><div class="checker"><span><input type="checkbox" id="choose-step-' + responseText + '" class="checkboxes select-step" value="' + responseText + '" /></span></div></td>'),
                                        ('<td>' + $('#steps-list tr').length + '</td>'),
                                        ('<td class="numberic">'+ smallerNumber +'</td>'),
                                        ('<td class="numberic">' + largerNumber + '</td>'),
                                        ('<td class="numberic">' + pricingStep + '</td>')
                                    )
                                );

                                // clear all data input
                                $('#smaller_number').val('');
                                $('#larger_number').val('');
                                $('#pricing_step').val('');
                                // disable form
                                $("#smaller_number").prop('disabled', true);
                                $("#larger_number").prop('disabled', true);
                                $("#pricing_step").prop('disabled', true);
                                $("#submit_pricing_step").prop('disabled', true);
                                $("span.loading").html("");
                            }
                        },
                        error: function (data) {

                        }
                    })
                } else if ( type == 'edit' ) {

                    var stt = $('#step-stt').val();
                    var id = $('#step-id').val();

                    $("span.loading").html("<img src='"+ getRootWebSitePath() +"/public/dashboard/assets/img/loading.gif'>");
                    var dataString = "id=" + id + "&stt=" + stt + "&min=" + smallerNumber + "&max=" + largerNumber + "&step=" + pricingStep;

                    $.ajax({
                        type: "POST",
                        url: getRootWebSitePath() + "/admin/product/updatePricingStep",
                        data: dataString,
                        async: false,
                        success: function (responseText) {

                            if ( responseText === 'updated' ) {

                                $('#update-success').show();
                                setTimeout(function() {

                                    window.location = $(location).attr('href');
                                }, 1000);
                            } else if ( responseText === 'error' ) {

                                $("span.loading").html("");
                                msg = ["Xảy ra lỗi, vui lòng thử lại!"];
                                $('#add_pricing_step_error ul').append(

                                    ('<li>'+ msg[i] +'</li>')
                                );
                                $('#add_pricing_step_error').show().fadeIn();
                            }
                        },
                        error: function (data) {}
                    });
                }

            }
        });
    }
    return {
        //main function to initiate the module
        init: function () {

            handleButtonClick();
            handleCreatePricingStepForm();
        }
    };
}();