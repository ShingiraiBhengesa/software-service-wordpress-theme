<?php
/**
 * @package ciy_software_services_theme
 * 
 * Create all the menus here
 */

// Custom Navigation bars
function add_navbar()
{
    register_nav_menus(
        [
            'ciy_navbar'    => __('Main CIY Navbar'),
            'footer_services_navbar'    => __('CIY Footer Navbar')
        ]
    );
}
add_action('init', 'add_navbar');