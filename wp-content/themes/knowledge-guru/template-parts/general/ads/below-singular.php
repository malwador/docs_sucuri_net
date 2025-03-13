<?php if( $ad = kbg_get('ads', 'below_singular') ): ?>
	<div class="container">
		<div class="kbg-ad ad-below-singular d-flex justify-content-center mt-85 mb-0"><?php echo do_shortcode( $ad ); ?></div>
	</div>
<?php endif; ?>