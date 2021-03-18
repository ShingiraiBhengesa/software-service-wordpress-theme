<?php
/**
 * @package ciy_software_services_theme
 * 
 * Template Name: Portfolio Page
 * 
 * Page Template for the Portfolio page
 */
get_header();

if(have_posts()):
    while(have_posts()): the_post(); ?>
    <div class="showcase__header">
        <h2><?php the_title(); ?></h2>
        <h2>Hello from Portfolio page</h2>
    </div>
    <section class="section">
        <?php the_content(); ?>
    </section>
    <?php
    endwhile;
endif;
get_footer();