<?php
/**
 * @package ciy_simple_contact_form
 * 
 * Functions for the contact form
 */

//  Enqueue files
function my_contact_scripts()
{
    wp_enqueue_style('contact_form_style', plugin_dir_url(__FILE__) . 'assets/contact_style.css', array(), '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', 'my_contact_scripts');

// Shortcode for the contact form
function custom_form_plugin()
{
    $content = '';
    $content .= '<div class="ciy_form">';
    $content .= '<form action="http://localhost/software_services/thank-you/" method="post">';
    $content .= '<h2>Contact Us</h2>';
    $content .= '<input type="text" name="your_name" class="ciy_form_input" placeholder="Your Name" autocomplete="off" required /><br>';

    $content .= '<input type="email" name="your_email" class="ciy_form_input" placeholder="Your Email" autocomplete="off" required /><br>';

    $content .= '<textarea name="your_message" class="ciy_form_textarea" placeholder="Your Message" required ></textarea><br>';
    $content .= '<input type="submit" name"form_submit" value="Send" class="ciy_contactform_button" />';
    $content .= '</form>';
    $content .= '</div>';
    return $content;
}
add_shortcode('simple_contact_form', 'custom_form_plugin');

// Collect the information
function example_form_collect()
{
    if(isset($_POST['form_submit']))
    {
        $name = sanitize_text_field($_POST['your_name']);
        $email = sanitize_text_field($_POST['your_email']);
        $message = sanitize_textarea_field($_POST['your_message']);

        // Set up the server
        $receiver = 'thecodeityourself@gmail.com';
        $subject = 'Test Form Submission';
        $user_message = $name. ' - ' .$email. ' - ' .$message;
        wp_mail($receiver, $subject, $user_message);
    }
}
add_action('wp_head', 'example_form_collect');