<?php if ( has_nav_menu( 'kbg_menu_copyright' ) ) : ?>
    <?php wp_nav_menu( array( 
									'menu_class'      => 'navbar-nav-footer',
									'container'       => 'nav',
									'container_class' => 'navbar-footer',
									'depth'           => 2,
        ) ); ?>
<?php else: ?>
    <nav>
	    <?php get_template_part('template-parts/general/header/elements/menu-placeholder'); ?>
	</nav>
<?php endif; ?>
