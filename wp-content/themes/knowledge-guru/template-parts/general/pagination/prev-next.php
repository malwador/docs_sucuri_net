<?php if( get_the_posts_pagination() ) : ?>
    <div class="col-12 text-center kbg-order-2 kbg-pagination-main plr--0">
        <nav class="kbg-pagination prev-next nav-links">
            <div class="prev">
                <?php if( get_previous_posts_link() ) : ?>
                    <?php previous_posts_link( __kbg( 'newer_entries' ) ); ?>
                <?php else: ?>
                    <a href="javascript:void(0);" class="kbg-button-text disabled"><?php echo esc_html( __kbg( 'newer_entries' ) ); ?></a>
                <?php endif; ?>
            </div>
            <div class="next">
                <?php if( get_next_posts_link() ) : ?>
                    <?php next_posts_link( __kbg( 'older_entries' ) ); ?>
                <?php else: ?>
                    <a href="javascript:void(0);" class="kbg-button-text disabled"><?php echo esc_html( __kbg( 'older_entries' ) ); ?></a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
<?php endif; ?>