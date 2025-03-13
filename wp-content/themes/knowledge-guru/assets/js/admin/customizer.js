(function($) {

    "use strict";

    wp.customize('kbg_settings[header_height]', function(value) {
        value.bind(function(newvalue) {
            $('.header-main .header-middle > .container').height(newvalue);
            $('.kbg-header-indent .header-main').css('margin-bottom', -newvalue);
        });
    });

    wp.customize('kbg_settings[header_sticky_height]', function(value) {
        value.bind(function(newvalue) {
            $('.header-sticky-main .header-middle > .container').height(newvalue);
        });
    });


})(jQuery);