<?php

//Fonts
$main_font = kbg_get_option( 'main_font', 'font' );
$h_font = kbg_get_option( 'h_font', 'font' );
$nav_font = kbg_get_option( 'nav_font', 'font' );
$button_font = kbg_get_option( 'button_font', 'font' );

//Font sizes
$font_size_p = number_format( absint( kbg_get_option( 'font_size_p' ) ) / 10,  1 );
$font_size_small = number_format( absint( kbg_get_option( 'font_size_small' ) ) / 10,  1 );
$font_size_nav = number_format( absint( kbg_get_option( 'font_size_nav' ) ) / 10,  1 );
$font_size_nav_ico = number_format( absint( kbg_get_option( 'font_size_nav_ico' ) ) / 10,  1 );
$font_size_section_title = number_format( absint( kbg_get_option( 'font_size_section_title' ) ) / 10,  1 );
$font_size_widget_title = number_format( absint( kbg_get_option( 'font_size_widget_title' ) ) / 10,  1 );

$font_size_punchline = number_format( absint( kbg_get_option( 'font_size_punchline' ) ) / 10,  1 );
$font_size_h1 = number_format( absint( kbg_get_option( 'font_size_h1' ) ) / 10,  1 );
$font_size_h2 = number_format( absint( kbg_get_option( 'font_size_h2' ) ) / 10,  1 );
$font_size_h3 = number_format( absint( kbg_get_option( 'font_size_h3' ) ) / 10,  1 );
$font_size_h4 = number_format( absint( kbg_get_option( 'font_size_h4' ) ) / 10,  1 );
$font_size_h5 = number_format( absint( kbg_get_option( 'font_size_h5' ) ) / 10,  1 );
$font_size_h6 = number_format( absint( kbg_get_option( 'font_size_h6' ) ) / 10,  1 );

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
$color_header_sticky_bg = $color_option == 'custom' ? kbg_get_option('color_header_sticky_bg') : $color_header_bg_solid;
$color_header_sticky_txt = $color_option == 'custom' ? kbg_get_option('color_header_sticky_txt') : $color_header_middle_txt;

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

    --color-h: <?php echo esc_attr( $color_h ); ?>;
    --color-meta: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.5 ) ); ?>; 

    --color-header: <?php echo esc_attr( $color_header_bg_solid ); ?>;
    --color-button-primary: <?php echo esc_attr( $color_button_primary ); ?>;
    --color-button-primary-text: <?php echo esc_attr( $color_button_primary_text ); ?>;
    --color-button-secondary: <?php echo esc_attr( $color_button_secondary ); ?>; 
    --color-button-tertiary: <?php echo esc_attr( $color_button_tertiary ); ?>; 

    --color-txt-075: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.75 ) ); ?>; 
    --color-txt-05: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.5 ) ); ?>; 
    --color-txt-025: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.25 ) ); ?>; 
    --color-txt-015: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.15 ) ); ?>; 
    --color-txt-01: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.1 ) ); ?>; 
    --color-txt-005: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.05 ) ); ?>; 
    --color-txt-0025: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.025 ) ); ?>; 

    --color-header-middle-txt: <?php echo esc_attr( $color_header_middle_txt ); ?>;
    --color-header-middle-txt-05: <?php echo esc_attr( kbg_hex_to_rgba( $color_header_middle_txt, 0.5 ) ); ?>;
    --color-header-middle-txt-075: <?php echo esc_attr( kbg_hex_to_rgba( $color_header_middle_txt, 0.75 ) ); ?>; 

    --color-header-middle-acc: var(--color-header-middle-txt-075);


    --font-size-p: <?php echo esc_attr( $font_size_p ); ?>rem;
    --line-height-p: 1.8;
    --font-size-small: <?php echo esc_attr( $font_size_small ); ?>rem;
    --line-height-small: 1.4;
    --font-size-nav: <?php echo esc_attr( $font_size_nav ); ?>rem;
    --font-size-p-large: <?php echo esc_attr( $font_size_p + 0.2 ); ?>rem;

    --header-height: <?php echo esc_attr( $header_height ); ?>px;
    --header-sticky-height: <?php echo esc_attr( $header_sticky_height ); ?>px;
    --header-height-responsive-sm: 60px;
    --header-height-responsive-md: 80px;

    --width-full: <?php echo kbg_wp_kses( kbg_size_by_col( 12 ) ) ?>px;
    --content-post: <?php echo kbg_wp_kses( kbg_size_by_col( kbg_get_option('single_post_width') ) ) + $grid['gutter']['lg']; ?>px;
}

/* Header */
.kbg-header{
    --nav-font: <?php echo kbg_wp_kses( $nav_font['font-family'] ); ?>, Arial, sans-serif;
    --nav-font-weight: <?php echo esc_attr( $nav_font['font-weight'] ); ?>;
    <?php if ( isset( $nav_font['font-style'] ) && !empty( $nav_font['font-style'] ) ):?>
    --nav-font-style: <?php echo esc_attr( $nav_font['font-style'] ); ?>;
    <?php endif; ?>

 

    font-size:<?php echo esc_attr( $font_size_nav ); ?>rem;
}



/* Header middle */
.kbg-header{
	font-family: var(--nav-font);
	font-weight: var(--nav-font-weight);
	<?php if ( isset( $nav_font['font-style'] ) && !empty( $nav_font['font-style'] ) ):?>
	    font-style: var(--nav-font-style);
    <?php endif; ?>  
}
.kbg-header .sub-menu {
    background: #FFF;
    color: var(--color-txt);
}
 
.header-main .header-middle, 
.header-mobile {
    background: <?php echo esc_attr( $color_header_bg_solid ); ?>
}
.header-main .kbg-single-subheader {
    background: var( --color-main );
}

.header-main,
.header-main .header-middle a,
.header-mobile a,
.header-mobile .kbg-menu-donate li a{
    color: var(--color-header-middle-txt);
}
.header-main .sub-menu a{
    color: var(--color-txt);    
}
.header-middle .sub-menu li:hover > a,
.header-middle .sub-menu .current-menu-item > a,
.header-middle .sub-menu .current-menu-parent > a{
    color: var(--color-header);  
}

.header-middle nav > ul > li:hover > a,
.header-middle nav > ul > .current-menu-item > a,
.header-middle nav > ul > .current-menu-parent > a,
.kbg-hamburger > li > a:hover,
.kbg-hamburger > li.accordion-active > a,
.kbg-cart > li > a:hover,
.kbg-cart > li.accordion-active > a  {
    color: var(--color-header-middle-txt-075);
}



<?php  if ( kbg_get( 'header', 'sticky' ) ): ?>

/* Header sticky */

.header-sticky{
    --color-header-sticky-bg: <?php echo esc_attr( $color_header_sticky_bg ); ?>;
    --color-header-sticky-txt: <?php echo esc_attr( $color_header_sticky_txt ); ?>;
    --color-header-sticky-05: <?php echo esc_attr( kbg_hex_to_rgba( $color_header_sticky_txt, 0.5 ) ); ?>; 
}
.header-sticky {
    background-color: var(--color-header-sticky-bg);
}
.header-sticky .sub-menu {
    background: #FFF;
}

.header-sticky,
.header-sticky a,
.header-sticky .kbg-hamburger > li > a,
.header-sticky .kbg-cart > li > a,
.header-sticky .kbg-cart .kbg-cart-count {
    color: var(--color-header-sticky-txt);
}
.header-sticky .sub-menu a {
    color: var(--color-txt);
}
.header-sticky .sub-menu li:hover > a,
.header-sticky .sub-menu .current-menu-item > a,
.header-sticky .sub-menu .current-menu-parent > a {
    color: var(--color-header-sticky-bg);
}

.header-sticky nav > ul > li:hover > a,
.header-sticky nav > ul > .current-menu-item > a,
.header-sticky nav > ul > .current-menu-parent > a,
.header-sticky .kbg-hamburger > li:hover > a,
.header-sticky .kbg-cart > li:hover > a  {
    color: var(--color-header-sticky-05);
}
.header-sticky-main > .container{
    height: <?php echo esc_attr( $header_sticky_height ); ?>px;
}

<?php  endif; ?>


/* Typography */

.entry-title a{
	color: <?php echo esc_attr( $color_txt ); ?>;
}
.entry-title a:hover,
.fn a:hover{
    color: var(--color-main);   
}


/* Font sizes */

body{
	font-size:<?php echo esc_attr( $font_size_p ); ?>rem;
}

.widget-title{
    font-size:<?php echo esc_attr( $font_size_widget_title ); ?>rem; 
}

.mks_author_widget h3{
    font-size:<?php echo esc_attr( $font_size_widget_title - 0.2 ); ?>rem;    
}

.entry-content .meks_ess_share_label h5{
    font-size:<?php echo esc_attr( $font_size_widget_title - 0.6 ); ?>rem; 
}

.h0{
    font-size: clamp(2.4rem, 6vw, <?php echo esc_attr( $font_size_punchline ); ?>rem);
}
h1, .h1{
    font-size: clamp(2.4rem, 3vw, <?php echo esc_attr( $font_size_h1 ); ?>rem);
}
h2, .h2{
    font-size: clamp(2rem, 3vw, <?php echo esc_attr( $font_size_h2 ); ?>rem);
}
h3, .h3{
    font-size: clamp(2rem, 2vw, <?php echo esc_attr( $font_size_h3 ); ?>rem);
}
h4, .h4,.mks_author_widget h3,
.wp-block-cover:not(.wp-block-kbg-search-box):not(.wp-block-kbg-contact-box) .wp-block-cover-image-text,
.wp-block-cover:not(.wp-block-kbg-search-box):not(.wp-block-kbg-contact-box) .wp-block-cover-text,
.wp-block-cover:not(.wp-block-kbg-search-box):not(.wp-block-kbg-contact-box) h2,
.wp-block-cover-image:not(.wp-block-kbg-search-box):not(.wp-block-kbg-contact-box) .wp-block-cover-image-text,
.wp-block-cover-image:not(.wp-block-kbg-search-box):not(.wp-block-kbg-contact-box) .wp-block-cover-text,
.wp-block-cover-image:not(.wp-block-kbg-search-box):not(.wp-block-kbg-contact-box) h2{
    font-size: clamp(1.8rem, 3vw, <?php echo esc_attr( $font_size_h4 ); ?>rem);
}
h5, .h5,.header-el-label,.fn,
.wp-block-kbg-accordion-item.col-lg-4 h4{
    font-size: clamp(1.6rem, 3vw, <?php echo esc_attr( $font_size_h5 ); ?>rem);
}
h6, .h6{
    font-size: clamp(1.4rem, 3vw, <?php echo esc_attr( $font_size_h6 ); ?>rem);
}

.section-title{
    font-size: clamp(2rem, 3vw, <?php echo esc_attr( $font_size_section_title ); ?>rem);
}

.widget{
    font-size: var(--font-size-small);
}
.kbg-tax.kbg-card .entry-content{
    font-size: var(--font-size-small);   
}
.paragraph-small {
    font-size: var(--font-size-small);
    font-family: var(--main-font);
}
.text-small {
    font-size: <?php echo esc_attr( $font_size_small - 0.2 ); ?>rem; 
}
.text-small {
    font-family: var(--h-font);
}


/* Header responsive sizes */

.header-mobile>.container,
.header-sticky .header-middle > .container{
    height: 60px;
}

@media (min-width: <?php echo esc_attr($grid['breakpoint']['md']); ?>px){ 
    .header-mobile>.container,
    .header-sticky .header-middle > .container{
        height: 80px;
    }

}

@media (min-width: <?php echo esc_attr($grid['breakpoint']['lg']); ?>px){ 
    .header-main .header-middle > .container {
	    height: var( --header-height );
    }
    .header-sticky .header-middle > .container{
        height: var( --header-sticky-height );   
    }
}



/* Buttons */

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
.entry-tags a,
.widget .tagcloud a,
.kbg-footer .widget .tagcloud a{
    font-family: var(--h-font); 
    font-weight: var(--h-font-weight);
}


/* Pagination */

.kbg-button.disabled,
.kbg-button.disabled:hover{	
	background-color: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.1 ) ); ?>; 
	color: <?php echo esc_attr( $color_txt ); ?>;  
    pointer-events: none;
}
.kbg-breadcrumbs{
    color: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.25 ) ); ?>;    
}
.kbg-breadcrumbs a{
    color: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.5 ) ); ?>; 
}
.kbg-breadcrumbs a:hover{
    color: <?php echo esc_attr( $color_txt ); ?>; 
}


/* Widget */

.widget a{
    color: var( --color-txt );  
}

.widget a:hover{
    color: var( --color-header );         
}
.widget li{
    color: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.5 ) ); ?>;     
}

.kbg-sidebar ul.mks_social_widget_ul li a:hover,
.widget_calendar #today a{
    background-color: <?php echo esc_attr( $color_txt ); ?>;
}

.widget_calendar #today a{
	color: #fff;
}

.rssSummary,
.widget-title .rsswidget{
    color: <?php echo esc_attr( $color_txt ); ?>; 
}

.widget_categories ul li a,
.widget_archive ul li a{
    color: <?php echo esc_attr( $color_txt ); ?>; 
}


<?php

/* Uppercase option */

$uppercase_defaults = kbg_get_typography_uppercase_options();
$uppercase = kbg_get_option('uppercase');

foreach ( $uppercase_defaults as $key => $value ) {

    if( $key == 'buttons'){
        continue;
    }

    if ( in_array( $key, $uppercase ) ) {
        echo html_entity_decode( $key ) .'{ text-transform: uppercase;}';
    } else {
        echo html_entity_decode( $key ) .'{ text-transform: none;}';
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
.widget .tagcloud a,
.kbg-footer .widget .tagcloud a,
.wp-block-tag-cloud a {
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

<?php endif; ?>

<?php


/* Editor font sizes */
$font_sizes = kbg_get_editor_font_sizes();

if ( !empty( $font_sizes ) ) {
	echo '@media(min-width: '.esc_attr( $grid['breakpoint']['lg']).'px){'; 
    foreach ( $font_sizes as $id => $item ) {  
        	echo '.has-'. $item['slug'] .'-font-size{ font-size: '.number_format( $item['size'] / 10,  1 ) .'rem !important;}';
    }
    echo '}';
}

/* Editor colors */
$colors = kbg_get_editor_colors();

if ( !empty( $colors ) ) {
    foreach ( $colors as $id => $item ) {  
        	echo '.has-'. $item['slug'] .'-background-color{ background-color: ' . esc_attr($item['color']) .';}';
        	echo '.has-'. $item['slug'] .'-color{ color: ' . esc_attr($item['color']) .';}';
    }
}
?>

/* Footer */

.kbg-footer{

    --color-footer-bg: <?php echo esc_attr( $color_footer_bg ); ?>;
    --color-footer-txt: <?php echo esc_attr( $color_footer_txt ); ?>;
    --color-footer-txt-025: <?php echo esc_attr( kbg_hex_to_rgba( $color_footer_txt, 0.25 ) ); ?>; 
    --color-footer-txt-05: <?php echo esc_attr( kbg_hex_to_rgba( $color_footer_txt, 0.5 ) ); ?>; 
    --color-footer-txt-06: <?php echo esc_attr( kbg_hex_to_rgba( $color_footer_txt, 0.6 ) ); ?>; 

    background-color: var(--color-footer-bg);
    color: var(--color-footer-txt);
    font-size: 1.6rem;
}
.kbg-footer a,
.kbg-footer .widget-title,
.kbg-footer .widget_categories li a,
.kbg-footer .widget_archive li a,
.kbg-footer .widget .kbg-accordion-nav,
.kbg-footer table,
.kbg-footer .widget-title .rsswidget,
.kbg-footer .widget li,
.kbg-footer .rssSummary,
.kbg-footer .widget p{
    color: var(--color-footer-txt);
}

.kbg-footer select{
    color: var(--color-footer-bg);   
}
.kbg-footer .separator-line{
	background-color:<?php echo esc_attr( kbg_hex_to_rgba( $color_footer_txt, 0.1 ) ); ?>;
}

.kbg-footer .widget li,
.kbg-footer .rss-date{
    color: <?php echo esc_attr( kbg_hex_to_rgba( $color_footer_txt, 0.5 ) ); ?>;   
}

.kbg-footer .widget li a:hover,
.kbg-footer .widget a:hover,
.kbg-copyright a:hover{
    color: var(--color-footer-txt-06);   
}

.kbg-tax-list {
    border-top: 10px solid <?php echo esc_attr( $color_header_bg_solid ); ?>
}

/* Blocks */

.alignwide{
    max-width: var(--width-full) !important;
    margin-left: auto !important;
    margin-right: auto !important;
    padding: 0 !important;
}

tr {
	border-bottom: 1px solid <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.1 ) ); ?>;
}
.wp-block-table.is-style-stripes tr:nth-child(odd){
	background-color: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.1 ) ); ?>;
}

body .wp-block-button .wp-block-button__link.has-background:hover{
    background-color: <?php echo esc_attr( $color_txt); ?> !important;  
    color: <?php echo esc_attr( $color_bg ); ?>;     
}
.wp-block-button.is-style-outline .wp-block-button__link{
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
    background-color: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.01 ) ); ?>;
}
.wp-block-pullquote:not(.is-style-solid-color){
	color: <?php echo esc_attr( $color_txt); ?>;
	border-color: <?php echo esc_attr( $color_txt ); ?>;  
}
.wp-block-pullquote{
	background-color: <?php echo esc_attr( $color_txt ); ?>;  
	color: <?php echo esc_attr( $color_bg); ?>; 	
}
.kbg-sidebar-none .wp-block-pullquote.alignfull.is-style-solid-color{
	box-shadow: -526px 0 0 <?php echo esc_attr( $color_txt); ?>, -1052px 0 0 <?php echo esc_attr( $color_txt); ?>,
	526px 0 0 <?php echo esc_attr( $color_txt); ?>, 1052px 0 0 <?php echo esc_attr( $color_txt ); ?>; 
}
.entry-content > pre,
.entry-content > code,
.entry-content > p code,
.comment-content > pre,
.comment-content > code,
.comment-content > p code{
    background-color: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.05 ) ); ?>; 
}
.wp-block-separator{
    background-color: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.05 ) ); ?>;
}

.wp-block-rss__item-author, 
.wp-block-rss__item-publish-date{
    color:  <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.5 ) ); ?>;
}
.wp-block-calendar tfoot a{
    color:  <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.5 ) ); ?>;
}
.wp-block-latest-comments__comment-meta,
.wp-block-latest-posts__post-date{
    color: <?php echo esc_attr( kbg_hex_to_rgba( $color_txt, 0.5 ) ); ?>; 
}


    

<?php


/* Apply image size options */
$image_sizes = kbg_get_image_sizes();

if ( !empty( $image_sizes ) ) {

	echo '@media(min-width: '.esc_attr( $grid['breakpoint']['md']).'px){'; 
    foreach ( $image_sizes as $id => $size ) {
    	if( isset($size['cover']) )  {      
        	echo '.size-'.$id .'{ height: '.absint($size['h'] * 1).'px !important;}';
    	}
    }
    echo '}';

	echo '@media(min-width: '.esc_attr( $grid['breakpoint']['lg']).'px){'; 
    foreach ( $image_sizes as $id => $size ) {
    	if( $size['h'] && $size['h'] < 5000)  {      
        	echo '.size-'.$id .'{ height: '.esc_attr($size['h']).'px !important;}';
    	}
    }
    echo '}';

}

?>

<?php // Theme Style: Sharp | Rounded | Pill ?>
<?php $theme_style = kbg_get_option( 'theme_style' ); ?>
<?php 
    $radius = 0;
    $outer_radius = 0;
    switch( $theme_style ) {
        case 'sharp':
            $radius;
            break;
        case 'rounded':
            $radius = 6;
            break;
        case 'pill':
            $radius = 30;
            break;

        default:
        break;
    }
?>

.kbg-card,
.kbg-button,
form,
.wp-block-search__button,
input[type="text"],
input[type="email"],
input[type="url"],
input[type="password"],
input[type="search"],
input[type="number"],
input[type="tel"],
textarea,
input[type="submit"],
input[type="button"],
button[type="submit"],
.kbg-pagination a,
ul.page-numbers a,
ul.page-numbers span,
.page-numbers.current,
.widget .mks_autor_link_wrap a,
.widget .mks_read_more a,
.paginated-post-wrapper a,
#cancel-comment-reply-link,
.comment-reply-link,
.wp-block-button .wp-block-button__link,
.kbg-contact-box,
.kbg-contact-box.cover:after,
.entry-tags a,
.wp-block-quote,
.wp-block-quote.is-style-large,
.wp-block-quote.is-large,
.entry-content >  blockquote,
.kbg-footer-widgets.kbg-boxed .widget,
.search-content.kbg-boxed .wp-block-search,
.entry-border-radius img,
select,
.widget .tagcloud a,
.kbg-footer .widget .tagcloud a,
.has-background,
.wp-block-file,
.wp-block-file .wp-block-file__button,
pre,
.wp-block-button .button__link,
.wp-block-kbg-contact-box,
.wp-block-tag-cloud a,
.kbg-sidebar-right .wp-block-cover,
.kbg-sidebar-left .wp-block-cover,
.qa-ajax-autocomplete,
.wp-block-search__inside-wrapper, 
.search-content.kbg-boxed .wp-block-search,
.search-content div.wp-block-search,
.kbg-header ul .sub-menu,
.kbg-sidebar-right .wp-block-kbg-search-box,
.kbg-sidebar-left .wp-block-kbg-search-box,
.af-button,
.widget .entry-media img,
.af-kb-rate,
.hamburger-sub-menu {
    border-radius: <?php echo absint( $radius ) ?>px !important;
}


.kbg-card .kbg-card-image img,
.kbg-contact-box.kbg-large.kbg-image img,
.single .kbg-content-post .entry-media img,
.kbg-post .entry-media img,
.kbg-content-page .entry-media img {
    border-top-left-radius: <?php echo absint( $radius ) ?>px;
    border-top-right-radius: <?php echo absint( $radius ) ?>px;
}


.kbg-contact-box.kbg-small.kbg-image img,
.kbg-card.layout-e-image img {
    border-top-left-radius: <?php echo absint( $radius ) ?>px;
    border-bottom-left-radius: <?php echo absint( $radius ) ?>px;
    border-top-right-radius: 0;
}
.has-post-thumbnail .kbg-border-reset,
.has-post-thumbnail.kbg-border-reset{
    border-top-left-radius: 0 !important;
    border-top-right-radius: 0 !important;
}

@media (max-width: <?php echo esc_attr($grid['breakpoint']['md']); ?>px){ 
    .kbg-contact-box.kbg-small.kbg-image img {
        border-radius: <?php echo absint( $radius ) ?>px;
    }
    .kbg-contact-box.kbg-small.kbg-image img, .kbg-card.layout-e-image img{
        border-top-left-radius: <?php echo absint( $radius ) ?>px;
        border-top-right-radius: <?php echo absint( $radius ) ?>px;  
        border-bottom-left-radius: 0;  
    }
}