function post_slug(str) {
    var datastring = 'string=' + str;
    // console.log(datastring);
    var temp = '';

    $.ajax({
        type: "POST",
        url: getRootWebSitePath() + "/admin/product/product_slug",
        data: datastring,
        async: false,
        success: function (responseText) {

            // console.log(responseText);
            if (responseText != '') {
                temp = responseText;
            }
        }
    });
    return temp;
}

var galleryList = [];
/**
 * remove item from gallery Array when user delete an image
 * @param item
 */
function removeGalleryItem(item) {

    // remove gallery item
    var del = confirm('Bạn có muốn xóa?');
    if (del) {

        galleryList[item] = '';
        $('.group-' + item).remove();
    }
    // check if array is null ( every item is '' )
    var count = 0;
    for (var i = 0; i < galleryList.length; i++) {

        if (galleryList[i] != '')
            count++;
    }
    if (count == 0)
        $('#gallery-status').show();
}

/**
 * check form validation
 * @returns {boolean}
 */
function productValidation()
{
    var error = 0;

    if ( !titleValidation() )
        error++;
    if ( !priceValidation() )
        error++;
    if ( !timeValidation() )
        error++;
    //
    if (error > 0) {

        $('#product_validation .message').text('Có ' + error + ' trường nhập dữ liệu không hợp lệ. Vui lòng nhập lại!');
        $('#product_validation').show();
        return false;
    }
    return true;
}

function titleValidation() {
    var title = $('#product-title').val();
    if (title.length == 0) { // title is empty

        // show message
        $('#titlewrap').addClass('has-error');
        $('#titlewrap .help-block').text('Bạn chưa nhập tiêu đề sản phẩm');
        return false;
    }
    return true;
}

function priceValidation() {
    // price validation
    var price = $('#product_price').val();
    var err = 0;
    var msg = '';
    // price is empty
    if (price === '') {

        msg += 'Bạn chưa nhập giá khởi điểm cho sản phẩm';
        err++;
    } else if ( !isNumeric(price) ) { // price is a string

        msg += 'Giá khỏi điểm phải là số';
        err++;
    }
    // price is zero
    if (parseInt(price) == 0) {

        msg += 'Giá khởi điểm phải lớn hơn 0';
        err++;
    }
    // show error
    if (err > 0) {

        $('#txt_price_wrap').addClass('has-error');
        $('#txt_price_wrap .help-block').text(msg);
        return false;
    }
    return true;
}

function timeValidation()
{
    var day = $('#timeout-day').val();
    var hour = $('#timeout-hour').val();
    var minute = $('#timeout-minute').val();

    var error = 0;
    var msg = '';
    if ( day == 0 && hour == 0 && minute == 0 ) {

        msg = 'Bạn phải đặt thời gian đấu giá cho sản phẩm;';
        error++;
    }
    if ( hour >= 24 ) {

        msg += ' Số giờ phải nhỏ hơn 24h;';
        error++;
    }
    if ( minute >= 60 ) {

        msg += ' Số phút phải nhỏ hơn 60p';
        error++;
    }

    if ( error > 0 ) {

        $('#timeout').addClass('has-error');
        $('#timeout .help-block').text(msg);
        return false;
    }
    return true;
}

var FormDropzone = function () {

    var getGalleryList = function() {

        var productId = $('#product_id').val();
        if ( productId !== '' ) {

            var datastring = 'product_id=' + productId;
            $.ajax({
                type: "POST",
                url: getRootWebSitePath() + "/admin/product/product_gallery",
                data: datastring,
                async: false,
                success: function (responseText) {

                    // console.log(responseText);
                    if (responseText != '') {

                        galleryList = unserialize( responseText );
                    }
                }
            });
        }
    }
    var buttonClickHandle = function () {

        var categoryList = [];
        jQuery('#switch-to-basic-form').click(function () {
            $('.dropzone-form').hide();
            $('.basic-form').show();
        });

        jQuery("#switch-to-dropzone-form").click(function () {
            $('.dropzone-form').show();
            $('.basic-form').hide();
        });

        jQuery('#add-image').click(function () {
            var title = $('#image-title').val();
            var alt = $('#image-alt').val();
            var caption = $('#image-caption').val();
            var alignment = $('#image-align').val();
            var size = $('#image-size').val();
            var width = $('#image-width').val();
            var height = $('#image-height').val();
            var src = $('#image-url').val();

            if ($('#set-feature-image-checker').is(":checked")) {

                $('#set-feature-image-btn').hide();
                document.getElementById('feature-view').innerHTML = "<img src='" + src + "' width='245' />";
                $('#remove-feature-image-btn').show();

                $('#feature-url').val(src);
            } else {

                var width1 = width;
                var height1 = height;
                // resize
                if (size == 1) {
                    width1 = Math.ceil(width / 2);
                    height1 = Math.ceil(height / 2);
                } else if (size == 'thumb') {
                    width1 = 150;
                    height1 = 150;
                } else if (size == 2) {
                    width1 = Math.ceil(width / 3);
                    height1 = Math.ceil(height / 3);
                }
                var code = "<img src='" + src + "' title='" + title + "' alt='" + alt + " width='" + width1 + "' height='" + height1 + "'";
                if (alignment == 'center' && caption.length == 0)
                    code += " style='display: block; margin-left: auto; margin-right: auto;' />";
                else
                    code += "' />";

                if (caption.length > 0) {
                    var code = "<table align='" + alignment + "' style='background-color: darkgray; font-style: italic'>"
                        + "<tbody>"
                        + "<tr><td>" + code + "</td></tr>"
                        + "<tr><td align='center'>" + caption + "</td></tr>"
                        + "</tbody>"
                        + "</table>";
                }
                // insert to content
                tinyMCE.activeEditor.insertContent(code);
            }

            // close modal
            $('.btn-close-modal').click();
        });

        jQuery('#remove-feature-image-btn').click(function () {

            $('#remove-feature-image-btn').hide();
            document.getElementById('feature-view').innerHTML = "";
            $('#set-feature-image-btn').show();
        });

        jQuery('#product_price').focusout(function() {

            // get product price
            var price = $('#product_price').val();
            if ( price !== '' ) {

                // get pricing step and insert into textbox
                var datastring = 'price=' + price;
                $.ajax({
                    type: "POST",
                    url: getRootWebSitePath() + "/admin/product/suggestPricingStep",
                    data: datastring,
                    async: false,
                    success: function (responseText) {

                        //console.log(responseText);
                        if (responseText != '') {

                            var pricingStep = JSON.parse( responseText );
                            // set value
                            $('#product_price_step').val( pricingStep.step );
                        }
                    }
                });
            }
        });

        jQuery('#active-pending-product').click(function () {

            var res = confirm('Bạn có chắc muốn kích hoạt sản phẩm này?');
            if ( res ) {

                // get product price
                var productId = $('#active-pending-product').attr('data-action');
                var datastring = "product_id=" + productId;
                $.ajax({
                    type: "POST",
                    url: getRootWebSitePath() + "/admin/product/activePendingProduct",
                    data: datastring,
                    async: false,
                    success: function (responseText) {

                        //console.log(responseText);
                        if (responseText == 'changed') {

                            alert('Đã kích hoạt thành công');
                            window.location = $(location).attr('href');
                        } else
                            alert('Đã xảy ra lỗi, vui lòng thử lại');
                    }
                });
            }
        })

        jQuery('#Publish').click(function () {

            // form validation
            if ( !productValidation() ) {
                return false;
            }

            // the title
            var title = $('#product-title').val();

            // product description
            var productDescription = tinyMCE.activeEditor.getContent();

            // validation product price
            var price = $('#product_price').val();

            // timeout for this product
            var timeout = [$('#timeout-day').val(), $('#timeout-hour').val(), $('#timeout-minute').val()];
            var time = serialize(timeout);

            // repair gallery array
            for (var i = 0; i < galleryList.length; i++) {

                if (galleryList[i] === '') { // if this item was removed

                    for (var j = i; j < galleryList.length - 1; j++) {

                        galleryList[j] = galleryList[j + 1];
                    }
                    galleryList.length--;
                    i--;
                }
            }

            // create new form
            $('div#PublishForm').append(
                $('<form />', {
                    action: getRootWebSitePath() + '/admin/product/insert',
                    method: 'post',
                    id: "main-new-product-form"
                }).append(
                        $("<input/>", {
                            type: 'text',
                            id: 'input-product-title',
                            name: 'input-product-title',
                            value: title
                        }),
                        $("<input/>", {
                            type: 'text',
                            id: 'input-product-description',
                            name: 'input-product-description',
                            value: productDescription
                        }),
                        $("<input/>", {
                            type: 'text',
                            id: 'input-product-category',
                            name: 'input-product-category',
                            value: categoryList[1]
                        }),
                        $("<input/>", {
                            type: 'text',
                            id: 'input-feature-url',
                            name: 'input-feature-url',
                            value: $('#feature-url').val()
                        }),
                        $("<input/>", {
                            type: 'text',
                            id: 'input-product-status',
                            name: 'input-product-status',
                            value: 'pending'
                        }),
                        $("<input />", {
                            type: 'text',
                            id: 'input-product-sku',
                            name: 'input-product-sku',
                            value: $('#product_sku').val()
                        }),
                        $("<input />", {
                            type: 'text',
                            id: 'input-product-price',
                            name: 'input-product-price',
                            value: price
                        }),
                        $("<input />", {
                            type: 'text',
                            id: 'input-product-price-step',
                            name: 'input-product-price-step',
                            value: $('#product_price_step').val()
                        }),
                        $("<input />", {
                            type: 'text',
                            id: 'input-product-timeout',
                            name: 'input-product-timeout',
                            value: time
                        }),
                        $("<input />", {
                            type: 'text',
                            id: 'input-product-gallery',
                            name: 'input-product-gallery',
                            value: serialize(galleryList)
                        }),
                        $("<input/>", {
                            type: 'text',
                            id: 'input-product-type',
                            name: 'input-product-type',
                            value: 'product'
                        })
                    )
            );
            // submit the form
            $('#main-new-product-form').submit();
        });

        jQuery('#Update').click(function () {

            // form validation
            if ( !productValidation() ) {
                return false;
            }

            // the title
            var title = $('#product-title').val();

            // product description
            var productDescription = tinyMCE.activeEditor.getContent();

            // validation product price
            var price = $('#product_price').val();

            // timeout for this product
            var timeout = [$('#timeout-day').val(), $('#timeout-hour').val(), $('#timeout-minute').val()];
            var time = serialize(timeout);

            // repair gallery array
            for (var i = 0; i < galleryList.length; i++) {

                if (galleryList[i] === '') { // if this item was removed

                    for (var j = i; j < galleryList.length - 1; j++) {

                        galleryList[j] = galleryList[j + 1];
                    }
                    galleryList.length--;
                    i--;
                }
            }

            // create new form
            $('div#UpdateForm').append(
                $('<form />', {
                    action: getRootWebSitePath() + '/admin/product/update',
                    method: 'post',
                    id: "main-update-product-form"
                }).append(
                        $("<input/>", {
                            type: 'text',
                            id: 'input-product-title',
                            name: 'input-product-title',
                            value: title
                        }),
                        $("<input/>", {
                            type: 'text',
                            id: 'input-product-description',
                            name: 'input-product-description',
                            value: productDescription
                        }),
                        $("<input/>", {
                            type: 'text',
                            id: 'input-product-category',
                            name: 'input-product-category',
                            value: $('#categorychecklist input:checked').val()
                        }),
                        $("<input/>", {
                            type: 'text',
                            id: 'input-feature-url',
                            name: 'input-feature-url',
                            value: $('#feature-url').val()
                        }),
                        $("<input/>", {
                            type: 'text',
                            id: 'input-permalink-url',
                            name: 'input-permalink-url',
                            value: $('#permalink').text()
                        }),
                        $("<input />", {
                            type: 'text',
                            id: 'input-product-sku',
                            name: 'input-product-sku',
                            value: $('#product_sku').val()
                        }),
                        $("<input />", {
                            type: 'text',
                            id: 'input-product-price',
                            name: 'input-product-price',
                            value: price
                        }),
                        $("<input />", {
                            type: 'text',
                            id: 'input-product-price-step',
                            name: 'input-product-price-step',
                            value: $('#product_price_step').val()
                        }),
                        $("<input />", {
                            type: 'text',
                            id: 'input-product-timeout',
                            name: 'input-product-timeout',
                            value: time
                        }),
                        $("<input />", {
                            type: 'text',
                            id: 'input-product-gallery',
                            name: 'input-product-gallery',
                            value: serialize(galleryList)
                        }),
                        $("<input/>", {
                            type: 'text',
                            id: 'input-product-type',
                            name: 'input-product-type',
                            value: 'product'
                        }),
                        $("<input/>", {
                            type: 'text',
                            id: 'input-product-id',
                            name: 'input-product-id',
                            value: $('#product_id').val()
                        })
                    )
            );
            // submit the form
            $('#main-update-product-form').submit();
        });

        jQuery('#titlewrap').focusout(function () {

            if ( titleValidation() ) {

                $('#titlewrap').removeClass('has-error');
                $('#titlewrap .help-block').text('');
                if ( productValidation() ) {

                    $('#product_validation').hide();
                }
            }
        });

        jQuery('#txt_price_wrap').focusout(function () {

            if ( priceValidation() ) {

                $('#txt_price_wrap').removeClass('has-error');
                $('#txt_price_wrap .help-block').text('');
                if ( productValidation() ) {

                    $('#product_validation').hide();
                }
            }
        });

        jQuery('#timeout').focusout( function() {

            if ( timeValidation() ) {

                $('#timeout').removeClass('has-error');
                $('#timeout .help-block').text('');
                if ( productValidation() ) {

                    $('#product_validation').hide();
                }
            }
        })

        jQuery('.categorychecklist').click(function () {

            if ($('.categorychecklist').is(':checked')) {

                var checked = $('#categorychecklist input:checked').val();
                if (checked != null)
                    var oldCategory = checked;
                else
                    var oldCategory = 0;
                $('#in-category-' + oldCategory).click();
                var newCategory = $(this).val();
                $('#in-category-' + newCategory).click();
                categoryList[1] = newCategory;
            }
        });

        jQuery('.delete-post-btn').click(function () {

            var res = confirm('Bạn có chắc muốn xóa sản phẩm này?');
            if ( res ) {

                var productId = $('#product_id').val();
                var dataString = 'product_id=' + productId;

                $.ajax({
                    type: "POST",
                    url: getRootWebSitePath() + "/admin/product/move_to_trash",
                    data: dataString,
                    async: false,
                    success: function (responseText) {

                        if (responseText == '1') {
                            window.location = getRootWebSitePath() + '/admin/products';
                        }
                    }
                });
            }
        });

        jQuery('.save-draft-btn').click(function () {

            // form validation
            if ( !productValidation() ) {
                return false;
            }

            // the title
            var title = $('#product-title').val();

            // product description
            var productDescription = tinyMCE.activeEditor.getContent();

            // validation product price
            var price = $('#product_price').val();

            // timeout for this product
            var timeout = [$('#timeout-day').val(), $('#timeout-hour').val(), $('#timeout-minute').val()];
            var time = serialize(timeout);

            // repair gallery array
            for (var i = 0; i < galleryList.length; i++) {

                if (galleryList[i] === '') { // if this item was removed

                    for (var j = i; j < galleryList.length - 1; j++) {

                        galleryList[j] = galleryList[j + 1];
                    }
                    galleryList.length--;
                    i--;
                }
            }

            // create new form
            $('div#PublishForm').append(
                $('<form />', {
                    action: getRootWebSitePath() + '/admin/product/insert',
                    method: 'post',
                    id: "main-new-product-form"
                }).append(
                        $("<input/>", {
                            type: 'text',
                            id: 'input-product-title',
                            name: 'input-product-title',
                            value: title
                        }),
                        $("<input/>", {
                            type: 'text',
                            id: 'input-product-description',
                            name: 'input-product-description',
                            value: productDescription
                        }),
                        $("<input/>", {
                            type: 'text',
                            id: 'input-product-category',
                            name: 'input-product-category',
                            value: categoryList[1]
                        }),
                        $("<input/>", {
                            type: 'text',
                            id: 'input-feature-url',
                            name: 'input-feature-url',
                            value: $('#feature-url').val()
                        }),
                        $("<input/>", {
                            type: 'text',
                            id: 'input-product-status',
                            name: 'input-product-status',
                            value: 'draft'
                        }),
                        $("<input />", {
                            type: 'text',
                            id: 'input-product-sku',
                            name: 'input-product-sku',
                            value: $('#product_sku').val()
                        }),
                        $("<input />", {
                            type: 'text',
                            id: 'input-product-price',
                            name: 'input-product-price',
                            value: price
                        }),
                        $("<input />", {
                            type: 'text',
                            id: 'input-product-price-step',
                            name: 'input-product-price-step',
                            value: $('#product_price_step').val()
                        }),
                        $("<input />", {
                            type: 'text',
                            id: 'input-product-timeout',
                            name: 'input-product-timeout',
                            value: time
                        }),
                        $("<input />", {
                            type: 'text',
                            id: 'input-product-gallery',
                            name: 'input-product-gallery',
                            value: serialize(galleryList)
                        }),
                        $("<input/>", {
                            type: 'text',
                            id: 'input-product-type',
                            name: 'input-product-type',
                            value: 'product'
                        })
                    )
            );
            // submit the form
            $('#main-new-product-form').submit();
        });

        // ajax submit form to upload image to gallery
        $("#uploadForm").on('submit', ( function (e) {

            e.preventDefault();
            $("span.loading").html("<img src='" + getRootWebSitePath() + "'/public/dashboard/assets/img/loading.gif'>");
            $.ajax({
                url: getRootWebSitePath() + "/admin/upload/addGallery",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {

                    $("span.loading").html("");
                    if (data === 'error') {

                        alert('Bạn đang cố tải lên file không được cho phép!');
                        $('#upload-file').val('');
                    } else {

                        var data = JSON.parse(data);
                        $('#gallery-status').hide();
                        $("#gallery-output").append(

                            $('<div />', {
                                id: 'gallery-item',
                                class: 'row group-' + galleryList.length
                            }).append(

                                    $('<div />', {
                                        class: 'col-md-2'
                                    }).append(
                                            $('<img />', {
                                                src: data.src,
                                                class: 'img'
                                            })
                                        ),

                                    $('<div />', {
                                        id: 'input',
                                        class: 'form-group col-md-6'
                                    }).append(
                                            $('<input />', {
                                                id: 'item-' + galleryList.length,
                                                class: 'form-control input-xlarge',
                                                value: data.url,
                                                disabled: 'disabled'
                                            }),
                                            ('<button id="delete-gallery-item" class="btn btn-xs red" onClick="removeGalleryItem(' + galleryList.length + ')"><i class="icon-remove"></i> Xóa</button>')
                                        )
                                )
                        );
                        galleryList.push(data.url);
                        $('#upload-file').val('');
                    }
                },
                error: function () {
                }
            });
        }));
    }
    var dropzoneHandle = function () {
        Dropzone.options.myDropzone = {
            paramName: "file",
            maxFilesize: 2,
            acceptedFiles: "image/jpg, image/png, image/jpeg",
            fallback: function () {
                $('.dropzone-form').hide();
                $('.basic-form').show();
            },
            init: function () {
                this.on("addedfile", function (file) {
                    // Create the remove button
                    var removeButton = Dropzone.createElement("<button class='btn btn-sm btn-block'>Xóa ảnh</button>");

                    // Capture the Dropzone instance as closure.
                    var _this = this;

                    // Listen to the click event
                    removeButton.addEventListener("click", function (e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();

                        // Remove the file preview.
                        _this.removeFile(file);
                        // If you want to the delete the file on the server as well,
                        // you can do the AJAX request here.
                    });

                    // Add the button to the file preview element.
                    file.previewElement.appendChild(removeButton);
                });
                this.on("success", function (file, response) {

                    console.log(response);
                    var editButton = Dropzone.createElement("<button class='btn btn-sn btn-block'>Thêm vào</button>");

                    editButton.addEventListener("click", function (e) {

                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();

                        var src = response;
                        var name = file.name;
                        var title = name.split('.')[0];
                        var width = file.width;
                        var height = file.height;

                        $('#image-title').val(title);
                        $('#image-width').val(width);
                        $('#image-height').val(height);
                        $('#image-url').val(src);

                        // close modal
                        $('.btn-close-modal').click();
                        // popup new modal
                        $('#edit-image-btn').click();
                    });

                    file.previewElement.appendChild(editButton);
                });
            }
        }
    }
    var initAjaxMock = function () {
        //ajax mocks

        $.mockjax({
            url: '/post',
            response: function (settings) {
                //log(settings, this);
            }
        });

        $.mockjax({
            url: '/error',
            status: 400,
            statusText: 'Bad Request',
            response: function (settings) {
                this.responseText = 'Please input correct value';
                ///log(settings, this);
            }
        });

        $.mockjax({
            url: '/status',
            status: 500,
            response: function (settings) {
                this.responseText = 'Internal Server Error';
                //log(settings, this);
            }
        });

        $.mockjax({
            url: '/groups',
            response: function (settings) {
                this.responseText = [
                    {
                        value: 0,
                        text: 'Guest'
                    },
                    {
                        value: 1,
                        text: 'Service'
                    },
                    {
                        value: 2,
                        text: 'Customer'
                    },
                    {
                        value: 3,
                        text: 'Operator'
                    },
                    {
                        value: 4,
                        text: 'Support'
                    },
                    {
                        value: 5,
                        text: 'Admin'
                    }
                ];
                //log(settings, this);
            }
        });

    }
    var initEditables = function () {

        //set editable mode based on URL parameter
        if (App.getURLParameter('mode') == 'inline') {
            $.fn.editable.defaults.mode = 'inline';
            $('#inline').attr("checked", true);
            jQuery.uniform.update('#inline');
        } else {
            $('#inline').attr("checked", false);
            jQuery.uniform.update('#inline');
        }

        //global settings
        $.fn.editable.defaults.inputclass = 'form-control';
        $.fn.editable.defaults.url = '/post';

        //editables element samples
        $('#permalink').editable({
            url: '/post',
            type: 'text',
            pk: 1,
            name: 'permalink',
            title: 'Permalink',
            display: function (value) {
                $(this).text(post_slug(value));
            }
        });
    }
    var handleTagsInput = function () {
        if (!jQuery().tagsInput) {
            return;
        }
        $('#tags').tagsInput({
            width: 'auto'
        });
    }
    return {
        //main function to initiate the module

        init: function () {

            $("#box-category").niceScroll();
            getGalleryList();
            buttonClickHandle();
            dropzoneHandle();
            initAjaxMock();
            initEditables();
            handleTagsInput();
        }
    };
}();