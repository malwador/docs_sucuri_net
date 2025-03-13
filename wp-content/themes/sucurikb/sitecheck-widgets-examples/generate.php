<?php
    $response = array();
    $attributes = '';

    foreach ($_POST as $param_name => $param_value) {
        if (preg_match('/^widget-([a-z]+)$/', $param_name, $param_match)) {
            $param_name = sprintf('data-%s', $param_match[1]);
            $param_value = htmlentities($param_value);
            $attributes .= sprintf(' %s="%s"', $param_name, $param_value);
        }
    }

    $response['title'] = 'SiteCheck Widget';
    $response['content']  = '';
    $response['content']  .= '
        <p><a href="http://sitecheck.sucuri.net/" target="_blank">Sucuri SiteCheck</a> scanner
        will check your website for known malware, blacklisting status, website errors, and
        out-of-date software. <strong>Disclaimer</strong>: Sucuri SiteCheck is a free &amp;
        remote scanner. Although we do our best to provide the best results, 100% accuracy
        is not realistic, and not guaranteed.</p>';
    $response['content'] .= '<pre><code class="html">';
    $response['content'] .= sprintf('&lt;div id="%s"%s&gt;&lt;/div&gt;', 'sucuri-sitecheck', $attributes);
    $response['content'] .= "\n";
    $response['content'] .= sprintf(
        '&lt;script src="%s?%s"&gt;&lt;/script&gt;',
        'http://sucuri.net/sucuri-sitecheck-widget.js',
        time()
    );
    $response['content'] .= '</code></pre>';

    header('Content-type: application/json');
    print( json_encode($response) );
?>