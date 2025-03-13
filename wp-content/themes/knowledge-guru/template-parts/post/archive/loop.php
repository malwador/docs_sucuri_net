<div class="kbg-section section-content mb--xxl">

    <div class="container">
        <div class="row justify-content-center">



            <?php if ( kbg_has_sidebar( 'left' ) ): ?>
                <div class="col-12 col-lg-4 kbg-order-3">
                    <?php get_sidebar(); ?>
                </div>
            <?php endif; ?>

            <div class="col-12 kbg-order-1 kbg-content-height <?php echo esc_attr( kbg_get_loop_col_class( kbg_get( 'loop' ) ) ); ?>">
                <div class="row kbg-items kbg-load-items <?php echo esc_attr( kbg_get( 'masonry_class' ) ); ?>">

                <?php get_template_part( 'template-parts/general/ads/above-archive' ); ?>

                    <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : the_post(); ?>
            
                            <?php $layout = kbg_get_loop_params( kbg_get( 'loop' ), $wp_query->current_post ); ?>
                            <div class="<?php echo esc_attr( $layout['col'] ); ?>">
                                <?php get_template_part( 'template-parts/post/archive/layouts/' . $layout['style'] ); ?>
                            </div>

                            <?php if( $wp_query->current_post === kbg_get('ads', 'between_position') ) : ?>
                                <?php get_template_part( 'template-parts/general/ads/between-posts' ); ?>
                            <?php endif; ?>
                        
                        <?php endwhile; ?>
                    <?php else: ?>
                        <?php get_template_part( 'template-parts/post/archive/empty' ); ?>
                    <?php endif; ?>

                </div>

                <?php get_template_part( 'template-parts/general/pagination/'. kbg_get( 'pagination' ) ); ?>
                
            </div>

            <?php if ( kbg_has_sidebar( 'right' ) ): ?>
                <div class="col-12 col-lg-4 kbg-order-3">
                    <?php get_sidebar(); ?>
                </div>
            <?php endif; ?>



        </div>
    </div>
</div>