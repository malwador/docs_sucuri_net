<div class="header-middle header-layout-3">
	<div class="container">

		<div class="row h-100 align-items-center">


			<div class="header-main-slot-l col d-flex align-items-center">
				
				<?php get_template_part( 'template-parts/general/header/elements/branding' ); ?>
			
				<div class="header-main-slot-c col d-lg-flex custom-header justify-content-left d-none">
					<?php if ( kbg_get( 'header', 'nav' ) ) : ?>
						<?php get_template_part( 'template-parts/general/header/elements/menu-primary' ); ?>
					<?php endif; ?>

					<div class="float-right-next">
						<div class="nav-bar ua-lg">
						<ul class="nav">
							<li>
							<a href="https://sucuri.net/website-security-platform/help-now/" class="mp-under-attack-button u-attack auto-track" data-gatrack="Button_Click, Top_Nav_Under_Attack">Immediate Help</a>
							</li>
						</ul>
						</div>
						<div class="nav-bar plt">
						<div class="login">
							<a href="https://dashboard.sucuri.net/login/" class="login mp-login-btn auto-track" data-gatrack="Button_Click, Top_Nav_Login">Login</a>
							<img data-gatrack="Button_Click, Top_Nav_Login" src="<?php echo get_template_directory_uri()?>/assets/img/account.svg">
							<div class="login-drop-down inner-nav-bar">
							<i class="pointer"></i>
							<div class="login-container">
								<a href="https://dashboard.sucuri.net/login" class="login-btn" data-gatrack="Button_Click, Top_Nav_Login">Login</a>
								<div class="sign-up">
								<p>New Customer? </p>
								<a href="https://sucuri.net/website-security-platform/signup/">Sign up now.</a>
								</div>
								<ul>
								<li><a href="https://support.sucuri.net/support/?new" class="login-link">Submit a ticket</a></li>
								<li><a href="https://docs.sucuri.net/" class="login-link">Knowledge base</a></li>
								<li><a href="https://sucuri.net/live-chat/" class="login-link">Chat now</a></li>
								</ul>
							</div>
							</div>
						</div>
						</div>
					</div>
				</div>

			</div>

			<div class="header-main-slot-r col sm-flex align-items-center justify-content-end">

				<div class="d-none d-lg-block">
					<?php if ( kbg_get( 'header', 'sticky_actions' ) ) : ?>
						<?php foreach ( kbg_get( 'header', 'sticky_actions' ) as $element ) : ?>
							<?php get_template_part( 'template-parts/general/header/elements/' . $element ); ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>

				<div class="d-lg-none">                
				    <?php get_template_part( 'template-parts/general/header/elements/hamburger' ); ?>
				</div>
			</div>
		</div>

	</div>
</div>