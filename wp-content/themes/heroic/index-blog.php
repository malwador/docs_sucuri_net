<?php
$heroic_parent_current_options = wp_parse_args(get_option('quality_pro_options', array()), quality_theme_data_setup());
?>
<section id="section-block" class="news">
    <div class="container">
        <?php if (($heroic_parent_current_options['blog_heading']) || ($heroic_parent_current_options['home_blog_description'] != '' )) { ?>
            <div class="row">
                <div class="section-header">			
                    <?php if ($heroic_parent_current_options['blog_heading']) { ?>
                        <p><?php echo wp_kses_post($heroic_parent_current_options['blog_heading']); ?></p>
                    <?php } if ($heroic_parent_current_options['home_blog_description']) { ?>
                        <h1 class="widget-title"><?php echo wp_kses_post($heroic_parent_current_options['home_blog_description']); ?></h1>
                    <?php } ?>
                    <hr class="divider">
                </div>
            </div>
        <?php } ?>
        <!--Blog Content-->
        <?php 
        $heroic_current_options= wp_parse_args(get_option('quality_pro_options', array()), heroic_default_data());
        if ($heroic_current_options['blog_masonry4_layout_setting'] == 'masonry4') {
            heroic_blog_masonry4_layout();
        } else {
            heroic_blog_default_layout();
        }?>        	
    </div>
</section>