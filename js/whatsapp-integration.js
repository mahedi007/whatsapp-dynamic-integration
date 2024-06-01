jQuery(document).ready(function($) {
    $('.whatsapp-button').on('click', function() {
        $(this).hide();
        $('#whatsapp-chat-box').show();
    });

    $('#whatsapp-chat-box .close-chat-box').on('click', function() {
        $('#whatsapp-chat-box').hide();
        $('.whatsapp-button').show();
    });

    $('.chat-button').hover(
        function() {
            $('#qr-code-container').show();
        },
        function() {
            $('#qr-code-container').hide();
        }
    );
});
