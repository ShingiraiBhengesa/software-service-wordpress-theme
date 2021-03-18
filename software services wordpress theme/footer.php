<?php
/**
 * @package ciy_software_services_theme
 * 
 * The footer for our theme
 */
if(!is_front_page()):
?>
<footer>
    <div class="footer_nav">
        <?php
            wp_nav_menu([
                'theme_location'    => 'footer_services_navbar'
            ]);
        ?>
    </div>
    <div class="footer_social">
        <h2>Social Media</h2>
        <a href="<?php echo get_theme_mod('social_media_url_one', '#'); ?>"><?php echo get_theme_mod('social_media_links', '<i class="fab fa-facebook-square"></i>'); ?></a>
        <a href="<?php echo get_theme_mod('social_media_url_two', '#'); ?>"><?php echo get_theme_mod('social_media_links_two', '<i class="fab fa-twitter-square"></i>'); ?></a>
        <a href="<?php echo get_theme_mod('social_media_url_three', '#'); ?>"><?php echo get_theme_mod('social_media_links_three', '<i class="fab fa-instagram-square"></i>'); ?></a>
        <a href="<?php echo get_theme_mod('social_media_url_four', '#'); ?>"><?php echo get_theme_mod('social_media_links_four', '<i class="fab fa-pinterest-square"></i>'); ?></a>
    </div>
    <div class="footer_logo">
        <a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo get_theme_mod('site_logo', get_template_directory_uri() . '/img/logo.png'); ?>"></a>
    </div>
</footer>
<?php 
endif;
wp_footer(); ?>
</div>
</body>
</html>