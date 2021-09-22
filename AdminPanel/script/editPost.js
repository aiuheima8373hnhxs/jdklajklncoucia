$(function() {
    // Summernote
    $('#textarea').summernote({
        callbacks: {
            onImageUpload: function(files) {
                for (let i = 0; i < files.length; i++) {
                    $.upload(files[i]);
                }
            }
        },
        height: 300,
        lang: 'pl-PL',
    });
    $.upload = function(file) {
        let out = new FormData();
        out.append('file', file, file.name);

        $.ajax({
            method: 'POST',
            url: 'fileUpload.php',
            contentType: false,
            cache: false,
            processData: false,
            data: out,
            success: function(img) {
                console.log('add image: ' + img);
                $('#textarea').summernote('insertImage', img);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus + " " + errorThrown);
            }
        });
    };

    $('#postTypeCheckbox').change(function() {
        if ($(this).is(':checked') == true) {
            $('#postTypeForm').hide();
        } else {
            $('#postTypeForm').show();
        }
    });

    $('#postURLAutoCheckbox').change(function() {
        if ($(this).is(':checked') == true) {
            $('#postURLAutoDiv').hide();
            $('#postURLAutoInput').val('auto');
        } else {
            $('#postURLAutoDiv').show();
        }
    });
});