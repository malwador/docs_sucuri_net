// WidgetPack Rating Widget
wpac_init = window.wpac_init || [];
wpac_init.push({widget: 'Rating', id: 17739});
(function() {
    if ('WIDGETPACK_LOADED' in window) return;
    WIDGETPACK_LOADED = true;
    var mc = document.createElement('script');
    mc.type = 'text/javascript';
    mc.async = true;
    mc.src = 'https://embed.widgetpack.com/widget.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(mc, s.nextSibling);
})();

// Remove Standard Footer
jQuery(document).ready(function( $ ) {
        $( "footer#colophon" ).remove();
});
