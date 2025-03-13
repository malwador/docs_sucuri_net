<?php
/**
 * Template Name: Knowledge Base Blocks
 */
get_header(); ?>
    	
	<div class="kbg-section">
		
		<?php if ( kbg_has_sidebar( 'left' ) || kbg_has_sidebar( 'right' ) ) : ?>
			
			<div class="container">

					<div class="section-content row justify-content-center">

					<?php if ( kbg_has_sidebar( 'left' ) ) : ?>
						<div class="col-12 col-lg-4 kbg-order-3">
							<?php get_sidebar(); ?>
						</div>
					<?php endif; ?>

					<div class="col-12 col-lg-8 kbg-order-1 kbg-content-height entry-content mb--xxl">
						<?php the_content(); ?>
					</div>

					<?php if ( kbg_has_sidebar( 'right' ) ) : ?>
						<div class="col-12 col-lg-4 kbg-order-3">
							<?php get_sidebar(); ?>
						</div>
					<?php endif; ?>


					</div>
			
			</div>

		<?php else : ?>
			<div class="kbg-blocks-full-content entry-content">
				<?php the_content(); ?>
			</div>
		<?php endif; ?>
				
	</div>

<?php get_footer(); ?>