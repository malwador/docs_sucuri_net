<div class="header-middle">
    <div class="container">
        <div class="row">
            
            <div class="header-main-slot-l col">
                <?php get_template_part('template-parts/general/header/elements/branding'); ?>
            </div>

            <div class="header-main-slot-r col d-flex justify-content-end align-items-center">
                
                <?php if( kbg_get('header', 'nav') ): ?>
                    <?php get_template_part('template-parts/general/header/elements/menu-primary'); ?>
                <?php endif; ?>

                <?php if( kbg_get('header', 'actions') ): ?>
                    <?php foreach( kbg_get('header', 'actions') as $element ): ?>
                        <?php get_template_part('template-parts/general/header/elements/' . $element ); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>