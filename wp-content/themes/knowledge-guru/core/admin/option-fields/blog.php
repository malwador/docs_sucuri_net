<?php

Kirki::add_panel(
    'kbg_panel_blog',
    array(
        'panel'    => 'kbg_panel',
        'title'    => esc_attr__( 'Blog', 'knowledge-guru' ),
        'priority' => 20,
    )
);


/* Post layouts */
require_once get_parent_theme_file_path( '/core/admin/option-fields/blog-post-layouts.php' );

/* Archives */
require_once get_parent_theme_file_path( '/core/admin/option-fields/blog-archive.php' );

/* Category */
require_once get_parent_theme_file_path( '/core/admin/option-fields/blog-category.php' );

/* Single post */
require_once get_parent_theme_file_path( '/core/admin/option-fields/blog-single.php' );