(function($) {

    "use strict";

    window.qa_edit = {


        init: function() {
            this.update();
            this.datePicker();
        },


        update: function() {
            $('body').on('click', '.inline-edit-save .update', function() {

                var $self = $(this);

                $self.siblings('.spinner').addClass('is-active');

                var $id = $(this).closest('tr').attr('id').split('-')[1];
                var $search_term = $('input[name=post_title]').val();
                var $tags = $('textarea.tax_input_post_tag').val();
                var $month = $('.inline-edit-date select[name=mm] option:selected').val();
                var $day = $('.inline-edit-date input[name=jj]').val();
                var $year = $('.inline-edit-date input[name=aa]').val();
                var $hours = $('.inline-edit-date input[name=hh]').val(); 
                var $minutes = $('.inline-edit-date input[name=mn]').val();

                var data = {
                    action: 'qa_update',
                    search_term: $search_term,
                    tags: $tags,
                    month: $month,
                    day: $day,
                    year: $year,
                    hours: $hours,
                    minutes: $minutes,
                    id: $id
                    
                };

                $.post( qa_js_admin_settings.ajax_url, data, function(response) {

                    var data = JSON.parse(response);                    
                   
                    $('#edit-'+data.id).remove();
                    $('#post-'+data.id).attr('style' , '');

                    $('#post-'+data.id).find('.searches-title strong span').text( data.terms );
                    $('#post-'+data.id).find('.tags').text( data.tags );
                    $('#post-'+data.id).find('.date').text( data.date );

                    $self.siblings('.spinner').removeClass('is-active');
                });

            });
        },

        datePicker: function() {

            // Datepicker range
            $(".qa-date-field").datepicker({
                dateFormat : "yy-mm-dd",
                showButtonPanel: false,
                beforeShowDay: function (date) {
                    var date1 = $.datepicker.parseDate('yy-mm-dd', $("#qa-start-date").val());
                    var date2 = $.datepicker.parseDate('yy-mm-dd', $("#qa-end-date").val());
                    return [true, date1 && ((date.getTime() == date1.getTime()) || (date2 && date >= date1 && date <= date2)) ? "qa-highlight" : ""];
                },
                onSelect: function(dateText, inst) {
                    var olddate1 = $.datepicker.parseDate('yy-mm-dd', $("#qa-start-date").val());
                    var olddate2 = $.datepicker.parseDate('yy-mm-dd', $("#qa-end-date").val());
                    $(this).val(dateText);
                    var date1 = $.datepicker.parseDate('yy-mm-dd', $("#qa-start-date").val());
                    var date2 = $.datepicker.parseDate('yy-mm-dd', $("#qa-end-date").val());
                    var selectedDate = $.datepicker.parseDate('yy-mm-dd', dateText);

                    if (date2 < date1) {
                        if (dateText == $("#qa-start-date").val()) {
                            $("#qa-end-date").val( $("#qa-start-date").val() );
                        } else {
                            $("#qa-start-date").val( $("#qa-end-date").val() );					
                        }
                    }
                }
            });	

        }

    };

    $(document).ready(function() {
        qa_edit.init();

    });

})(jQuery);