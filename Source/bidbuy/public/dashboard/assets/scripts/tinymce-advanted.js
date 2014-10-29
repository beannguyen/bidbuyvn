tinymce.init({
    language : 'vi_VN',
    selector: "textarea.post-content",
    theme: 'modern',
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime youtube table contextmenu paste textcolor autosave"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
    toolbar2: "cut copy paste | fontselect fontsizeselect | link unlink | uploadimage youtube | table | code fullscreen preview",
    content_css : "../public/dashboard/assets/css/tinymce-custom.css",
    convert_urls: false,
    file_browser_callback: function (field_name, url, type, win) {
        if (type == 'image')
        {
            $('#upload-btn').click();
            $('.mce-close').click();
        }
    },
    setup: function(editor) {
        editor.addButton('uploadimage', {
            title : 'Upload Images',
            //text: 'Upload images',
            icon: 'image',
            onclick: function() {
                $('#upload-btn').click();
            }
        });
        editor.on('change', function() {
            tinyMCE.triggerSave();
        });
    }
});