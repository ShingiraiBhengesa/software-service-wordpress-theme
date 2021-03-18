<?php
/**
 * @package ciy_software_services_theme
 * 
 * Takes in all of our page templates
 */

get_header();
if(have_posts()):
    while(have_posts()): the_post(); 
    $url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
    ?>
    <div class="overlay">
        <?php 
            echo '<div class="showcase__img" style="background-image: url('.$url.')">';
        ?>
        <div class="showcase__header">
            <h2><?php the_title(); ?></h2>
        </div>
</div>
    </div>
        <section class="ciy_content_standard">
            <?php the_content(); ?>    
        </section>
    <?php 
    endwhile;
endif;
get_footer();