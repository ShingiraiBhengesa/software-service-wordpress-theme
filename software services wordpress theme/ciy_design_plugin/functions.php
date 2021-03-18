<?php
/**
 * @package ciy_design_plugin
 * 
 * Functions for our design plugin
 */

// Enqueue files
function my_design_scripts()
{
    wp_enqueue_style('ciy_designs_style', plugin_dir_url(__FILE__) . 'assets/css/style.css', array(), '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', 'my_design_scripts');

// Register design post type
function setup_designs_post_type()
{
    register_post_type('designs',
    [
        'labels'    => [
            'name'  => __('Designs'),
            'singular_name' => __('Design'),
            'add_new'   => __('Add New Design'),
            'add_new_item'  => __('Add New Design'),
            'edit_item' => __('Edit Design'),
            'search_item'   => __('Search Design')
        ],
        'menu_position' => 7,
        'public'    => true,
        'exclude_from_search'   => true,
        'has_archive'   => true,
        'rewrite'   => ['slug' => 'design'],
        'register_meta_box_cd' => 'ciy_design_add_meta_box',
        'menu_icon' => 'dashicons-admin-users',
        'show_in_rest'  => true,
        'supports'  => ['title', 'editor', 'thumbnail']
    ]);
}
add_action('init', 'setup_designs_post_type');

// Create new columns
function ciy_set_design_columns($columns)
{
    $new_columns = [];
    $new_columns['title'] = 'Design Type';
    $new_columns['price'] = 'Price';
    $new_columns['message'] = 'Description';
    return $new_columns;
}
add_filter('manage_designs_posts_columns', 'ciy_set_design_columns');

function ciy_designs_columns($column, $post_id)
{
    switch($column)
    {
        case 'message' : 
            echo get_the_excerpt();
        break;
        case 'price' : 
            $price = get_post_meta($post_id, 'ciy_design_field', true);
            echo $price;
        break;    
    }
}
add_action('manage_designs_posts_custom_column', 'ciy_designs_columns', 10, 2);

function ciy_design_add_meta_box()
{
    add_meta_box('design_price', __('The Price'), 'ciy_design_price_callback', 'designs', 'normal', 'high');
}
add_action('add_meta_boxes', 'ciy_design_add_meta_box');

function ciy_design_price_callback($post)
{
    global $post;
    $price = get_post_meta($post->ID, 'ciy_design_field', true);
    ?>
    <label for="ciy_design_field">Design Prices </label>
    <input type="text" name="ciy_design_field" id="ciy_design_field" size="25" value="<?php print $price; ?>">
    <?php
}

function ciy_save_design_price_data($post_id)
{
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);

    if($is_autosave || $is_revision)
    {
        return;
    }

    $post = get_post($post_id);
    if($post->post_type == "designs")
    {
        // Save the price field data
        if(array_key_exists('ciy_design_field', $_POST))
        {
            update_post_meta($post_id, 'ciy_design_field', $_POST['ciy_design_field']);
        }
    }
}
add_action('save_post', 'ciy_save_design_price_data');

function get_designs_post_type()
{
    $args = [
        'posts_per_page'    => -1,
        'post_type' => 'designs'
    ];

    $string = '';
    $loop = new WP_Query($args);

    if($loop->have_posts()): 
        $string .= '<section class="section section_designs">';
        $string .= '<h2>'.get_the_title().'</h2>';
        $string .= '<ul>';
        while($loop->have_posts()) : $loop->the_post();
            $price = get_post_meta(get_the_ID(), 'ciy_design_field', true);
            $string .= '<li id="myModal" class="ciy_designs_card_plugin">';
            $string .= get_the_post_thumbnail();
            $string .= '<h2>'.get_the_title().'</h2>';
            $string .= '<h2 class="ciy_designs_price">'.$price.'</h2>';
            $string .= '<p>'.get_the_content().'</p>';
            $string .= '<button onclick="'.get_the_permalink(get_page_by_path('contact')).'"type="button">Get This</button>';
            $string .= '</li>';
        endwhile;    
        $string .= '</ul>';
        $string .= '</section>';
    endif;
    wp_reset_postdata();
    return $string;
}
add_shortcode('ciy_designs_cards', 'get_designs_post_type');

// Installation of function
function designs_post_type_install()
{
    setup_designs_post_type('designs');
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'designs_post_type_install');

function designs_post_type_deactivate()
{
    unregister_post_type('designs');
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'designs_post_type_deactivate');

function designs_post_type_uninstall()
{
    if(!defined('WP_UNINSTALL_PLUGIN'))
    {
        die;
    }
    global $wpdb;
    $wpdb->query("DELETE FROM wp_posts WHERE post_type = designs");
    $wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN(SELECT id FROM wp_posts)");
    $wpdb->query("DELETE FROM wp_term_relationship WHERE object_id NOT IN (SELECT id FROM wp_posts)");
}
register_uninstall_hook(__FILE__, 'designs_post_type_uninstall');