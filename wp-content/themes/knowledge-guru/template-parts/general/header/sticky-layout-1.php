<div class="header-middle">
    <div class="container">
        <div class="row">
            
            <div class="header-main-slot-l col">
                <?php get_template_part('template-parts/general/header/elements/branding-sticky'); ?>
            </div>

            <div class="header-main-slot-r col d-flex justify-content-end align-items-center">
                
                <div class="d-none d-lg-flex align-items-center">
                    <?php if( kbg_get('header', 'sticky_nav') ): ?>
                         <?php get_template_part('template-parts/general/header/elements/menu-primary'); ?>
                    <?php endif; ?>

                    <?php if( kbg_get('header', 'sticky_actions') ): ?>
                        <?php foreach( kbg_get('header', 'sticky_actions') as $element ): ?>
                            <?php get_template_part('template-parts/general/header/elements/' . $element ); ?>
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