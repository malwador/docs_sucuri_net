<?php get_header(); ?>


    <div class="kbg-section negative-margin d-flex align-items-center justify-content-center kbg-section-404">

        <?php if ( kbg_get( '404_image' ) ) : ?>
            <div class="entry-media entry-media-404">
                <img src="<?php echo esc_url( kbg_get( '404_image' ) ); ?>" alt="404-image" > 
            </div>
        <?php endif; ?>
        
        <div class="container kbg-card-404 ImageFlex">
            <div class="row">
                <div class="404-image col-12 offset-md-8 col-md-3">
                    <div class="imageContainer">
                        <img src="<?php echo get_template_directory_uri()?>/assets/img/ConfusedWAFfy.svg">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="kbg-card kbg-card-p col-12 col-md-12 offset-lg-2 col-lg-8 col-xl-8">			
                        
                    <h1 class="mb--sm"><?php echo esc_html( kbg_get( 'title' ) ); ?></h1>

                    <p>Oops! Seems WAFfy was unable to find the page your are looking for. You may have accidentally mistyped the page address, or followed an expired link. Anyway, we will help you get back on track. Why not try to search for the page you were looking for:</p>
                    
                    <?php get_search_form(); ?>
        
                </div>
            </div>

        </div>

    </div>



<?php get_footer(); ?>