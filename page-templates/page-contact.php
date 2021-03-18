<?php
/**
 * @package ciy_software_services_theme
 * 
 * Template Name: Contact Page
 * 
 * Page Template for the Contact page
 */
get_header();

if(have_posts()):
    while(have_posts()): the_post(); ?>
    <div class="showcase__header">
        <?php the_post_thumbnail(); ?>
        <h2><?php the_title(); ?></h2>
    </div>
    <section class="section">
        <?php the_content(); ?>
    </section>
    <?php
    endwhile;
endif;
get_footer();

