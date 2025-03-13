<?php if ( get_previous_post() || get_next_post() ) : ?>
	<nav class="prev-next-nav mt--xxl d-grid">
		
		<?php if ( get_next_post() ) : ?>
			<div class="kbg-prev-link kbg-prev-next-link">
				<span class="text-small d-block mb--xs prev-label"><?php echo kbg_wp_kses( __kbg( 'prev_post' ) ); ?></span>
				<?php next_post_link('<h4 class="mb--0 mt--0 h5">%link</h4>', '%title'); ?>
			</div>
		<?php endif; ?>
		
		<?php if ( get_previous_post() ) : ?>
			<div class="kbg-next-link kbg-prev-next-link">
				<span class="text-small d-block mb--xs next-label"><?php echo kbg_wp_kses( __kbg( 'next_post' ) ); ?></span>
				<?php previous_post_link('<h4 class="mb--0 mt--0 h5">%link</h4>', '%title'); ?>
			</div>	
		<?php endif; ?>
	</nav>
<?php endif; ?>
