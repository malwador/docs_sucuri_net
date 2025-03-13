<div class="header-middle header-layout-2">
	<div class="container">

		<div class="row h-100 align-items-center">

			<div class="header-main-slot-l col">
				<?php get_template_part( 'template-parts/general/header/elements/branding' ); ?>
			</div>

			<div class="header-main-slot-c col d-flex align-items-center justify-content-center">
				<?php if ( kbg_get( 'header', 'nav' ) ) : ?>
					<?php get_template_part( 'template-parts/general/header/elements/menu-primary' ); ?>
				<?php endif; ?>
			</div>

			<div class="header-main-slot-r col d-flex align-items-center justify-content-end">
				<?php if ( kbg_get( 'header', 'actions' ) ) : ?>
					<?php foreach ( kbg_get( 'header', 'actions' ) as $element ) : ?>
						<?php get_template_part( 'template-parts/general/header/elements/' . $element ); ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>

	</div>
</div>
