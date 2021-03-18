<?php
/**
 * @package ciy_software_services_theme
 * 
 * The front page for the theme
 */

get_header();
?>
<div class="container">
    <div class="split left" style="background: url(<?php echo get_theme_mod('left_screen', get_template_directory_uri() . '/img/coding.jpg'); ?>) center center no-repeat;background-size: cover;">
        <h1><?php echo get_theme_mod('left_screen_header', 'Our Services'); ?></h1>
        <a href="<?php the_permalink(get_theme_mod('left_button_url')); ?>" class="button" onclick="void(0)"><?php echo get_theme_mod('left_screen_button_text', 'Find Out More'); ?></a>
    </div>
    <div class="split right" style="background: url(<?php echo get_theme_mod('right_screen', get_template_directory_uri() . '/img/design.jpg'); ?>) center center no-repeat; background-size: cover;">
        <h1><?php echo get_theme_mod('right_screen_header', 'Our Designs'); ?></h1>
        <a href="<?php the_permalink(get_theme_mod('right_screen_button_url')); ?>" class="button" onclick="void(0)"><?php echo get_theme_mod('right_side_button_text', 'Explore Our Designs'); ?></a>
    </div>
</div>


<?php get_footer();