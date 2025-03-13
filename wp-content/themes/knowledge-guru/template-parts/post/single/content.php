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

            <article id="post-<?php the_ID(); ?>" class="kbg-shadow">

                <?php if ( in_array( kbg_get( 'layout' ), array( '1') ) ) : ?>
                    <?php echo kbg_get_single_media( 'post', '<div class="entry-media">', '</div>' ); ?>
                <?php endif; ?>
            
                <div <?php post_class( 'kbg-card kbg-card-p-large mb--xxl kbg-border-reset' ); ?>>

                    <div class="entry-header mb--xl">

                        <?php the_title( '<h1 class="entry-title h1 mb--0 mt--0 kbg-content-medium">', '</h1>' ); ?>

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

                    <div class="entry-content entry-single clearfix kbg-entry-content">
                        <?php the_content(); ?>
                    </div>

                    <?php wp_link_pages( array( 'before' => '<div class="paginated-post-wrapper mt--xl clearfix">', 'after' => '</div>' ) ); ?>

                    <?php if ( kbg_get( 'tags' ) && has_tag() ) : ?>
                        <div class="entry-tags clearfix mt--xl">
                            <?php the_tags( '<span class="clearfix mb--xs d-block"></span>', '', '' ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( kbg_get( 'prev_next' ) ): ?>
                        <?php get_template_part( 'template-parts/post/single/content-parts/prev-next' ); ?>
                    <?php endif; ?>

                    </div>
                </article>



                <?php if ( kbg_get( 'author' ) ): ?>
                    <?php get_template_part( 'template-parts/post/single/content-parts/author' ); ?>
                <?php endif; ?>

                <?php if ( kbg_get( 'related' ) ): ?>
                    <?php $related_type = is_singular( 'knowledge_base' ) ? 'related-kb' : 'related'; ?>
                    <?php get_template_part( 'template-parts/post/single/content-parts/'. $related_type ); ?>
                <?php endif; ?>

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