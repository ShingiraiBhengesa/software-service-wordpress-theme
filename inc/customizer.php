<?php
/**
 * @package ciy_software_services_theme
 * 
 * Functions for our customizer
 */

function ciy_front_page_functions($wp_customize)
{
    $wp_customize->add_section('split_screen', [
        'title' => __('Split Screen', 'ciy_software_services_theme'),
        'description'   => sprintf(__('Setup your split screen landing page')),
        'priority'      => 220
    ]);

    // Left Side picture
    $wp_customize->add_setting('left_screen', [
        'default'   => get_template_directory_uri() . '/img/coding.jpg',
        'type'      => 'theme_mod'
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'left_screen', [
        'label'     => __('Left Picture', 'ciy_software_services_theme'),
        'section'   => 'split_screen',
        'settings'  => 'left_screen',
        'priority'  => 1
    ]));

    // Left side header
    $wp_customize->add_setting('left_screen_header', [
        'default'   => _x('Our Services', 'ciy_software_services_theme'),
        'type'      => 'theme_mod'
    ]);

    $wp_customize->add_control('left_screen_header', [
        'label'     => __('Header for the left side', 'ciy_software_services_theme'),
        'section'   => 'split_screen',
        'priority'  => 2
    ]);

    // Left side button text
    $wp_customize->add_setting('left_screen_button_text', [
        'default'   => _x('Find Out More', 'ciy_software_services_theme'),
        'type'      => 'theme_mod'
    ]);

    $wp_customize->add_control('left_screen_button_text', [
        'label'     => __('Text on the left side button', 'ciy_software_services_theme'),
        'section'   => 'split_screen',
        'priority'  => 3
    ]);

    // Left side button url
    $wp_customize->add_setting('left_button_url', [
        'default'   => '',
        'type'      => 'theme_mod'
    ]);

    $wp_customize->add_control('left_button_url', [
        'description'   => sprintf(__('Choose a page')),
        'section'       => 'split_screen',
        'type'          => 'dropdown-pages',
        'priority'      => 4
    ]);

    /* =============== Right Side =============== */
    // Right Side picture
    $wp_customize->add_setting('right_screen', [
        'default'       => get_template_directory_uri() . '/img/design.jpg',
        'type'          => 'theme_mod'
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'right_screen', [
        'label'     => __('Right Picture', 'ciy_software_services_theme'),
        'section'   => 'split_screen',
        'settings'  => 'right_screen',
        'priority'  => 5
    ]));

    // Right Side Header
    $wp_customize->add_setting('right_screen_header', [
        'default'   => _x('Our Designs', 'ciy_software_services_theme'),
        'type'      => 'theme_mod'
    ]);

    $wp_customize->add_control('right_screen_header', [
        'label'     => __('Header for the right side', 'ciy_software_services_theme'),
        'section'   => 'split_screen',
        'settings'  => 'right_screen_header',
        'priority'  => 6
    ]);

    // Right side button text
    $wp_customize->add_setting('right_side_button_text', [
        'default'   => _x('Explore our designs', 'ciy_software_services_theme'),
        'type'      => 'theme_mod'
    ]);

    $wp_customize->add_control('right_side_button_text', [
        'label'     => __('Text on the right side button', 'ciy_software_services_theme'),
        'section'   => 'split_screen',
        'settings'  => 'right_side_button_text',
        'priority'  => 7
    ]);

    // Right side button url
    $wp_customize->add_setting('right_screen_button_url', [
        'default'   => '',
        'type'      => 'theme_mod'
    ]);

    $wp_customize->add_control('right_screen_button_url', [
        'description'   => sprintf(__('Choose a page')),
        'section'       => 'split_screen',
        'type'          => 'dropdown-pages',
        'priority'      => 8
    ]);

    // The logo
    $wp_customize->add_section('logo_section', [
        'title' => __('Logo', 'ciy_software_services_theme'),
        'description'   => __('Set the logo for your site'),
        'priority'      => 230
    ]);

    $wp_customize->add_setting('site_logo', [
        'default'   => get_template_directory_uri() . '/img/logo.png',
        'type'      => 'theme_mod'
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'site_logo', [
        'label'     => __('Your Logo', 'ciy_software_services_theme'),
        'section'   => 'logo_section',
        'setting'   => 'site_logo',
        'priority'  => 1
    ]));

    /* === Footer Section === */
    $wp_customize->add_section('footer_section', [
        'title'     => __('Footer', 'ciy_software_services_theme'),
        'description'   => sprintf(__('Setup your footer')),
        'priority'  => 240
    ]);

    $wp_customize->add_setting('social_media_links', [
        'default'   => _x('<i class="fab fa-facebook-square"></i>', 'ciy_software_services_theme'),
        'type'      => 'theme_mod'
    ]);

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'social_media_links', [
        'label' => __('Social Media Links', 'ciy_software_services_theme'),
        'description'   => sprintf(__('Pick a social media icon')),
        'section'   => 'footer_section',
        'priority'  => 1,
        'type'  => 'select',
        'choices'   => [
            'default'   => 'Facebook',
            '<i class="fab fa-facebook-square"></i>' => 'Facebook',
            '<i class="fab fa-twitter-square"></i>' => 'Twitter',
            '<i class="fab fa-instagram-square"></i>'   => 'Instagram',
            '<i class="fab fa-pinterest-square"></i>'   => 'Pinterest'
        ]
    ]));

    $wp_customize->add_setting('social_media_url_one', [
        'default'   => _x('http://www.facebook.com', 'ciy_software_services_theme'),
        'type'  => 'theme_mod'
    ]);

    $wp_customize->add_control('social_media_url_one', [
        'description'   => sprintf(__('Your social media url', 'ciy_software_services_theme')),
        'section'   => 'footer_section',
        'priority'  => 2
    ]);

    $wp_customize->add_setting('social_media_links_two', [
        'default'   => _x('<i class="fab fa-twitter-square"></i>', 'ciy_software_services_theme'),
        'type'      => 'theme_mod'
    ]);

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'social_media_links_two', [
        'label' => __('Social Media Links', 'ciy_software_services_theme'),
        'description'   => sprintf(__('Pick a social media icon')),
        'section'   => 'footer_section',
        'priority'  => 2,
        'type'  => 'select',
        'choices'   => [
            'default'   => 'Twitter',
            '<i class="fab fa-facebook-square"></i>' => 'Facebook',
            '<i class="fab fa-twitter-square"></i>' => 'Twitter',
            '<i class="fab fa-instagram-square"></i>'   => 'Instagram',
            '<i class="fab fa-pinterest-square"></i>'   => 'Pinterest'
        ]
    ]));

    $wp_customize->add_setting('social_media_url_two', [
        'default'   => _x('http://www.twitter.com', 'ciy_software_services_theme'),
        'type'  => 'theme_mod'
    ]);

    $wp_customize->add_control('social_media_url_two', [
        'description'   => sprintf(__('Your social media url', 'ciy_software_services_theme')),
        'section'   => 'footer_section',
        'priority'  => 3
    ]);

    $wp_customize->add_setting('social_media_links_three', [
        'default'   => _x('<i class="fab fa-instagram-square"></i>', 'ciy_software_services_theme'),
        'type'      => 'theme_mod'
    ]);

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'social_media_links_three', [
        'label' => __('Social Media Links', 'ciy_software_services_theme'),
        'description'   => sprintf(__('Pick a social media icon')),
        'section'   => 'footer_section',
        'priority'  => 4,
        'type'  => 'select',
        'choices'   => [
            'default'   => 'Instagram',
            '<i class="fab fa-facebook-square"></i>' => 'Facebook',
            '<i class="fab fa-twitter-square"></i>' => 'Twitter',
            '<i class="fab fa-instagram-square"></i>'   => 'Instagram',
            '<i class="fab fa-pinterest-square"></i>'   => 'Pinterest'
        ]
    ]));

    $wp_customize->add_setting('social_media_url_three', [
        'default'   => _x('http://www.instagram.com', 'ciy_software_services_theme'),
        'type'  => 'theme_mod'
    ]);

    $wp_customize->add_control('social_media_url_three', [
        'description'   => sprintf(__('Your social media url', 'ciy_software_services_theme')),
        'section'   => 'footer_section',
        'priority'  => 5
    ]);

    $wp_customize->add_setting('social_media_links_four', [
        'default'   => _x('<i class="fab fa-pinterest-square"></i>', 'ciy_software_services_theme'),
        'type'      => 'theme_mod'
    ]);

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'social_media_links_four', [
        'label' => __('Social Media Links', 'ciy_software_services_theme'),
        'description'   => sprintf(__('Pick a social media icon')),
        'section'   => 'footer_section',
        'priority'  => 6,
        'type'  => 'select',
        'choices'   => [
            'default'   => 'Pinterest',
            '<i class="fab fa-facebook-square"></i>' => 'Facebook',
            '<i class="fab fa-twitter-square"></i>' => 'Twitter',
            '<i class="fab fa-instagram-square"></i>'   => 'Instagram',
            '<i class="fab fa-pinterest-square"></i>'   => 'Pinterest'
        ]
    ]));

    $wp_customize->add_setting('social_media_url_four', [
        'default'   => _x('http://www.pinterest.com', 'ciy_software_services_theme'),
        'type'  => 'theme_mod'
    ]);

    $wp_customize->add_control('social_media_url_four', [
        'description'   => sprintf(__('Your social media url', 'ciy_software_services_theme')),
        'section'   => 'footer_section',
        'priority'  => 7
    ]);
}
add_action('customize_register', 'ciy_front_page_functions');