<?php
/**
 * @package ciy_services_plugin
 * 
 * Functions for our services plugin
 */

// Enqueue our files
function my_services_scripts() 
{
    wp_enqueue_style('ciy_services_style', plugin_dir_url(__FILE__) . 'assets/css/style.css', array(), '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', 'my_services_scripts');

// Register services post type
function setup_services_post_type()
{
    register_post_type('services',
    [
        'labels'    => [
            'name'  => __('Services'),
            'singular_name' => __('Service'),
            'add_new'   => __('Add New Service'),
            'add_new_item'  => __('Add New Service'),
            'edit_item' => __('Edit Service'),
            'search_items'  => __('Search Services')
        ],
        'menu_position' => 6,
        'public'    => true,
        'exclude_from_search'   => true,
        'has_archive'   => true,
        'rewrite'   => ['slug' => 'service'],
        'register_meta_box_cd'  => 'ciy_services_add_meta_box',
        'menu_icon' => 'dashicons-admin-users',
        'show_in_rest'  => true,
        'supports'  => ['title', 'editor', 'thumbnail']
    ]);
}
add_action('init', 'setup_services_post_type');

// Create new columns
function ciy_set_services_columns($columns)
{
    $new_columns = [];
    $new_columns['title'] = 'Services';
    $new_columns['price'] = 'Price';
    $new_columns['message'] = 'Description';
    return $new_columns;
}
add_filter('manage_services_posts_columns', 'ciy_set_services_columns');

function ciy_services_columns($column, $post_id)
{
    switch($column)
    {
        case 'message' :
            echo get_the_excerpt();
        break;
        case 'price' : 
            $price = get_post_meta($post_id, 'ciy_services_field', true);
            echo $price;
        break;       
    }
}
add_action('manage_services_posts_custom_column', 'ciy_services_columns', 10, 2);

function ciy_services_add_meta_box()
{
    add_meta_box('services_price', __('The Price'), 'ciy_services_price_callback', 'services', 'normal', 'high');
}
add_action('add_meta_boxes', 'ciy_services_add_meta_box');

function ciy_services_price_callback()
{
    global $post;
    $price = get_post_meta($post->ID, 'ciy_services_field', true);
    ?>
    <label for="ciy_services_field">Services Price</label>
    <input type="text" id="ciy_services_field" name="ciy_services_field" size="25" value="<?php print $price; ?>">
    <?php
}

// Add to Database
function ciy_save_services_price_data($post_id)
{
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);

    if($is_autosave || $is_revision)
    {
        return;
    }

    $post = get_post($post_id);
    if($post->post_type == "services")
    {
        // Save the price field data
        if(array_key_exists('ciy_services_field', $_POST))
        {
            update_post_meta($post_id, 'ciy_services_field', $_POST['ciy_services_field']);
        }
    }
}
add_action('save_post', 'ciy_save_services_price_data');

// Add Shortcode
function get_services_post_type()
{
    $args = [
        'posts_per_page'    => -1,
        'post_type' => 'services'
    ];

    $string = '';
    $loop = new WP_Query($args);

    if($loop->have_posts()) : 
        $string .= '<section class="section section_services">';
        $string .= '<h2>My Services</h2>';
        $string .= '<ul>';
        while($loop->have_posts()) : $loop->the_post();
            $price = get_post_meta(get_the_ID(), 'ciy_services_field', true);
            $string .= '<li class="ciy_services_card_plugin">';
            $string .= get_the_post_thumbnail();
            $string .= '<h2>'.get_the_title().'</h2>';
            $string .= '<he class="ciy_services_price">'.$price.'</h2>';
            $string .= '<p>'.get_the_content().'</p>';
            $string .= '<button onclick="'.get_the_permalink(get_page_by_path('contact')).'" type="button">Get This</button>';
            $string .= '</li>';
        endwhile;
        $string .= '</ul>';
        $string .= '</section>';
    endif;
    wp_reset_postdata();
    return $string;
}
add_shortcode('ciy_services_cards', 'get_services_post_type');

// Installation of function
function services_post_type_install()
{
    setup_designs_post_type('services');
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'services_post_type_install');

function services_post_type_deactivate()
{
    unregister_post_type('services');
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'services_post_type_deactivate');

function services_post_type_uninstall()
{
    if(!defined('WP_UNINSTALL_PLUGIN'))
    {
        die;
    }
    global $wpdb;
    $wpdb->query("DELETE FROM wp_posts WHERE post_type = services");
    $wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN(SELECT id FROM wp_posts)");
    $wpdb->query("DELETE FROM wp_term_relationship WHERE object_id NOT IN (SELECT id FROM wp_posts)");
}
register_uninstall_hook(__FILE__, 'services_post_type_uninstall');