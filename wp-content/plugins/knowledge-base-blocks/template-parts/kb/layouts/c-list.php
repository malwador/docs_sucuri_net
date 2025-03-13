<?php
/**
 * Layout B
 *
 * @package Kbg_Buddy
 */

namespace Kbg\Kbg_Buddy;
?>

<article <?php post_class('kbg-tax-list kbg-card-p full-height kbg-card layout-c-list'); ?>>

    <div class="justify-content-center">

        <div class="card-list-padding">

            <div class="entry-header">

            <?php if ( $attributes['displayPostImage'] && $fimg = kbg_buddy_get_category_featured_image( 'kbg-category-list-icon', $category->term_id, 'list' ) ): ?>
                    <div class="entry-media kbg-card-icon">
                        <a href="<?php echo esc_url( get_term_link( $category->term_id, 'kbg_category' ) ) ?>"><?php echo kbg_buddy_wp_kses( $fimg ); ?></a>
                    </div>
                <?php endif; ?>

                <div class="entry-header-content">
                    <?php echo sprintf( '<%s class="entry-title h3 mb--0"><a href="%s">%s</a></%s>', $attributes['titleTag'], esc_url( get_term_link( $category->term_id, 'kbg_category' ) ),  $category->name, $attributes['titleTag'] ); ?>
                    
                    <div class="entry-meta">
                        <span class="meta-item"><?php echo esc_html( $category->count ); ?> <?php echo esc_html( $attributes['metaText'] ) ?></span>
                    </div>
                </div>

            </div>
			
            <div class="entry-list">

                <?php $list = Blocks_Helper::kbg_get_knowledge_base_post_list( $category->term_id, $attributes );  ?>

                <?php if ( $list->have_posts() ) : ?>
                    <div class="row">  
                        <?php while ( $list->have_posts() ) : $list->the_post(); ?>
                            
                            <?php $format = get_post_format() ? : 'standard'; ?>
                            <?php $icon_class = $attributes['displayArticleIcon'] ? 'kbg-tax-list-type-'.$format : '' ?>

                            <article class="col-12 paragraph-small mb--md <?php echo esc_attr( $icon_class ) ?>">
                                <a class="d-flex" href="<?php the_permalink() ?>"><?php the_title() ?></a>
                            </article>

                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

                <?php wp_reset_postdata(); ?>

            </div>

			<?php if( $attributes['displayReadMoreLink'] ): ?>
                <?php $classes = $attributes['readMoreLinkType'] == 'button' ? 'kbg-button button-primary button-small mt--lg' : 'kbg-meta-link mt--md' ?>
                <a href="<?php echo esc_url( get_term_link( $category->term_id, 'kbg_category' ) ); ?>" class="<?php echo esc_attr( $classes ) ?>">
                    <?php echo esc_html( $attributes['ctaText'] ); ?>
                </a>
            <?php endif; ?>

        </div>

    </div>
</article>