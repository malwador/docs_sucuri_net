<div class="kbg-after-subheader"></div>
<div class="kbg-section">
    <div class="container">
        <div class="section-content row justify-content-center">
            
            <?php if ( kbg_has_sidebar( 'left' ) ): ?>
		        <div class="col-12 col-lg-4 kbg-order-2">
		            <?php get_sidebar(); ?>
		        </div>
    		<?php endif; ?>

            <div class="kbg-content-post col-12 col-lg-8 kbg-order-1 kbg-content-height">

                <?php if ( in_array( kbg_get( 'layout' ), array( '1') ) ) : ?>
                    <?php echo kbg_get_single_media( 'post', '<div class="entry-media">', '</div>' ); ?>
                <?php endif; ?>
            
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'kbg-card kbg-card-p mb--xxl kbg-border-reset' ); ?>>

                    <div class="entry-header mb--xl">

                        <?php the_title( '<h1 class="entry-title h1 mb--0">', '</h1>' ); ?>

                        <?php if ( kbg_get( 'meta' ) ) : ?>
                            <div class="entry-meta mt--md entry-meta-border-box">
                                <?php echo kbg_get_meta_data( kbg_get( 'meta' ) ); ?>
                            </div>
                        <?php endif; ?>

                    </div>

                    <?php if ( kbg_get( 'headline' ) && has_excerpt() ): ?>
						<div class="entry-summary">
                            <?php the_excerpt(); ?>
						</div>
					<?php endif; ?>

                    <div class="entry-content entry-single clearfix">
                        <?php the_content(); ?>
                    </div>

                    <?php wp_link_pages( array( 'before' => '<div class="paginated-post-wrapper mt--xl clearfix">', 'after' => '</div>' ) ); ?>
                    
                    <?php $has_tax_terms = get_the_term_list( get_the_ID(), 'kbg_tags' ,'', '', '' ); ?>

                    <?php if ( kbg_get( 'tags' ) && $has_tax_terms ) : ?>
                        <div class="entry-tags clearfix mt--xl">
                            <?php echo get_the_term_list( get_the_ID(), 'kbg_tags' ,'<span class="clearfix mb--xs d-block"></span>', '', '' ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( kbg_get( 'prev_next' ) ): ?>
                        <?php get_template_part( 'template-parts/kb/single/content-parts/prev-next' ); ?>
                    <?php endif; ?>

                </article>



                <?php if ( kbg_get( 'author' ) ): ?>
                    <?php get_template_part( 'template-parts/kb/single/content-parts/author' ); ?>
                <?php endif; ?>

                <?php if ( kbg_get( 'related' ) ): ?>
                    <?php get_template_part( 'template-parts/kb/single/content-parts/related-kb'); ?>
                <?php endif; ?>

            </div>

            <?php if ( kbg_has_sidebar( 'right' ) ): ?>
                <div class="col-12 col-lg-4 kbg-order-2">
                    <?php get_sidebar(); ?>
                </div>
            <?php endif; ?>

        </div>

    </div>
</div>