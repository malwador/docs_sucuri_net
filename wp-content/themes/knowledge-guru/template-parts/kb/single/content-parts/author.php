<div class="kbg-author-box kbg-card kbg-card-single mb--xxl">

    <div class="author-item">

    <div class="d-md-flex align-items-center">
            
        <div class="author-avatar">
            <?php echo get_avatar(get_the_author_meta('ID'), 70 ); ?>
        </div>

        <div class="author-title">
                <span class="text-small d-block"><?php echo kbg_wp_kses(__kbg('author_box_label')); ?></span>
                <h6 class="h2 mb--0 mt--0">
                    <?php global $authordata; ?>
                    <a href="<?php echo esc_url(get_author_posts_url($authordata->ID, $authordata->user_nicename)); ?>">
                        <?php echo get_the_author_meta('display_name'); ?>
                    </a>
                </h6>
        </div>


    </div>

        <div class="author-content">
            

            <div class="author-description mb--lg">
                <?php echo wpautop(get_the_author_meta('description')); ?>
            </div>

            <div class="social-icons-clean">
                <?php echo kbg_get_author_links( get_the_author_meta('ID'), true, false ); ?>
            </div>

        </div>

    </div>

</div>