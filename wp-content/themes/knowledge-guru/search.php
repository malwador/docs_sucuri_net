<?php

get_header(); ?>

<?php get_template_part( 'template-parts/general/ads/above-archive' ); ?>

<div class="kbg-section mb--xl negative-margin kbg-archive-section">
	<div class="container">
		<div class="row align-items-center <?php echo esc_attr( kbg_get( 'archive_class' ) ); ?>">
			<div class="col-12 col-md-8">
				<?php get_template_part( 'template-parts/kb/archive/heading' ); ?>
			</div>
		</div>
	</div>
</div>

<div class="kbg-after-subheader"></div>

<?php get_template_part( 'template-parts/kb/archive/loop' ); ?>

<?php get_footer(); ?>