<div class="kbg-after-subheader"></div>
<div class="kbg-section">
    <div class="container">
        <div class="section-content row justify-content-center">
            
            <?php if ( kbg_has_sidebar( 'left' ) ): ?>
		        <div class="col-12 col-lg-4 kbg-order-2">
		            <?php get_sidebar(); ?>
		        </div>
    		<?php endif; ?>

            <div class="kbg-content-page col-12 col-lg-8 kbg-order-1 kbg-content-height">


                <?php echo kbg_get_single_media( 'page', '<div class="entry-media">', '</div>' ); ?>
               
                <article id="post-<?php the_ID(); ?>" <?php post_class('kbg-card kbg-card-p mb--xxl kbg-border-reset'); ?>>

                    <?php if ( kbg_get( 'layout' ) == 1 ): ?>
                        <div class="entry-header">
                            <?php echo kbg_breadcrumbs(); ?>
                            <?php the_title( '<h1 class="entry-title h1 mb--lg">', '</h1>' ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if( get_the_content() ): ?>
                        <div class="entry-content entry-single clearfix kbg-entry-content">
                            <?php the_content(); ?> 
                        </div>
                        <?php wp_link_pages( array( 'before' => '<div class="paginated-post-wrapper mt--xl clearfix">', 'after' => '</div>' ) ); ?>
                    <?php endif; ?>
                
                </article>

                <?php comments_template(); ?>
                
            </div>

            <?php if ( kbg_has_sidebar( 'right' ) ): ?>
		        <div class="col-12 col-lg-4 kbg-order-2">
		            <?php get_sidebar(); ?>
		        </div>
    		<?php endif; ?>

        </div>
    </div>
</div>