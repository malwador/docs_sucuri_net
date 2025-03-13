<?php
/**
 * Layout B
 *
 * @package Kbg_Buddy
 */

namespace Kbg\Kbg_Buddy;
?>

<article <?php post_class('kbg-tax kbg-card full-height kbg-tax-layout-e layout-e-'.$attributes['blockType'].' layout-kbg-tax-'.$attributes['blockType'].''); ?>>

    <div class="d-lg-flex">
    
        <?php if ( $attributes['displayPostImage'] && $fimg = kbg_buddy_get_category_featured_image( 'kbg-tax-e', $category->term_id, $attributes['blockType'] ) ): ?>
            <div class="mb--0 d-md-block entry-media kbg-card-<?php echo esc_attr( $attributes['blockType'] ); ?>">
                <a href="<?php echo esc_url( get_term_link( $category->term_id, 'kbg_category' ) ) ?>"><?php echo kbg_buddy_wp_kses( $fimg ); ?></a>
            </div>
        <?php endif; ?>

        <div class="kbg-lay-e-content">
   
            <?php echo sprintf( '<%s class="entry-title h3"><a href="%s">%s</a></%s>', $attributes['titleTag'], esc_url( get_term_link( $category->term_id, 'kbg_category' ) ),  $category->name, $attributes['titleTag'] ); ?>
			
            <?php if( $attributes['displayPostExcerpt'] ): ?>
                <div class="entry-content">
                    <?php if ( $attributes[ 'displayPostContentRadio' ] == 'excerpt' ) : ?>
                        <?php $excerpt = wp_trim_words( $category->description, $attributes[ 'excerptLength' ] )?>
                        <?php echo wpautop( kbg_buddy_wp_kses( $excerpt ) ); ?>    
                    <?php else : ?>
                        <?php echo wpautop( kbg_buddy_wp_kses( $category->description ) ); ?>    
                    <?php endif; ?>
                </div>
            <?php endif; ?>

			<?php if( $attributes['displayReadMoreLink'] ): ?>
                <?php $classes = $attributes['readMoreLinkType'] == 'button' ? 'kbg-button button-tertiary button-small' : 'kbg-meta-link' ?>
                <a href="<?php echo esc_url( get_term_link( $category->term_id, 'kbg_category' ) ); ?>" class="<?php echo esc_attr( $classes ) ?>">
                    <?php echo esc_html( $category->count ); ?>
                    <?php echo esc_html( $attributes['ctaText'] ); ?>
                </a>
            <?php endif; ?>

        </div>

    </div>
</article>