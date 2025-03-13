<div class="kbg-sidebar kbg-sidebar-hidden">

	<div class="kbg-sidebar-branding">
	    <?php echo kbg_get_branding( 'sidebar' ); ?>
	    <span class="kbg-action-close"><i class="kg kg-close" aria-hidden="true"></i></span>
	</div>	

	<?php $display_class = kbg_get('header', 'nav') ? 'd-md-block d-lg-none' : ''; ?>
	<div class="kbg-menu-mobile widget <?php echo esc_attr( $display_class ); ?>">
		<div class="widget-inside">
		<h4 class="widget-title"><?php echo kbg_wp_kses(__kbg('menu_label')); ?></h4>
			<?php get_template_part('template-parts/general/header/elements/menu-primary'); ?>
		</div>
	</div>

</div>