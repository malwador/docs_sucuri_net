<?php if ( kbg_get( 'archive_avatar' ) ) : ?>
	<div class="author-archive clearfix d-flex align-items-center">
	<div class="author-avatar">
		<?php kbg_wp_kses( kbg_get( 'archive_avatar' ), true ); ?>
	</div>
	<div class="author-title">
<?php endif; ?>

<?php if ( kbg_get( 'has_icon' ) ) : ?>
	<?php if ( $fimg = kbg_get_category_featured_image( 'kbg-category-list-icon', false, 'icon' ) ): ?>
		<div class="category-icon d-flex align-items-center">
			<a href="<?php the_permalink(); ?>"><?php echo kbg_wp_kses( $fimg ); ?></a>
		<div>
    <?php endif; ?>
<?php endif; ?>

<?php if ( kbg_get( 'archive_title' ) ) : ?>
	<h1 class="h1 mb--0"><?php kbg_wp_kses( kbg_get( 'archive_title' ), true ); ?></h1>
<?php endif; ?>

<?php if ( kbg_get( 'archive_meta' ) ) : ?>
	<div class="section-meta">
		<span class="meta-item">
			<span class="section-meta--number"><?php echo esc_html( kbg_get( 'archive_meta' ) ); ?></span>
			<?php echo esc_html( __kbg( 'articles' ) ); ?>
		</span>
	</div>
<?php endif; ?>

<?php if ( kbg_get( 'has_icon' ) ) : ?>
	<?php if ( $fimg = kbg_get_category_featured_image( 'kbg-category-list-icon', false, 'icon' ) ): ?>
		</div>
		</div>
    <?php endif; ?>
<?php endif; ?>

<?php if ( kbg_get( 'archive_avatar' ) ) : ?>
</div>
	</div>
<?php endif; ?>

<?php if ( kbg_get( 'archive_description' ) ) : ?>
	<div class="section-description mt--md">
		<?php echo wpautop( kbg_get( 'archive_description' ) ); ?>
	</div>
<?php endif; ?>
