<?php $footer_widgets = kbg_get( 'footer', 'widgets' ); ?>

<?php if ( !empty( $footer_widgets ) && kbg_has_footer_widgets() ): ?>
	<div class="row kbg-footer-widgets justify-content-center <?php echo esc_attr( kbg_get( 'footer', 'widgets_style' ) ); ?>">
		<?php foreach ( $footer_widgets as $i => $column ) : ?>
	        <?php if ( is_active_sidebar( 'kbg_sidebar_footer_'.( $i+1 ) ) ): ?>
				<div class="col-12 col-md-6 <?php echo esc_attr( 'col-lg-' . $column ); ?>">
		            <?php dynamic_sidebar( 'kbg_sidebar_footer_'.( $i+1 ) ); ?>
	            </div>
	        <?php endif; ?>
	    <?php endforeach; ?>
	</div>
	<div class="footer-separator d-block <?php echo esc_attr( kbg_get( 'footer', 'widgets_style' ) ); ?>"></div>
<?php endif; ?>
