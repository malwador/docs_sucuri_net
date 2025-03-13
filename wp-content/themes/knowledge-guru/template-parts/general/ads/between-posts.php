<?php if( $ad = kbg_get('ads', 'between_posts') ): ?>
	<div class="col-12 kbg-ad ad-between-posts d-flex justify-content-center vertical-gutter-flow"><?php echo do_shortcode( $ad ); ?></div>
<?php endif; ?>