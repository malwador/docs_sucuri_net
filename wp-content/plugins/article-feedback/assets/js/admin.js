(function($) {

    $(document).ready(function() {
        
        var is_button = $('#af-type-button').prop('checked');
        var label_yes = $('#af-button-yes');
        var label_no = $('#af-button-no');
        var icon_type_smiley = $('#af-type-smiley');
        
        if ( is_button ) {
            label_yes.closest('tr').hide();
            label_no.closest('tr').hide();
            icon_type_smiley.closest('tr').hide();
        }

        $('body').on('change', 'input[name="af_settings[type]"]', function(e) {

            if ( $(this).val() == 'icon' ) {
                label_yes.closest('tr').show();
                label_no.closest('tr').show();
                icon_type_smiley.closest('tr').show();
            } else {
                label_yes.closest('tr').hide();
                label_no.closest('tr').hide();
                icon_type_smiley.closest('tr').hide();
            }

        });
        

    });

})(jQuery);
