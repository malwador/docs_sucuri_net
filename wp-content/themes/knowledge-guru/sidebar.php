<aside class="kbg-sidebar row <?php echo esc_attr( kbg_get( 'sidebar_class' ) ); ?>">
    <?php $sidebar = kbg_get( 'sidebar' ); ?>
    
    <?php  if ( isset( $sidebar['classic'] ) && is_active_sidebar( $sidebar['classic'] ) ): ?>
        
            <?php dynamic_sidebar( $sidebar['classic'] ); ?>
 
    <?php endif; ?>

    <?php  if ( isset( $sidebar['sticky'] ) && is_active_sidebar( $sidebar['sticky'] ) ): ?>
        <div class="kbg-sticky">
            <?php dynamic_sidebar( $sidebar['sticky'] ); ?>
        </div>
    <?php endif; ?>

</aside>