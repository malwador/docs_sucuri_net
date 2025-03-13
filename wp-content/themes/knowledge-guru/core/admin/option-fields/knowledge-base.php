<?php

Kirki::add_panel(
    'kbg_panel_knowledge_base',
    array(
        'panel'    => 'kbg_panel',
        'title'    => esc_attr__( 'Knowledge Base', 'knowledge-guru' ),
        'priority' => 20,
    )
);


/* Post layouts */
require_once get_parent_theme_file_path( '/core/admin/option-fields/knowledge-base-layouts.php' );

/* Archives */
require_once get_parent_theme_file_path( '/core/admin/option-fields/knowledge-base-archive.php' );

/* Category */
require_once get_parent_theme_file_path( '/core/admin/option-fields/knowledge-base-category.php' );

/* Single post */
require_once get_parent_theme_file_path( '/core/admin/option-fields/knowledge-base-single.php' );