<?php if ( kbg_get( 'footer', 'widgets' ) && kbg_is_active_footer_widgets() ) : ?>
    <div class="row">
        <div class="col-12">
            <div class="kbg-copyright-separator <?php echo esc_attr( kbg_get( 'footer', 'widgets_style' ) ); ?>"></div>
        </div>
    </div>
<?php endif; ?>


<?php if ( kbg_get( 'footer', 'display_copyright_and_menu' ) ) : ?>
    <div class="row kbg-copyright <?php echo esc_attr( kbg_get( 'footer', 'widgets_style' ) ); ?>">  

        <?php if ( kbg_get( 'footer', 'copyright_menu' ) ) : ?>
            <div class="footer-aside">
                <?php get_template_part( 'template-parts/general/footer/copyright-menu' ); ?>
            </div>

        <?php endif; ?>

        <!-- <?php if ( kbg_get( 'footer', 'copyright' ) ) : ?>
            <div class="col-12 col-md-12 col-lg-6 justify-content-lg-end <?php echo esc_attr( kbg_get( 'footer', 'copyright_align_class' ) ); ?>">
                <?php get_template_part( 'template-parts/general/footer/copyright-text' ); ?>
            </div>
        <?php endif; ?> -->
    </div>

<?php endif; ?>