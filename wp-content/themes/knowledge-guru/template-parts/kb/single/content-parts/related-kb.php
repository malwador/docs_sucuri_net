<?php $related = kbg_get_related(); ?>
<?php if ( $related->have_posts() ) : ?>

	<div class="section-content kbg-card kbg-card-single-related mb--xxl">

		<div class="section-head mb--lg">
			<h3 class="h2"><?php echo kbg_wp_kses( __kbg( 'related_kb' ) ); ?></h3>
		</div>

		
		<div class="row related-posts-kb kbg-posts">
			<?php
			while ( $related->have_posts() ) :
				$related->the_post();
				?>
				<div class="col-12 col-lg-6">
				
					<article <?php post_class( 'kbg-post mb--md section-item-vertical-rhythm kbg-tax-list-type-'.esc_attr( kbg_get( 'post_format' ) ).'' ); ?>>
						<?php the_title( sprintf( '<h5 class="entry-title paragraph-small d-inline"><a class="d-flex" href="%s">', esc_url( get_permalink() ) ), '</a></h5>' ); ?>
					</article>

				</div>
			<?php endwhile; ?>
		</div>

	</div>
	
<?php endif; ?>
<?php wp_reset_postdata(); ?>
