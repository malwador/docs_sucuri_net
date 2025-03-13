<?php

//Fonts
$main_font = kbg_get_option( 'main_font', 'font' );
$h_font = kbg_get_option( 'h_font', 'font' );
$nav_font = kbg_get_option( 'nav_font', 'font' );
$button_font = kbg_get_option( 'button_font', 'font' );


//Font sizes
$font_size_p = absint( kbg_get_option( 'font_size_p' ) );
$font_size_small = absint( kbg_get_option( 'font_size_small' ) );
$font_size_nav = absint( kbg_get_option( 'font_size_nav' ) );

$font_size_h1 = absint( kbg_get_option( 'font_size_h1' ));
$font_size_h2 = absint( kbg_get_option( 'font_size_h2' ));
$font_size_h3 = absint( kbg_get_option( 'font_size_h3' ));
$font_size_h4 = absint( kbg_get_option( 'font_size_h4' ));
$font_size_h5 = absint( kbg_get_option( 'font_size_h5' ));
$font_size_h6 = absint( kbg_get_option( 'font_size_h6' ));

// Colors

$color_bg = kbg_get_option('color_bg');
$color_h = kbg_get_option('color_h');
$color_txt = kbg_get_option('color_txt');

$color_option = kbg_get_option('color_option');
$color_main = kbg_get_option('color_main');

$color_button_primary = kbg_get_option('color_button_primary');
$color_button_primary_text = kbg_get_option('color_button_primary_text');
$color_button_secondary = $color_option == 'custom' ? kbg_get_option('color_button_secondary') : $color_main;
$color_button_tertiary = $color_option == 'custom' ? kbg_get_option('color_button_tertiary') : kbg_main_color_lite_95_percent( $color_main );

$color_header_bg_type = kbg_get_option('color_header_bg_type');
$color_header_bg_solid = $color_option == 'custom' ? kbg_get_option('color_header_bg_solid') : kbg_main_color_lite( $color_main );
$color_header_middle_txt = kbg_get_option('color_header_txt');

// Sticky ?
$color_header_sticky_bg = kbg_get_option('header_sticky_type') == 'custom' ? kbg_get_option('color_header_sticky_bg') : $color_header_bg_solid;
$color_header_sticky_txt = kbg_get_option('header_sticky_type') == 'custom' ? kbg_get_option('color_header_sticky_txt') : $color_header_middle_txt;

$color_footer_bg = $color_option == 'custom' ? kbg_get_option('color_footer_bg') : $color_main;
$color_footer_txt = kbg_get_option('color_footer_txt');
$color_footer_meta = kbg_get_option('color_footer_meta');

//Other
$header_top_height = kbg_get_option('header_top_height');
$header_height = absint( kbg_get_option('header_height') );
$has_header_sticky = kbg_get_option('header_sticky');
$header_sticky_height = absint( kbg_get_option('header_sticky_height') );

//Grid vars
$grid = kbg_grid_vars();

?>

:root{   
    --main-font: <?php echo kbg_wp_kses( $main_font['font-family'] ); ?>, Arial, sans-serif;
    --main-font-weight: <?php echo esc_attr( $main_font['font-weight'] ); ?>;
    <?php if ( isset( $main_font['font-style'] ) && !empty( $main_font['font-style'] ) ):?>
    --main-font-style: <?php echo esc_attr( $main_font['font-style'] ); ?>;
    <?php endif; ?>    

    --h-font: <?php echo kbg_wp_kses( $h_font['font-family'] ); ?>, Arial, sans-serif;
    --h-font-weight: <?php echo esc_attr( $h_font['font-weight'] ); ?>;
    <?php if ( isset( $h_font['font-style'] ) && !empty( $h_font['font-style'] ) ):?>
    --h-font-style: <?php echo esc_attr( $h_font['font-style'] ); ?>;
    <?php endif; ?>

    --button-font: <?php echo kbg_wp_kses( $button_font['font-family'] ); ?>, Arial, sans-serif;
    --button-font-weight: <?php echo esc_attr( $button_font['font-weight'] ); ?>;
    <?php if ( isset( $button_font['font-style'] ) && !empty( $button_font['font-style'] ) ):?>
    --button-font-style: <?php echo esc_attr( $button_font['font-style'] ); ?>;
    <?php endif; ?>

    --color-txt: <?php echo esc_attr( $color_txt ); ?>;
    --color-bg: <?php echo esc_attr( $color_bg ); ?>;
    --color-main: <?php echo esc_attr( $color_main ); ?>;
    --color-main-025: <?php echo esc_attr( kbg_hex_to_rgba( $color_main, 0.25 ) ); ?>; 
    --color-main-05: <?php echo esc_attr( kbg_hex_to_rgba( $color_main, 0.5 ) ); ?>; 
    --color-main-075: <?php echo esc_attr( kbg_hex_to_rgba( $color_main, 0.75 ) ); ?>; 
    --color-header: <?php echo esc_attr( $color_header_bg_solid ); ?>;

    --color-h: <?php echo esc_attr( $color_h ); ?>;
    --color-meta: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.5 ) ); ?>; 

    --color-button-primary: <?php echo esc_attr( $color_button_primary ); ?>;
    --color-button-primary-text: <?php echo esc_attr( $color_button_primary_text ); ?>;
    --color-button-secondary: <?php echo esc_attr( $color_button_secondary ); ?>; 
    --color-button-tertiary: <?php echo esc_attr( $color_button_tertiary ); ?>; 

    --color-txt-075: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.75 ) ); ?>; 
    --color-txt-05: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.5 ) ); ?>; 
    --color-txt-025: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.25 ) ); ?>; 
    --color-txt-01: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.1 ) ); ?>; 
    --color-txt-005: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.05 ) ); ?>; 

    --font-size-p: <?php echo esc_attr( $font_size_p ); ?>px;
    --line-height-p: 1.625;
    --font-size-small: <?php echo esc_attr( $font_size_small ); ?>px;
    --line-height-small: 1.4;
    --font-size-nav: <?php echo esc_attr( $font_size_nav ); ?>px;
    --font-size-p-large: <?php echo esc_attr( $font_size_p + 0.2 ); ?>px;

    --header-height: <?php echo esc_attr( $header_height ); ?>px;
    --header-sticky-height: <?php echo esc_attr( $header_sticky_height ); ?>px;
    --header-height-responsive-sm: 60px;
    --header-height-responsive-md: 80px;

    --width-full-cards: <?php echo kbg_wp_kses( kbg_size_by_col( 12 ) + 50 ); ?>px;
    --width-full: <?php echo kbg_wp_kses( kbg_size_by_col( 12 ) ) ?>px;
    --content-post: <?php echo kbg_wp_kses( kbg_size_by_col( kbg_get_option('single_post_width') ) ) + $grid['gutter']['lg']; ?>px;
}

body .edit-post-visual-editor {
    background: <?php echo esc_attr( $color_bg ); ?>;
    color: <?php echo esc_attr( $color_txt ); ?>;
}
.block-editor-block-list__block.is-highlighted:after{
    background: var(--color-txt-01); 
}
.block-editor-block-list__layout .block-editor-block-list__block.is-selected:after,
.block-editor-block-list__layout .block-editor-block-list__block:not([contenteditable]):focus:after,
.is-dark-theme .block-editor-block-list__layout .block-editor-block-list__block:not([contenteditable]):focus:after{
    box-shadow: 0 0 0 3px var(--color-main-05);
    top: -10px;
    right: -20px;
    bottom: -10px;
    left: -20px;    
}

body .editor-styles-wrapper{
    background: var(--color-bg);
	font-family: <?php echo kbg_wp_kses( $main_font['font-family'] ); ?>, Arial, sans-serif;
	font-weight: <?php echo esc_attr( $main_font['font-weight'] ); ?>;
	<?php if ( isset( $main_font['font-style'] ) && !empty( $main_font['font-style'] ) ):?>
	font-style: <?php echo esc_attr( $main_font['font-style'] ); ?>;
	<?php endif; ?>
}

body .editor-styles-wrapper p{
  line-height: 1.625;
}

body .paragraph-small {
    font-size: var(--font-size-small);
    font-family: var(--main-font);
}
.text-small {
    font-size: <?php echo esc_attr( $font_size_small - 0.2 ); ?>rem; 
}
.text-small {
    font-family: var(--h-font);
}

.kbg-tax.kbg-card .entry-content {
    font-size: var(--font-size-small);
}

body .editor-styles-wrapper h1,
.editor-styles-wrapper.edit-post-visual-editor .editor-post-title__block .editor-post-title__input,
body .editor-post-title .editor-post-title__input,
body .editor-styles-wrapper h2,
body .editor-styles-wrapper h3,
body .editor-styles-wrapper h4,
body .editor-styles-wrapper h5,
body .editor-styles-wrapper h6,
.wp-block-cover .wp-block-cover-image-text, 
.wp-block-cover .wp-block-cover-text, 
.wp-block-cover h2, 
.wp-block-cover-image .wp-block-cover-image-text, 
.wp-block-cover-image .wp-block-cover-text, 
.wp-block-cover-image h2,
.entry-category a,
.entry-summary,
.wp-block-heading h1,
.wp-block-heading h2,
.wp-block-heading h3,
.wp-block-heading h4,
.wp-block-heading h5,
.wp-block-heading h6 {
	font-family: <?php echo kbg_wp_kses( $h_font['font-family'] ); ?>, Arial, sans-serif;
	font-weight: <?php echo esc_attr( $h_font['font-weight'] ); ?>;
	<?php if ( isset( $h_font['font-style'] ) && !empty( $h_font['font-style'] ) ):?>
	font-style: <?php echo esc_attr( $h_font['font-style'] ); ?>;
	<?php endif; ?>
}
b,
strong{
	font-weight: <?php echo esc_attr( $h_font['font-weight'] ); ?>; 
}

body .editor-styles-wrapper h1,
.editor-styles-wrapper.edit-post-visual-editor .editor-post-title__block .editor-post-title__input,
body .editor-post-title .editor-post-title__input,
body .editor-styles-wrapper h2,
body .editor-styles-wrapper h3,
body .editor-styles-wrapper h4,
body .editor-styles-wrapper h5,
body .editor-styles-wrapper h6,
.has-large-font-size,
.wp-block-heading h1,
.wp-block-heading h2,
.wp-block-heading h3,
.wp-block-heading h4,
.wp-block-heading h5,
.wp-block-heading h6 {
	color: <?php echo esc_attr( $color_h ); ?>;	
}

.wp-block-button .wp-block-button__link,
.wp-block-search__button{
	font-family: <?php echo kbg_wp_kses( $button_font['font-family'] ); ?>, Arial, sans-serif;
	font-weight: <?php echo esc_attr( $button_font['font-weight'] ); ?>;
	<?php if ( isset( $button_font['font-style'] ) && !empty( $button_font['font-style'] ) ):?>
	font-style: <?php echo esc_attr( $button_font['font-style'] ); ?>;
	<?php endif; ?>
	font-size: 14px;
    letter-spacing: 0.5px;
}

.wp-block.editor-post-title.editor-post-title__block .editor-post-title__input::-webkit-input-placeholder{
	color: <?php echo esc_attr( $color_h ); ?>;		
}
.is-dark-theme .block-editor-default-block-appender textarea.block-editor-default-block-appender__content{
    color: <?php echo esc_attr( $color_txt ); ?>;	   
}


.wp-block[data-align=wide],
.aligncenter{
    max-width: var(--width-full);
    margin-left: auto;
    margin-right: auto;
    overflow: hidden;
}

.entry-title a,
.kbg-tax-list .paragraph-small a{
	color: <?php echo esc_attr( $color_txt ); ?>;
    text-decoration: none;
}
.entry-title a:hover,
.fn a:hover{
    color: var(--color-main);   
}
.kbg-meta-link,
.kbg-button{
    text-decoration: none;  
}


/* Blocks */

tr {
	border-bottom: 1px solid <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.1 ) ); ?>;
}
.wp-block-table.is-style-stripes tr:nth-child(odd){
	background-color: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.1 ) ); ?>;
}
.wp-block-button .wp-block-button__link{
    background-color: <?php echo esc_attr( $color_txt ); ?>; 
    color: <?php echo esc_attr( $color_bg ); ?>;
}

.wp-block .wp-block-button.is-style-outline .wp-block-button__link{
    border: 1px solid <?php echo esc_attr( $color_txt); ?>;
    color: <?php echo esc_attr( $color_txt); ?>;    
}
.wp-block-button.is-style-outline .wp-block-button__link:hover{
    border: 1px solid <?php echo esc_attr( $color_txt ); ?>; 
    color: <?php echo esc_attr( $color_txt ); ?>; 
    background: 0 0;   
}

.is-style-outline .wp-block-button__link {
    background: 0 0;
    color:<?php echo esc_attr( $color_txt ); ?>;
    border: 2px solid currentcolor;
}
.wp-block-quote:before{
    background-color: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.07 ) ); ?>;
}
.wp-block-pullquote:not(.is-style-solid-color){
	color: <?php echo esc_attr( $color_txt); ?>;
	border-color: <?php echo esc_attr( $color_txt ); ?>;  
}
.wp-block-pullquote{
	background-color: <?php echo esc_attr( $color_txt ); ?>;  
	color: <?php echo esc_attr( $color_bg); ?>; 	
}
body .editor-styles-wrapper .wp-block-pullquote.alignfull.is-style-solid-color{
	box-shadow: -526px 0 0 <?php echo esc_attr( $color_txt); ?>, -1052px 0 0 <?php echo esc_attr( $color_txt); ?>,
	526px 0 0 <?php echo esc_attr( $color_txt); ?>, 1052px 0 0 <?php echo esc_attr( $color_txt ); ?>; 
}
body .editor-styles-wrapper .wp-block  pre{
    background-color: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.05 ) ); ?>;  
}
body .editor-styles-wrapper .wp-block-separator{
    background-color: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.05 ) ); ?>;
}
body .editor-styles-wrapper .wp-block-tag-cloud a{
    color: <?php echo esc_attr( $color_txt); ?>;    
}
.wp-block-rss__item-author, .wp-block-rss__item-publish-date{
    color: <?php echo esc_attr( $color_bg); ?>; 
}
.wp-block-calendar tfoot a{
    color: <?php echo esc_attr( $color_txt); ?>; 
}

body .editor-styles-wrapper .wp-block-quote:before{
    background-color: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.07 ) ); ?>;
}

body .editor-styles-wrapper .wp-block-search__input{
    border: 1px solid <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.1 ) ); ?>;
}

body .editor-styles-wrapper .wp-block-latest-comments__comment-meta,
body .editor-styles-wrapper .wp-block-latest-posts__post-date{
    color: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.5 ) ); ?>; 
}

body .editor-styles-wrapper .wp-block-pullquote,
body .editor-styles-wrapper .wp-block-pullquote:not(.is-style-solid-color){
	border-top: 4px solid <?php echo esc_attr( $color_txt ); ?>; 
	border-bottom: 4px solid <?php echo esc_attr( $color_txt ); ?>; 
}

body .editor-styles-wrapper code, 
body .editor-styles-wrapper kbd, 
body .editor-styles-wrapper pre, 
body .editor-styles-wrapper samp,
body .editor-styles-wrapper .wp-block-code,
body .editor-styles-wrapper code,
body .editor-styles-wrapper pre{
    background-color: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.05 ) ); ?>;
    font-size: 16px; 	
}

.wp-block-code .editor-plain-text{
	background-color: transparent;
}
body .editor-styles-wrapper .wp-block-code,
body .editor-styles-wrapper code,
body .editor-styles-wrapper pre,
body .editor-styles-wrapper pre h2{
	color: <?php echo esc_attr( $color_txt ); ?>;
}



/* Mobile Font sizes */

body .editor-styles-wrapper {
	font-size:<?php echo esc_attr( $font_size_p ); ?>px;
}

body .editor-styles-wrapper h1,
.wp-block-heading h1.wp-block{
	font-size:26px;
}
body .editor-styles-wrapper h2,
.wp-block-heading h2.wp-block{
	font-size:24px;
}
body .editor-styles-wrapper h3,
.wp-block-heading h3.wp-block{
	font-size:22px;
}
body .editor-styles-wrapper h4,
.wp-block-cover .wp-block-cover-image-text,
.wp-block-cover .wp-block-cover-text,
.wp-block-cover h2,
.wp-block-cover-image .wp-block-cover-image-text,
.wp-block-cover-image .wp-block-cover-text,
.wp-block-cover-image h2,
.wp-block-heading h4.wp-block{
	font-size:20px;
}
body .editor-styles-wrapper h5.wp-block,
.wp-block-heading h5{
	font-size:18px;
}
body .editor-styles-wrapper h6.wp-block,
.wp-block-heading h6  {
	font-size:16px;
}
.wp-block-pullquote blockquote > .block-editor-rich-text p{
    font-size: 24px;
    line-height: 1.67;
}
.wp-block-quote.is-large p, 
.wp-block-quote.is-style-large p{
	font-size:22px;
}

@media (min-width: <?php echo esc_attr($grid['breakpoint']['md']); ?>px) and (max-width: <?php echo esc_attr($grid['breakpoint']['lg']); ?>px){ 

body .editor-styles-wrapper h1,
.wp-block-heading h1,
.editor-post-title .editor-post-title__input{
    font-size: clamp(2.6rem, 3vw, <?php echo esc_attr( $font_size_h1 ); ?>rem);
}
body .editor-styles-wrapper h2,
.wp-block-heading h2 {
	font-size:32px;
}
body .editor-styles-wrapper h3,
.wp-block-heading h3{
	font-size:28px;
}
body .editor-styles-wrapper h4,
.wp-block-cover .wp-block-cover-image-text,
.wp-block-cover .wp-block-cover-text,
.wp-block-cover h2,
.wp-block-cover-image .wp-block-cover-image-text,
.wp-block-cover-image .wp-block-cover-text,
.wp-block-cover-image h2,
.wp-block-heading h4{
	font-size:24px;
}
body .editor-styles-wrapper h5,
.wp-block-heading h5{
	font-size:20px;
}
body .editor-styles-wrapper h6,
.wp-block-heading h6  {
	font-size:18px;
}
}


/* Desktop Font sizes */
@media (min-width: <?php echo esc_attr($grid['breakpoint']['lg']); ?>px){ 

.editor-styles-wrapper{
	font-size:<?php echo esc_attr( $font_size_p ); ?>px;
}
body .editor-styles-wrapper h1.wp-block,
.wp-block-heading h1,
.editor-post-title .editor-post-title__input {
	font-size:<?php echo esc_attr( $font_size_h1 ); ?>px;
}

body .editor-styles-wrapper h2,
body .editor-styles-wrapper h2.wp-block,
.wp-block-heading h2,
body .editor-styles-wrapper .h2 {
    font-size: <?php echo esc_attr( $font_size_h2 ); ?>px;
}
body .editor-styles-wrapper h3,
body .editor-styles-wrapper h3.wp-block,
.wp-block-heading h3,
body .editor-styles-wrapper .h3 {
    font-size: <?php echo esc_attr( $font_size_h3 ); ?>px;
}
body .editor-styles-wrapper h4.wp-block,
.wp-block-cover .wp-block-cover-image-text,
.wp-block-cover .wp-block-cover-text,
.wp-block-cover h2,
.wp-block-cover-image .wp-block-cover-image-text,
.wp-block-cover-image .wp-block-cover-text,
.wp-block-cover-image h2,
.wp-block-heading h4,
body .editor-styles-wrapper .h4 {
	font-size: <?php echo esc_attr( $font_size_h4 ); ?>px;
}
body .editor-styles-wrapper h5.wp-block,
.wp-block-heading h5,
.wp-block-kbg-accordion-item.col-lg-4 h4 {
	font-size:<?php echo esc_attr( $font_size_h5 ); ?>px;
}

body .editor-styles-wrapper h6.wp-block,
.wp-block-heading h6 {
	font-size:<?php echo esc_attr( $font_size_h6 ); ?>px;
}
.wp-block-quote.is-large p, 
.wp-block-quote.is-style-large p{
	font-size:26px;
}
}


<?php
/* Uppercase option */
$uppercase_defaults = kbg_get_typography_uppercase_options();
$uppercase = kbg_get_option('uppercase');

foreach ( $uppercase_defaults as $key => $value ) {
    if ( in_array( $key, $uppercase ) ) {
        echo 'body .editor-styles-wrapper '.esc_attr( $key ) .'{ text-transform: uppercase;}';
    } else {
        echo 'body .editor-styles-wrapper '.esc_attr( $key ) .'{ text-transform: none;}';
    }
}
?>

<?php if( in_array('buttons', $uppercase) ): ?>

.kbg-menu-donate li a,
.kbg-buttons .kbg-menu-subscribe li a,
.kbg-button, 
input[type="submit"], 
input[type="button"], 
button[type="submit"], 
.kbg-pagination a, 
ul.page-numbers a, 
ul.page-numbers .current, 
.comment-reply-link, 
#cancel-comment-reply-link, 
.meks-instagram-follow-link .meks-widget-cta, 
.mks_autor_link_wrap a, 
.mks_read_more a, 
.paginated-post-wrapper a, 
.entry-content .kbg-button, 
.kbg-subscribe .empty-list a, 
.kbg-menu-donate .empty-list a, 
.kbg-link-special,
.kbg-button-play span,
.entry-tags a,
.wp-block-button__link,
.editor-styles-wrapper [data-type="core/tag-cloud"] a {
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

<?php endif; ?>

.kbg-button,
input[type="submit"],
input[type="button"],
button[type="submit"],
.kbg-pagination a,
ul.page-numbers a,
ul.page-numbers span,
.widget .mks_autor_link_wrap a,
.widget .mks_read_more a,
.paginated-post-wrapper a,
#cancel-comment-reply-link,
.comment-reply-link,
.wp-block-button .wp-block-button__link{
	font-family: var(--button-font);
	font-weight: var(--button-font-weight);
	<?php if ( isset( $button_font['font-style'] ) && !empty( $button_font['font-style'] ) ):?>
	    font-style: var(--button-font-style);
    <?php endif; ?>
}
.kbg-button:hover {
    color: var( --color-txt ) !important;   
}


<?php // Theme Style: Sharp | Rounded | Pill ?>
<?php $theme_style = kbg_get_option( 'theme_style' ); ?>
<?php 
    $radius = 0;
    switch( $theme_style ) {
        case 'sharp':
            $radius;
            break;
        case 'rounded':
            $radius = 6;
            break;
        case 'pill':
            $radius = 40;
            break;

        default:
        break;
    }
?>
body .block-editor-writing-flow,
.kbg-card,
.is-root-container .kbg-button,
.is-root-container input[type="search"],
.is-root-container .wp-block-search__inside-wrapper,
.is-root-container .wp-block-search__button,
.is-root-container .wp-block-search__input,
.is-root-container .wp-block-search,
.is-root-container input[type="text"],
.is-root-container input[type="email"],
.is-root-container input[type="number"],
.is-root-container textarea,
.is-root-container input[type="submit"],
.is-root-container input[type="button"],
.is-root-container button[type="submit"],
.is-root-container .kbg-pagination a,
.is-root-container .wp-block-button .wp-block-button__link,
.is-root-container .wp-block[data-type="kbg/contact-box"],
.block-bg-color,
.is-root-container .wp-block[data-type="kbg/contact-box"],
.block-bg-color.cover:after,
.editor-styles-wrapper [data-type="core/tag-cloud"] a,
.is-root-container .has-background {
    border-radius: <?php echo absint( $radius ) ?>px !important;
}

.kbg-card .entry-media.kbg-card-image img,
.wp-block[data-type="kbg/contact-box"] .block-bg-color.kbg-large.kbg-image img {
    border-top-left-radius: <?php echo absint( $radius ) ?>px;
    border-top-right-radius: <?php echo absint( $radius ) ?>px;
}

.kbg-card.layout-e-image .entry-media.kbg-card-image img,
.wp-block[data-type="kbg/contact-box"] .block-bg-color.kbg-small.kbg-image img {
    border-top-left-radius: <?php echo absint( $radius ) ?>px;
    border-bottom-left-radius: <?php echo absint( $radius ) ?>px;
    border-top-right-radius: 0;
}