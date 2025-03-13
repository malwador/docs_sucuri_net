<?php $display = kbg_get_post_layout_options('a'); ?>

<article <?php post_class('kbg-post mb--xxl section-item-vertical-rhythm kbg-post-layout-a kbg-shadow'); ?>>
    <div class="<?php echo esc_attr( $display['align_class'] ); ?>">    
    
        <?php if ( $fimg = kbg_get_featured_image( 'kbg-a', true ) ): ?>
            <div class="entry-media">
                <a href="<?php the_permalink(); ?>"><?php echo kbg_wp_kses( $fimg ); ?></a>
            </div>
        <?php endif; ?>

        <div class="kbg-card kbg-card-p kbg-border-reset">
            
            <div class="entry-header <?php echo esc_attr( $display['entry_header_class'] ); ?>">

                <?php if ( $display['is_kb_archive'] ) : ?>
                    <div class="entry-header-inner">
                <?php endif; ?>

                <?php the_title( sprintf( '<h2 class="entry-title mb--0 mt--0 kbg-content-medium h1"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

                <?php if ( $display['meta'] ) : ?>	
                    <div class="entry-meta mt--md entry-meta-border-box">
                        <?php echo kbg_get_meta_data( $display['meta'] ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( $display['is_kb_archive'] ) : ?> 
                    </div>
                <?php endif; ?>

            </div>
				
            <?php if( $display['excerpt'] ): ?>
                <div class="entry-content mt--lg mb--xs">
                    <?php if ($display['excerpt_type'] == 'auto' ): ?>
                        <?php echo kbg_get_excerpt( $display['excerpt'] ); ?>
                    <?php else: ?>
                        <?php the_content(); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            
            <?php if( $display['rm'] ): ?>
                <a href="<?php the_permalink(); ?>" class="kbg-button button-tertiary button-small mt--lg">
                    <?php echo esc_html( __kbg( 'read_more') ); ?>
                </a>
            <?php endif; ?>

        </div>

    </div>
</article>