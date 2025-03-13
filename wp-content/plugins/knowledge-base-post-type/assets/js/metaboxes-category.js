(function($) {

    "use strict";

    $(document).ready(function() {

        /* Image upload */
        var meta_image_frame;
        var meta_icon_frame;

        $('body').on('click', '#kbg-buddy-image-upload', function(e) {

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
                $('#kbg-buddy-image-url').val(media_attachment.url);
                $('#kbg-buddy-image-preview').attr('src', media_attachment.url);
                $('#kbg-buddy-image-preview').show();
                $('#kbg-buddy-image-clear').show();

            });

            meta_image_frame.open();
        });

        $('body').on('click', '#kbg-buddy-icon-upload', function(e) {

            e.preventDefault();

            if (meta_icon_frame) {
                meta_icon_frame.open();
                return;
            }

            meta_icon_frame = wp.media.frames.meta_icon_frame = wp.media({
                title: 'Choose your icon',
                button: {
                    text: 'Set Category icon'
                },
                library: {
                    type: 'image'
                }
            });

            meta_icon_frame.on('select', function() {

                var media_attachment = meta_icon_frame.state().get('selection').first().toJSON();
                $('#kbg-buddy-icon-url').val(media_attachment.url);
                $('#kbg-buddy-icon-preview').attr('src', media_attachment.url);
                $('#kbg-buddy-icon-preview').show();
                $('#kbg-buddy-icon-clear').show();

            });

            meta_icon_frame.open();
        });


        $('body').on('click', '#kbg-buddy-image-clear', function(e) {
            $('#kbg-buddy-image-preview').hide();
            $('#kbg-buddy-image-url').val('');
            $(this).hide();
        });

        $('body').on('click', '#kbg-buddy-icon-clear', function(e) {
            $('#kbg-buddy-icon-preview').hide();
            $('#kbg-buddy-icon-url').val('');
            $(this).hide();
        });

    });

})(jQuery);