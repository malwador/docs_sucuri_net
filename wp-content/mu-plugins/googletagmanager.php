<?php
// This file is used to inject the Google Tag Manager script into the site header and body.
// Author: Salvador Aguilar
// Date: Feb 19th 2025


function doGoogleTagManager2025_head()
{
        $script = "<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-M6LV26K5');</script>
<!-- End Google Tag Manager -->";

        echo $script;
}

function doGoogleTagManager2025_body()
{
        $script = '<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M6LV26K5"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->';

        echo $script;
}
add_action('wp_head', 'doGoogleTagManager2025_head');
