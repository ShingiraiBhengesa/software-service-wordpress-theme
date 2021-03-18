<?php
/**
 * @package ciy_software_services_theme
 * 
 * Single post page
 */
get_header();

if(have_posts()) :
    while(have_posts()) : the_post(); ?>
        <h2><?php the_title(); ?></h2>
        <h2>Hello from single.php</h2>
        <p><?php the_content(); ?></p>
    <?php
    endwhile;
endif;
get_footer();