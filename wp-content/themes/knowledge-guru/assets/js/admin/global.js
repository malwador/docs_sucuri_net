(function($) {

    "use strict";

    $(document).ready(function() {

        $("body").on('click', '#kbg_welcome_box_hide', function(e) {
            e.preventDefault();
            $(this).parent().fadeOut(300).remove();
            $.post(ajaxurl, { action: 'kbg_hide_welcome' }, function(response) {});
        });

        $("body").on('click', '#kbg_update_box_hide', function(e) {
            e.preventDefault();
            $(this).parent().remove();
            $.post(ajaxurl, { action: 'kbg_update_version' }, function(response) {});
        });

        $('body').on('click', '.mks-twitter-share-button', function(e) {
            e.preventDefault();
            var data = $(this).attr('data-url');
            kbg_social_share(data);
        });

        $('body').on('click', 'img.kbg-img-select', function(e) {
            e.preventDefault();
            $(this).closest('ul').find('img.kbg-img-select').removeClass('selected');
            $(this).addClass('selected');
            $(this).closest('ul').find('input').removeAttr('checked').prop('checked', false);
            $(this).closest('li').find('input').attr('checked', 'checked').prop('checked', true);
        });

        /* Display options custom/inherit switch */
        $('body').on('click', '.kbg-opt-display input', function(e) {
            var selection = $(this).val();
            if (selection == 'custom') {
                $('.kbg-opt-display-custom').removeClass('kbg-hidden');
            } else {
                $('.kbg-opt-display-custom').addClass('kbg-hidden');
            }

        });


    });

    function kbg_social_share(data) {
        window.open(data, "Share", 'height=500,width=760,top=' + ($(window).height() / 2 - 250) + ', left=' + ($(window).width() / 2 - 380) + 'resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0');
    }

})(jQuery);