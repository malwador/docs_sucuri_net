<div class="kbg-section section-content mb--xxl">
    <div class="container">
        <div class="row justify-content-center">

            <?php if ( kbg_has_sidebar( 'left' ) ): ?>
                <div class="col-12 col-lg-4 kbg-order-3">
                    <?php get_sidebar(); ?>
                </div>
            <?php endif; ?>

            <div class="col-12 kbg-order-1 kbg-content-height <?php echo esc_attr( kbg_get_loop_col_class( kbg_get( 'loop' ), 'kb' ) ); ?>">

                <div class="row kbg-load-items <?php echo esc_attr( kbg_get( 'masonry_class' ) ); ?>">
                    <div class="col-12">
                        <div class="kbg-card kbg-card-p kbg-border-reset">
                            <div class="kbg-items">

                                <?php if ( have_posts() ) : ?>

                                    <?php while ( have_posts() ) : the_post(); ?>
                        
                                        <?php $layout = kbg_get_loop_params( kbg_get( 'loop' ), $wp_query->current_post, 'kb' ); ?>                    

                                        <div class="<?php echo esc_attr( $layout['col'] ); ?>">
                                            <?php get_template_part( 'template-parts/kb/archive/layouts/' . $layout['style'] ); ?>
                                        </div>

                                        <?php if( $wp_query->current_post === kbg_get('ads', 'between_position') ) : ?>
                                            <?php get_template_part( 'template-parts/general/ads/between-posts' ); ?>
                                        <?php endif; ?>
                                    
                                    <?php endwhile; ?>

                                <?php else: ?>
                                    <?php get_template_part( 'template-parts/kb/archive/empty' ); ?>
                                <?php endif; ?>

                            </div> <!-- end kbg-items -->
                            <?php get_template_part( 'template-parts/general/pagination/'. kbg_get( 'pagination' ) ); ?>
                        </div> <!-- end kbg-card -->
                    </div> <!-- end col-12 -->

                </div>
            </div>

            <?php if ( kbg_has_sidebar( 'right' ) ): ?>
                <div class="col-12 col-lg-4 kbg-order-3">
                    <?php get_sidebar(); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>