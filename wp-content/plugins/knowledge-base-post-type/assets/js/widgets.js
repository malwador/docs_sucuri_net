(function($) {


    $(document).ready(function() {

        /* Make some options sortable */
        kbg_opt_sortable();

        $(document).on('widget-added', function(e) {
            kbg_opt_sortable();
        });

        $(document).on('widget-updated', function(e) {
            kbg_opt_sortable();
        });

        function kbg_opt_sortable() {
            $(".kbg-widget-content-sortable").sortable({
                revert: false,
                cursor: "move"
            });
        }

    });

})(jQuery);