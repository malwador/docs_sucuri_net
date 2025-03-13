<div class="kbg-header header-mobile header-main d-lg-none">
		<div class="container">

		<div class="row">

			<div class="header-main-slot-l col">
				<div class="kbg-site-branding">
					<?php echo kbg_get_branding( 'mobile' ); ?>
				</div>
			</div>
			<div class="header-main-slot-r col d-flex justify-content-end">
				<?php if ( kbg_get_option( 'header_responsive_search' ) ) : ?>
					<?php get_template_part( 'template-parts/general/header/elements/search-button' ); ?>
				<?php endif; ?>
				<?php get_template_part( 'template-parts/general/header/elements/hamburger' ); ?>
			</div>
		</div>

		</div>

		<?php if ( kbg_get_option( 'header_responsive_search' ) ) : ?>
			<div class="kbg-in-popup">
					<?php get_search_form(); ?>
			</div>
		<?php endif; ?>
		
</div>

