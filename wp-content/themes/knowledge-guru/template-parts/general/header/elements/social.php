<?php if ( has_nav_menu( 'kbg_menu_social' ) ): ?>
    <?php
	wp_nav_menu(
		array(
			'theme_location' => 'kbg_menu_social',
			'container'      => 'nav',
			'container_class' => 'menu-social-container',
			'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'menu_class'     => 'kbg-menu-action kbg-menu-social kbg-menu-hover',
			'link_before'    => '<span>',
			'link_after'     => '</span>'
		)
	);
?>
<?php else: ?>
	<?php get_template_part('template-parts/general/header/elements/menu-placeholder'); ?>
<?php endif; ?>
