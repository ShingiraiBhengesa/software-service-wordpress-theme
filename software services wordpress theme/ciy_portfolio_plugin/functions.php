<?php
/**
 * @package ciy_portfolio_plugin
 * 
 * Functions for our porfolio plugin
 */

// Enqueue our files
function my_portfolios_scripts() 
{
    wp_enqueue_style('ciy_portfolio_style', plugin_dir_url(__FILE__) . 'assets/css/style.css', array(), '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', 'my_portfolios_scripts');

// Register portfolio post type
function setup_portfolio_post_type()
{
    register_post_type('portfolios',
    [
        'labels'    => [
            'name'  => __('Portfolios'),
            'singular_name' => __('Portfolio'),
            'add_new'   => __('Add New Portfolio'),
            'add_new_item'  => __('Add New Portfolio'),
            'edit_item' => __('Edit Porfolio'),
            'search_items'  => __('Search Portfolio')
        ],
        'menu_position' => 9,
        'public'    => true,
        'exclude_from_search'   => true,
        'has_archive'   => true,
        'rewrite'   => ['slug' => 'portfolio'],
        'register_meta_box_cb'  => 'ciy_portfolio_meta_box',
        'menu_icon' => 'dashicons-admin-users',
        'show_in_rest'  => true,
        'supports'  => [
            'title', 'editor', 'thumbnail'
        ]
    ]);

}
add_action('init', 'setup_portfolio_post_type');

// Create new columns
function ciy_set_portfolio_columns($column)
{
    $my_columns = [];
    $my_columns['title'] = 'Portfolio';
    $my_columns['year'] = 'Year';
    $my_columns['message'] = 'Description';
    return $my_columns;
}
add_filter('manage_portfolios_posts_columns', 'ciy_set_portfolio_columns');

function ciy_portfolios_columns($column, $post_id)
{
    switch($column)
    {
        case 'title' : 
            echo get_the_title();
        break;
        case 'message' : 
            echo get_the_excerpt();
        break;
        case 'year' : 
            $year = get_post_meta($post_id, 'ciy_portfolio_year', true);
            echo $year;
        break;        
    }
}
add_action('manage_portfolios_posts_custom_column', 'ciy_portfolios_columns', 10, 2);

// Meta boxes
function ciy_portfolio_meta_box()
{
    add_meta_box('portfolio_year', __('Project Year'), 'ciy_portfolios_year_callback', 'portfolios', 'normal');
}
add_action('add_meta_boxes', 'ciy_portfolio_meta_box');

function ciy_portfolios_year_callback($post)
{
    global $post;
    $year = get_post_meta($post->ID, 'ciy_portfolio_year', true);
    ?>
    <label for="ciy_portfolio_year">Completion Date</label>
    <input type="text" name="ciy_portfolio_year" value="<?php print $year; ?>">
    <?php
}

// Save the data
function ciy_save_porfolios_year_data($post_id)
{
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);

    if($is_autosave || $is_revision)
    {
        return;
    }

    $post = get_post($post_id);
    if($post->post_type == "portfolios")
    {
        // Save the data
        if(array_key_exists('ciy_portfolio_year', $_POST));
        {
            update_post_meta($post_id, 'ciy_portfolio_year', $_POST['ciy_portfolio_year']);
        }
    }
}
add_action('save_post', 'ciy_save_porfolios_year_data');

// Add Shortcode
function get_portfolio_shortcode()
{
    $args = [
        'posts_per_page'    => -1,
        'post_type' => 'portfolios'
    ];

    $string = '';
    $loop = new WP_QUERY($args);

    if($loop->have_posts()) :
        $string .= '<section class="section_plugin section_portfolio">';
        $string .= '<h2>My Portfolio</h2>';
        $string .= '<ul>';
        while($loop->have_posts()) : $loop->the_post();
        $year = get_post_meta(get_the_ID(), 'ciy_portfolio_year', true);
            $string .= '<li>';
            $string .= get_the_post_thumbnail();
            $string .= '<p class="portfolio_year">'.$year.'</p>';
            $string .= '<h2>'.get_the_title().'</h2>';
            $string .= '<p class="portfolio_content">'.get_the_content().'</p>';
            $string .= '</li>';
        endwhile;
        $string .= '</ul>';
        $string .= '</section>';
    endif;
    wp_reset_postdata();
    return $string;
}
add_shortcode('ciy_portfolio_cards', 'get_portfolio_shortcode');

// Installation, deactivation and uninstallation of plugin
function portfolio_post_type_install()
{
    setup_portfolios_post_type('portfolios');
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'portfolio_post_type_install');

function portfolio_post_type_deactivate()
{
    unregister_post_type('portfolios');
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'portfolio_post_type_deactivate');

function portfolio_post_type_uninstall()
{
    if(!defined('WP_UNINSTALL_PLUGIN'))
    {
        die;
    }
    global $wpdb;
    $wpdb->query("DELETE FROM wp_posts WHERE post_type = portfolios");
    $wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN(SELECT id FROM wp_posts)");
    $wpdb->query("DELETE FROM wp_term_relationship WHERE object_id NOT IN (SELECT id FROM wp_posts)");
}
register_uninstall_hook(__FILE__, 'portfolio_post_type_uninstall');