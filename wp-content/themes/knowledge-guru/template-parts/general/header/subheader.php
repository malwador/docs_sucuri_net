<?php if ( kbg_has_subheader() ) : ?>

    <div class="kbg-single-subheader d-lg-flex d-none align-items-center">
        <div class="container">
            <div class="row">

                <?php if ( kbg_get( 'subheader_left' ) != 'none' ) : ?>
                    <div class="subheader-left col">
                        <div class="d-flex justify-content-start">
                            <?php get_template_part('template-parts/general/header/elements/' . kbg_get( 'subheader_left' ) ); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ( kbg_get( 'subheader_right' ) != 'none' ) : ?>
                    <div class="subheader-right col">
                        <div class="d-flex justify-content-end">
                            <?php get_template_part('template-parts/general/header/elements/'. kbg_get( 'subheader_right' ) ); ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

<?php endif; ?>
