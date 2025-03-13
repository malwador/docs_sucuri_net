(function($) {

    "use strict";

    $(document).ready(function() {

        /* Enable/disable slider and sidebar basend on current layout */
        $('body').on('click', '.kbg-opt-layouts img.kbg-img-select', function(e) {
            e.preventDefault();
            var sidebar = parseInt($(this).data('sidebar'));

            if( sidebar ){
                $('.kbg-opt-sidebar').removeClass('kbg-opt-disabled');
            } else {
                $('.kbg-opt-sidebar').addClass('kbg-opt-disabled');
            }

        });


        /* Image upload */
        var meta_image_frame;

        $('body').on('click', '#kbg-image-upload', function(e) {

            e.preventDefault();

            if (meta_image_frame) {
                meta_image_frame.open();
                return;
            }

            meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
                title: 'Choose your image',
                button: {
                    text: 'Set Category image'
                },
                library: {
                    type: 'image'
                }
            });

            meta_image_frame.on('select', function() {

                var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
                $('#kbg-image-url').val(media_attachment.url);
                $('#kbg-image-preview').attr('src', media_attachment.url);
                $('#kbg-image-preview').show();
                $('#kbg-image-clear').show();

            });

            meta_image_frame.open();
        });


        $('body').on('click', '#kbg-image-clear', function(e) {
            $('#kbg-image-preview').hide();
            $('#kbg-image-url').val('');
            $(this).hide();
        });

    });

})(jQuery);