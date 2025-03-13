<?php
$heroic_current_options = wp_parse_args(get_option('quality_pro_options', array()), theme_data_setup());
?>
<article <?php post_class('post'); ?>>
    <figure class="post-thumbnail">
        <?php $heroic_defalt_arg = array('class' => "img-responsive"); ?>
        <?php if (has_post_thumbnail()): ?>
            <a  href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('', $heroic_defalt_arg); ?>
            </a>
        <?php endif; ?>

    </figure>
    <div class="post-content">
        <?php if ($heroic_current_options['home_meta_section_settings'] == '') { ?>
            <div class="item-meta">
                <a class="author-image item-image" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo get_avatar(get_the_author_meta('user_email'), $size = '40'); ?></a>
                <?php echo ' '; ?><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo esc_html(get_the_author()); ?></a>
                <br>
                <a class="entry-date" href="<?php echo esc_url(get_month_link(get_post_time('Y'), get_post_time('m'))); ?>">
                    <?php echo esc_html(get_the_date()); ?></a>
            </div>
        <?php } ?>
        <header class="entry-header">
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        </header>
        <div class="entry-content">
            <?php
            $heroic_more = strpos($post->post_content, __('Read More', 'heroic'));
            if ($heroic_more) :
                echo wp_kses_post(get_the_content());
            else :
                echo '<p>' . wp_kses_post(get_the_excerpt()) . '</p>';
            endif;
            wp_link_pages();
            ?>
        </div>


        <?php if ($heroic_current_options['home_meta_section_settings'] == '') { ?>
            <hr />
            <div class="entry-meta">
                <span class="comment-links"><a href="<?php the_permalink(); ?>"><?php comments_number(esc_html__('No Comments', 'heroic'), esc_html__('One comment', 'heroic'), esc_html__('% comments', 'heroic')); ?></a></span>
                <?php
                $heroic_cat_list = get_the_category_list();
                if (!empty($heroic_cat_list)) {
                    ?>
                <span class="cat-links"><?php esc_html_e('In','heroic');?><?php the_category(' '); ?></span>
    <?php } ?>

            </div>
<?php } ?>
    </div>
</article>