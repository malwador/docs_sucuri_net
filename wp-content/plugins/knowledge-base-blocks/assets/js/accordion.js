(function($) {
    $(document).ready(function($) {

        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {

            $("body").on("touchstart", ".kbg-accordion-heading", function(e) {
                kbg_accordion_handle($(this));
            });

        } else {

            $("body:not(.wp-admin)").on("click", ".kbg-accordion-heading", function(e) {
                kbg_accordion_handle($(this));
            });
            $("body.wp-admin").on("click", ".kbg-accordion-heading .kg", function(e) {
                kbg_accordion_handle($(this));
            });

        }



    }); // end $(document).ready()
    
    
    function kbg_accordion_handle($obj) {

        var toggle = $obj.closest('.kbg-faq-item');

        if ( !toggle.hasClass('kbg-accordion-active') ) {

            toggle.addClass('kbg-accordion-active');
            
            toggle.find('.kbg-accordion-content').slideToggle("fast", function() {
                if ((toggle.offset().top + 100) < $(window).scrollTop()) {
                    $('html, body').stop().animate({
                        scrollTop: (toggle.offset().top - 100)
                    }, '300');
                }
            });

        } else {
            
            var multiple_visible = toggle.closest('.wp-block-kbg-accordion').find('.kbg-faq-item').find('.kbg-accordion-content:visible');
            var multipe_active = toggle.closest('.wp-block-kbg-accordion').find('.kbg-accordion-active');
            
            if ( multipe_active.length > 1 ) {
                $obj.closest('.kbg-faq-item').removeClass('kbg-accordion-active');
                $obj.closest('.kbg-faq-item').find('.kbg-accordion-content:visible').slideUp("fast")
            } else {
                multipe_active.removeClass('kbg-accordion-active');
                multiple_visible.slideUp("fast");
            }
        }

    }


})(jQuery);