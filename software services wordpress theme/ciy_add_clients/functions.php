<?php
/**
 * @package ciy_client_manager
 * 
 * Functions for the plugin
 */

// Enqueue scripts and stylesheets
function ciy_clients_scripts()
{
    wp_enqueue_style('ciy_clients_style', plugin_dir_url(__FILE__) . 'assets/ciy_client_style.css', array(), '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', 'ciy_clients_scripts');

// Register the post type
function setup_client_post_type()
{
    register_post_type('client',
    [
        'labels'    => [
            'name'  => __('Clients'),
            'singular_name' => __('Client'),
            'add_new'  => __('Add New Client'),
            'add_new_item'  => __('Add New Client'),
            'edit_item' => __('Edit Client'),
            'search_items'  => __('Search Clients')
        ],
        'menu_position' => 5,
        'public'    => true,
        'exclude_from_search'   => true,
        'has_archive'   => true,
        'rewrite'   => array('slug' => 'client'),
        'register_meta_box_cd'  => 'example_metabox',
        'menu_icon' => 'dashicons-admin-users',
        'show_in_rest'  => true,
        'supports'  => [
            'title', 'editor', 'thumbnail'
        ]
    ]);
}
add_action('init', 'setup_client_post_type');

// Add shortcode
function get_client_post_type()
{
    $args = [
        'posts_per_page'    => -1,
        'post_type' => 'client'
    ];

    $content = '';
    $loop = new WP_QUERY($args);

    if($loop->have_posts()): 
        $content .= '<section class="ciy_section section_clients">';
        $content .= '<h2>Clients</h2>';
        $content .= '<ul>';
        while($loop->have_posts()) : $loop->the_post();
            $content .= '<li>';
            $content .= '<div class="flip_card">';
            $content .= '<div class="flip_card_inner">';
            $content .= '<div class="flip_card_front">';
            $content .= get_the_post_thumbnail();
            $content .= '</div>';
            $content .= '<div class="flip_card_back">';
            $content .= '<h2>'.get_the_title().'</h2>';
            $content .= '<p>'.get_the_content().'</p>';
            $content .= '</div>';
            $content .= '</div>';
            $content .= '</div>';
            $content .= '</li>';
        endwhile;    
        $content .= '</ul>';
        $content .= '</section>';
    endif;
    wp_reset_postdata();

    return $content;
}
add_shortcode('ciy-clientposts', 'get_client_post_type');

// Installation of function
function client_post_type_install()
{
    setup_client_post_type();

    // Clear the permalinks after the post type has been registered
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'client_post_type_install');

// Deactivate the plugin
function client_post_type_deactivate()
{
    unrgister_post_type('client');
    // Clear the permalinks
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'client_post_type_deactivate');

// Uninstall the plugin
function client_post_type_uninstall()
{
    if(!defined('WP_UNINSTALL_PLUGIN'))
    {
        die;
    }

    global $wpdb;
    $wpdb->query("DELETE FROM wp_posts WHERE post_type = client");
    $wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN(SELECT id FROM wp_posts)");
    $wpdb->query("DELETE FROM wp_term_relationship WHERE object_id NOT IN(SELECT id FROM wp_posts)");
}
register_uninstall_hook(__FILE__, 'client_post_type_uninstall');

