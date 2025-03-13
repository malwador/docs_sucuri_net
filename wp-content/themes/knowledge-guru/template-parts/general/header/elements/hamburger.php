<ul class="kbg-menu-action kbg-hamburger d-lg-none justify-content-end">
	
	<li>
		<a href="javascript:void(0);" class="kbg-open-responsive-menu" data-side="mobile">
			<?php if ( kbg_get_option( 'hamburger_menu_label' ) ) : ?>
				<span><?php echo esc_html( __kbg( 'menu_label' ) ); ?></span>
			<?php endif; ?>
			<i class="kg kg-menu"></i>
		</a>

		<?php if ( has_nav_menu( 'kbg_menu_primary' ) ) : ?>
			<?php 
				wp_nav_menu( array( 
					'theme_location' => 'kbg_menu_primary', 
					'container'=> '', 
					'menu_class' => 'hamburger-sub-menu', 
					'after' => '<span class="kbg-has-sub-menu kg kg-down"></span>'  
				) ); 
			?>
		<?php else: ?>
				<?php get_template_part('template-parts/general/header/elements/menu-placeholder'); ?>
		<?php endif; ?>


	</li>
</ul>