<?php if( $pagination = get_the_posts_pagination( array( 'mid_size' => 2, 'prev_text' => esc_html(__kbg( 'previous_posts' )), 'next_text' => esc_html(__kbg( 'next_posts' )) ) ) ) : ?>
	    <div class="col-12 text-center kbg-order-2 kbg-pagination-main plr--0">
			
            <nav class="kbg-pagination numeric-pagination prev-next">

            	<?php if( !get_previous_posts_link() ) : ?>
            		<a href="javascript:void(0);" class="prev page-numbers disabled"><?php echo esc_html( __kbg( 'previous_posts' ) ); ?></a>
	            <?php endif; ?>

                <?php echo kbg_wp_kses( $pagination ); ?>

                <?php if( !get_next_posts_link() ) : ?>
            		<a href="javascript:void(0);" class="next page-numbers disabled"><?php echo esc_html( __kbg( 'next_posts' ) ); ?></a>
	            <?php endif; ?>

            </nav>
	    </div>
<?php endif; ?>