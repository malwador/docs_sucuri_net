<div class="col-12">
	<article <?php post_class( 'kbg-post kbg-card kbg-card-p' ); ?>>
	        <div class="entry-content">
				<?php if ( is_search() ) : ?>
					<div class="kbg-empty-message">
						<p><?php echo esc_html( __kbg( 'content_none_search' ) ); ?></p>
					</div>
				<?php else: ?>
					<div class="kbg-empty-message">
						<p><?php echo esc_html( __kbg( 'content_none' ) ); ?></p>
					</div>
				<?php endif; ?>
	        </div>
	</article>
</div>
