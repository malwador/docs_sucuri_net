<?php if ( kbg_get( 'archive_content' ) ) : ?>

	<div class="kbg-section mb--xxl negative-margin kbg-archive-section">
		<div class="container">
			<div class="row align-items-center <?php echo esc_attr( kbg_get( 'archive_class' ) ); ?>">
				<div class="col-12 col-md-12">

					<?php if ( kbg_get( 'archive_avatar' ) ) : ?>
						<div class="author-archive clearfix d-flex align-items-center">
						<div class="author-avatar">
							<?php kbg_wp_kses( kbg_get( 'archive_avatar' ), true ); ?>
						</div>
						<div class="author-title">
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

					<?php if ( kbg_get( 'archive_avatar' ) ) : ?>
					</div>
						</div>
					<?php endif; ?>

					<?php if ( kbg_get( 'archive_description' ) ) : ?>
						<div class="section-description mt--md">
							<?php echo wpautop( kbg_get( 'archive_description' ) ); ?>
						</div>
					<?php endif; ?>

				</div>
			
			</div>
		</div>
	</div>

<?php endif; ?>

<div class="kbg-after-subheader"></div>

<?php get_template_part( 'template-parts/post/archive/loop' ); ?>
