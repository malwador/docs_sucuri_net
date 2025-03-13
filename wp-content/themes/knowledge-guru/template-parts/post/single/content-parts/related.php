<?php $related = kbg_get_related(); ?>
<?php if ( $related->have_posts() ) : ?>

    <div class="section-content kbg-card kbg-card-single-related mb--xxl">

        <div class="section-head mb--lg">
            <h3 class="h2"><?php echo kbg_wp_kses(__kbg( 'related_blog' )); ?></h3>
        </div>

        
        <div class="row related-posts kbg-posts">
            <?php while ( $related->have_posts() ) : $related->the_post(); ?>
                <div class="col-12 col-md-6">
                
                    <article <?php post_class('kbg-post section-item-vertical-rhythm mb--md'); ?>>
	
                        <?php if ( $fimg = get_the_post_thumbnail( get_the_ID(), 'thumbnail' ) ) : ?>
                            <div class="entry-media entry-border-radius">
                                <a href="<?php the_permalink(); ?>"><?php echo kbg_wp_kses( $fimg ); ?></a>
                            </div>
                        <?php endif; ?>

                        <div class="entry-header">

                            <?php the_title( sprintf( '<h2 class="entry-title h6 mb--0"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                            
                            <div class="entry-meta">
                                <?php echo kbg_get_meta_data( array( 'date' ) ); ?>  
                            </div>

                        </div>

                    </article>

                </div>
            <?php endwhile; ?>
        </div>

    </div>
    
<?php endif; ?>
<?php wp_reset_postdata(); ?>