(function($) {

    "use strict";

    $(document).ready(function() {

        /* Metabox switch - do not show every metabox for every template */

        var kbg_is_gutenberg = typeof wp.apiFetch !== 'undefined';
        var kbg_template_selector = kbg_is_gutenberg ? '.editor-page-attributes__template select' : '#page_template';

        if (kbg_is_gutenberg) {

            var post_id = $('#post_ID').val();
            wp.apiFetch({ path: '/wp/v2/pages/' + post_id, method: 'GET' }).then(function(obj) {
                kbg_template_metaboxes(obj.template);
            });

        } else {
            kbg_template_metaboxes(false);
        }

        $('body').on('change', kbg_template_selector, function(e) {
            kbg_template_metaboxes(false);
        });

        // WP 5.8 support
        $('body').on('change', 'select.components-select-control__input', function(e) {
            kbg_template_metaboxes( this.value );
        });

        function kbg_template_metaboxes(t) {

            var template = t ? t : $(kbg_template_selector).val();

            if (template == 'template-blank.php' || template == 'template-shows.php' || template == 'template-episodes.php' ) {
                $('#kbg_page_display').fadeOut(300);
                $('#kbg_page_authors').fadeOut(300);
            } else if ( template == 'template-authors.php' ) {
                $('#kbg_page_display').fadeIn(300);
                $('#kbg_page_authors').fadeIn(300);
            } else {
                $('#kbg_page_display').fadeIn(300);
                $('#kbg_page_authors').fadeOut(300);
            }

            if ( template == '' ) {
                $('body').removeClass('template-knowledge-base-blocks').addClass('page-template-default');
            }

            if ( template == 'template-knowledge-base-blocks.php' ) {
                $('body').removeClass('page-template-default').addClass('template-knowledge-base-blocks');
            }

        }

    });
})(jQuery);