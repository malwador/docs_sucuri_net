<?php if ( $more_link = get_next_posts_link( __kbg('load_more') ) ) : ?>

	<div class="col-12 kbg-order-2 kbg-pagination-main plr--0">
		<div class="kbg-section-separator"></div>
	    <nav class="navigation pagination kbg-pagination load-more">
	        <?php echo kbg_wp_kses( $more_link ); ?>
	    </nav>
	</div>

<?php endif; ?>