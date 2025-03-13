(function($) {

    "use strict";

    var af_app = {

        settings: {},

        init: function() {

            this.rate();
        },

        rate: function() {

            /* Knowledge base rate */
            $('.af-kb-rate').on('click', '.af-yes, .af-no', function(e) {

                var answer = $(this).attr('data-answer');
                var container_wrapper = $(this).closest('.af-kb-rate-wrapper');
                var container = $(this).closest('.af-kb-rate');

                $.ajax({

                    url: af_js_settings.ajax_url,
                    method: 'POST',
                    data: {
                        action: 'af_rate',
                        answer: answer,
                        id: af_js_settings.current_ID
                    }

                }).done(function(response) {

                    if (true === response.success) {
                        var output = JSON.parse(response.data);
                        container_wrapper.addClass('af-fade');
                        container.prepend("<div class='af-message'>"+output+"</div>");
                        container.fadeIn(300);
                    }

                });

            });
        },

    };

    $(document).ready(function() {
        af_app.init();
    });


})(jQuery);
