<?php
/**
 * @package ciy_testimonials_manager
 * 
 * Functions for the plugin
 */
// Enqueue scripts and stylesheets
function ciy_testimonials_script()
{
    wp_enqueue_style('ciy_testimonials_style', plugin_dir_url(__FILE__) . 'assets/ciy_testimonials_style.css', array(), '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', 'ciy_testimonials_script');

// Installation of the plugin
function testimonial_post_type_install()
{
    setup_testimonial_post_type('testimonial');
    // CLear permalinks
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'testimonial_post_type_install');

// Deactivate the plugin
function testimonial_post_type_deactivate()
{
    unregister_post_type('testimonial');
    // Clear permalinks
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'testimonial_post_type_deactivate');

// Uninstall the plugin
function testimonial_post_type_uninstall()
{
    if(!defined('WP_UNINSTALL_PLUGIN'))
    {
        die;
    }

    global $wpdb;
    $wpdb->query("DELETE FROM wp_posts WHERE post_type = 'testimonial'");
    $wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN(SELECT id FROM wp_posts)");
    $wpdb->query("DELETE FROM wp_term_relationship WHERE object_id NOT IN(SELECT id FROM wp_posts)");
}
register_uninstall_hook(__FILE__, 'testimonial_post_type_uninstall');

// Register testimonials custom post type
function setup_testimonial_post_type()
{
    register_post_type('testimonial',
    [
        'labels'    => [
            'name'  => __('Testimonials'),
            'singular_name' => __('Testimonial'),
            'add_new'   => __('Add New Testimonial'),
            'add_new_item'  => __('Add New Testimonial'),
            'edit_item' => __('Edit Testimonial'),
            'search_items'  => __('Search Testimonials')
        ],
        'menu_position' => 6,
        'public'    => true,
        'exclude_from_search'   => true,
        'has_archive'   => true,
        'rewrite'   => ['slug' => 'testimonial'],
        'register_meta_box_cd'  => 'example_metabox',
        'menu_icon' => 'dashicons-admin-users',
        'show_in_rest'  => true,
        'supports'  => [
            'title', 'editor', 'thumbnail', 'author'
        ]
    ]);
}
add_action('init', 'setup_testimonial_post_type');

// Add shortcode
function get_testimonial_post_type()
{
    $args = [
        'posts_per_page'    => -1,
        'post_type' => 'testimonial'
    ];

    $string = '';
    $loop = new WP_Query($args);

    if($loop->have_posts()) :
        $string .= '<section class="section section_testimonials">';
        $string .= '<h2>Testimonials</h2>';
        $string .= '<ul>';
        while($loop->have_posts()) : $loop->the_post();
            $string .= '<li>';
            $string .= '<div class="testimonials_flip_card">';
            $string .= '<div class="testimonials_flip_card_inner">';
            $string .= '<div class="testimonials_flip_card_front">';
            $string .= get_the_post_thumbnail();
            $string .= '</div>';
            $string .= '<div class="testimonials_flip_card_back">';
            $string .= '<h2>'.get_the_title().'</h2>';
            $string .= '<p>'.get_the_content().'</p>';
            $string .= '</div>';
            $string .= '</div>';
            $string .= '</div>';
            $string .= '</li>';
        endwhile;
        $string .= '</ul>';
        $string .= '</section>';
    endif;
    wp_reset_postdata();
    return $string;
}
add_shortcode('ciy-testimonialposts', 'get_testimonial_post_type');