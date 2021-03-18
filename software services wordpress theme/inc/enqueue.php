<?php
/**
 * @package ciy_software_services_theme
 * 
 * All stylesheets and scripts for the theme
 */

function load_scripts($hook)
{
    wp_enqueue_style('ciy_style', get_template_directory_uri() . '/assets/css/ciy_style.css', array(), '1.0.0', 'all');
    wp_enqueue_script('ciy_scripts', get_template_directory_uri() . '/assets/js/ciy_scripts.js', array(), '1.0.0', true);
    wp_enqueue_script('ciy_font_awesome', 'https://kit.fontawesome.com/40c199a931.js');
}
add_action('wp_enqueue_scripts', 'load_scripts');