<form class="search-form" action="<?php echo esc_url( home_url(  ) ); ?>" method="get">
		<input name="s" type="search" value="" placeholder="<?php echo esc_attr( __kbg( 'search_placeholder' ) ); ?>" />
		<?php if ( defined( 'ICL_LANGUAGE_CODE' ) ): ?>
			<input type="hidden" name="lang" value="<?php echo esc_attr( ICL_LANGUAGE_CODE ); ?>">
		<?php endif; ?>
		<button type="submit">Let's go</button>
</form>