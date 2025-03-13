<?php if( $ad = kbg_get('ads', 'above_singular') ): ?>
	<div class="container">
		<div class="kbg-ad ad-above-singular d-flex justify-content-center mb--xxl"><?php echo do_shortcode( $ad ); ?></div>
	</div>
<?php endif; ?>