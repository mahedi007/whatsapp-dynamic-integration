jQuery(document).ready(function($) {
    $('#upload_qr_code_button').click(function(e) {
        e.preventDefault();
        var custom_uploader = wp.media({
            title: 'Upload QR Code',
            button: {
                text: 'Upload'
            },
            multiple: false
        });

        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#whatsapp_qr_code_url').val(attachment.url);
        });

        custom_uploader.open();
    });
});
