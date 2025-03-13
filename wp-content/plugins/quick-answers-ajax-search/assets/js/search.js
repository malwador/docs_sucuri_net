(function($) {

    "use strict";

    window.qa = {

        settings: {
        },

        init: function() {
            this.live_search()
        },
   
        live_search: function() {

            var $searches = $("input[type=search]");

            if (!$searches.length) {
                return;
            }

            var search_term;

            $('body').on('focus', 'input[type=search]', function() {

                var $this = $(this);

                var $autoComplete = $this.autocomplete({

                    source: function(req, response) {

                        $.getJSON( qa_js_settings.ajax_url+'?callback=?&action=qa_ajax_search', req, response );

                        search_term = req.term;

                        if ( qa.qa_can_ga() ) {
                            ga( 'send', 'event', 'docs', 'search', search_term );
                        }

                    },
                    //appendTo: $this.closest('form'),
                    delay: 300,
                    minLength: qa_js_settings.search_characters_limit,
                    position: { my : "left top+10", at: "left bottom" },
                    create: function(){
                        var loader = $('<span class="cssload-container"><span class="cssload-speeding-wheel"></span></span>');
                        loader.appendTo( $this.parent().find('button'));
                    },
                    search: function(){ 
                        $this.parent().addClass('qa-autocomplete-loading') 
                    },
                    open  : function(){ 
                        $this.parent().removeClass('qa-autocomplete-loading') 
                    },
                    select: function(event, ui) {
                        if ( ui.item.link !== '' ) {
                            window.location.href = ui.item.link;
                        } else {
                            event.preventDefault();
                        }
                    }

                });
                
                $autoComplete.data("ui-autocomplete")._renderItem = function( ul, item ) {

                  

                    if ( item.value == '' ) {

                        if ( qa.qa_can_ga() ) {
                            ga( 'send', 'event', 'docs', 'search not found', search_term );
                        }

                        item.value = qa_js_settings.no_results_found;
                    }

                    
                    $(ul).addClass('qa-ajax-autocomplete');

                    item.value = $('<textarea />').html(item.value).text();
                    

                    var value = '<article class="paragraph-small mb--md"> ' +
                                    '<div class="d-flex">' +
                                    '<span class="kbg-icon"><i class="kg kg-'+ item.format +'"></i></span>' +
                                    '<span>'+ String(item.value).replace(
                                        new RegExp(this.term, "gi"),
                                        "<span class='ui-state-highlight'>$&</span>") +'</span>' +
                                    '</div>';
                                
                    value +=  item.excerpt.length ? '<div class="paragraph-small">'+ item.excerpt +'</div>' :  '';
                    value += '</article>';

                    return $("<li></li>").data("item.autocomplete", item).append(value).appendTo(ul);
                };

                $autoComplete.data("ui-autocomplete")._resizeMenu = function () {
                    var ul = this.menu.element;
                    var input = this.element;
                    var inputWidth = input.closest('form').outerWidth();
   
                    if ( inputWidth < 300 ) {
                        ul.outerWidth( inputWidth ).addClass('kbg-from-widget');
                    }

                    if ( inputWidth < 400 ) {
                        ul.outerWidth( inputWidth );
                    }

                    if ( inputWidth < 700 && inputWidth > 400 ) {
                        ul.outerWidth( inputWidth );
                    } 

                    if ( inputWidth > 700 ) {
                        ul.outerWidth( inputWidth );
                    }

                }

            });
        },

        qa_can_ga: function() {
            if (typeof ga === 'undefined') {
                return false;
            }
            return true;
        },

    };

    $(document).ready(function() {
        qa.init();

    });

})(jQuery);