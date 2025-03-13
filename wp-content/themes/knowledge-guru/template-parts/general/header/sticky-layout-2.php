<div class="header-middle header-layout-2">
	<div class="container">

		<div class="row h-100 align-items-center">

			<div class="header-main-slot-l col">
				<?php get_template_part( 'template-parts/general/header/elements/branding-sticky' ); ?>
			</div>
			
			<div class="header-main-slot-c col d-lg-flex align-items-center justify-content-center d-none">
				<?php if ( kbg_get( 'header', 'sticky_nav' ) ) : ?>
					<?php get_template_part( 'template-parts/general/header/elements/menu-primary' ); ?>
				<?php endif; ?>
			</div>

			<div class="header-main-slot-r col d-flex align-items-center justify-content-end">
				
				<div class="d-none d-lg-block">
					<?php if ( kbg_get( 'header', 'sticky_actions' ) ) : ?>
						<?php foreach ( kbg_get( 'header', 'sticky_actions' ) as $element ) : ?>
							<?php get_template_part( 'template-parts/general/header/elements/' . $element ); ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>

			    <div class="d-lg-none">
				    <?php get_template_part( 'template-parts/general/header/elements/hamburger' ); ?>
				</div>


			</div>
		</div>

	</div>
</div>