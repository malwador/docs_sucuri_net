<?php get_header(); ?>

<?php if( have_posts() ) : ?>
    <?php while( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'template-parts/'. kbg_get( 'type' ) . '/single/layouts/' . kbg_get('layout') ); ?>
    <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>