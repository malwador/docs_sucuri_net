<?php if ( current_user_can( 'manage_options' ) ): ?>
		<nav class="empty-list">
			<ul class="kbg-menu">
				<li>
					<a href="<?php echo esc_url( admin_url( 'nav-menus.php' )); ?>">
					<?php esc_html_e( 'Click here to add menu', 'knowledge-guru' ); ?>
					</a>
				</li>
			</ul>
		</nav>
<?php endif; ?>