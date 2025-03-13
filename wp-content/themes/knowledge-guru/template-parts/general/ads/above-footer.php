<?php if( $ad = kbg_get('ads', 'above_footer') ): ?>
	<div class="container">
	    <div class="kbg-ad ad-above-footer d-flex justify-content-center mb--xxl"><?php echo do_shortcode( $ad ); ?></div>
	</div>
<?php endif; ?>