<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>

    
</head>

<body <?php body_class(); ?>>
	<?php doGoogleTagManager2025_body(); ?>

	<?php if (  function_exists( 'wp_body_open' ) ): ?>
		<?php wp_body_open(); ?>
	<?php else : ?>
		<?php do_action( 'wp_body_open' ); ?>
	<?php endif; ?>

	<?php if ( kbg_get( 'display', 'header' ) ): ?>

		<header id="kbg-header" class="kbg-header header-main d-none d-lg-block">
			<?php  if ( kbg_get( 'header', 'top' ) ): ?>
				<?php  get_template_part( 'template-parts/general/header/top' ); ?>
			<?php  endif; ?>

			<?php get_template_part( 'template-parts/general/header/layout-' . kbg_get( 'header', 'layout' ) ); ?>

			<?php get_template_part( 'template-parts/general/header/subheader' ); ?>
		</header>


		<?php get_template_part( 'template-parts/general/header/mobile' ); ?>

		<?php if ( kbg_get( 'header', 'sticky' ) ): ?>
			<?php get_template_part( 'template-parts/general/header/sticky' ); ?>
		<?php endif; ?>

	<?php endif; ?>
