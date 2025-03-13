<?php if ( has_nav_menu( 'kbg_menu_primary' ) ) : ?>
    <?php wp_nav_menu( array( 'theme_location' => 'kbg_menu_primary', 'container'=> 'nav', 'menu_class' => 'kbg-menu kbg-menu-primary',  ) ); ?>
<?php else: ?>
	    <?php get_template_part('template-parts/general/header/elements/menu-placeholder'); ?>
<?php endif; ?>
