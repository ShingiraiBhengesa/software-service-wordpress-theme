<?php
/**
 * @package ciy_software_services_theme
 * 
 * Template Name: About Page
 * 
 * Page Template for the About page
 */
get_header();

if(have_posts()):
    while(have_posts()): the_post(); ?>
    <div class="showcase__header">
        <?php the_post_thumbnail(); ?>
        <h2><?php the_title(); ?></h2>
        <h2>Hello from About page</h2>
    </div>
    <section class="section">
        <?php the_content(); ?>
    </section>
    <?php
    endwhile;
endif;
get_footer();