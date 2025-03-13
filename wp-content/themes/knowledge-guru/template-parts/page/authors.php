<?php 
    if ( kbg_get( 'authors_type' ) == 'host' ) :
        $authors_query = new WP_User_Query( kbg_get( 'authors_query_args' ) );
        $authors = $authors_query->get_results();
?>

    <?php if ( !empty( $authors ) ) : ?>

        <?php foreach ( $authors as $author ) : ?>

            <div class="d-flex kbg-section author-list flex-wrap">
                
                <div class="author-archive clearfix d-flex align-items-center">
                    <div class="author-avatar">
                        <?php echo get_avatar( $author->ID, 60 ); ?>
                    </div>

                    <div class="mb--sm">
                        <h4 class="h4"><a href="<?php echo esc_url( get_author_posts_url( $author->ID ) ); ?>"><?php echo get_the_author_meta( 'display_name', $author->ID ); ?></a></h4>
                    </div>
                </div>

                <div class="section-description mt--md">
                        <?php echo wpautop( get_the_author_meta( 'description', $author->ID ) ); ?>
                </div>
                <div class="section-subnav mt--md kbg-buttons d-flex">
                    <?php echo kbg_get_author_links( $author->ID, false ); ?>
                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

    
<?php else: ?>

    <?php 
        $guest_coauthors = new WP_Query( 
            array(
                'post_type'         => 'guest-author',
                'posts_per_page'    => -1
            ) 
        );
    ?>

    <?php if ( $guest_coauthors->have_posts() ) : ?>

        <?php foreach ( $guest_coauthors->posts as $author ) : ?>

            <?php $guest_author_meta = get_post_meta( $author->ID ); ?>

            <div class="d-flex kbg-section author-list flex-wrap">
                
                <div class="author-header">
                    <div class="author-avatar ml-0">
                        <a href="<?php echo esc_url( get_author_posts_url( $author->ID, $guest_author_meta['cap-user_login'][0] ) ); ?>">
                            <?php echo get_avatar( $author->ID, 60 ); ?>
                        </a>
                    </div>

                    <div class="author-title">
                        <h4>
                            <a href="<?php echo esc_url( get_author_posts_url( $author->ID, $guest_author_meta['cap-user_login'][0] ) ); ?>">
                                <?php echo esc_html( $guest_author_meta['cap-display_name'][0] ); ?>
                            </a>
                        </h4>
                                
                        <div class="section-subnav">
                            <?php if ( !empty( $guest_author_meta['cap-website'][0] ) ) : ?>
                                <a href="<?php echo esc_url( $guest_author_meta['cap-website'][0] ) ?>" target="_blank" rel="noopener" class="kbg-button-circle"><i class="kbg-icon kg kg-website"></i></a>
                            <?php endif; ?>

                            <?php echo kbg_get_author_links( $author->ID, false ); ?>
                        </div>
                    </div>
                </div>

                <div class="author-description social-icons-clean mt--md">
                    <?php echo wpautop( kbg_wp_kses( $guest_author_meta['cap-description'][0] ) ); ?>
                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

        
<?php endif; ?>