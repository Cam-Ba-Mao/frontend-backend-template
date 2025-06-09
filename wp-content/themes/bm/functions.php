<?php
define('IEDG_TEXT_DOMAIN', 'iedg');
define('GOOGLE_MAP_API_KEY', 'AIzaSyD9CUGGaA6_P2HC2NMGhqTfv1aRe_VN2gw');

if (!function_exists('iedg_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function iedg_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Ven Creative, use a find and replace
         * to change 'iedg' to the name of your theme in all the template files.
         */
        load_theme_textdomain('pennacademy', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption',));

        add_post_type_support('page', 'excerpt');

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('iedg_custom_background_args', array('default-color' => 'ffffff', 'default-image' => '',)));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', array('height' => 250, 'width' => 250, 'flex-width' => true, 'flex-height' => true));

        /**
         * Add support woocommerce
         */
        add_theme_support('woocommerce');
    }
endif;
add_action('after_setup_theme', 'iedg_setup');

add_filter('locale', 'iedg_setLocale');
function iedg_setLocale($locale) {
    if (is_admin()) {
        return 'vi';
    }

    return $locale;
}

/**
 * ------------------------------------------------------------------------------------------------
 * Enqueue styles
 * ------------------------------------------------------------------------------------------------
 */
if (!function_exists('iedg_styles')) {
    add_action('wp_enqueue_scripts', 'iedg_styles', 1000);
    function iedg_styles() {
        $is_min = defined('STYLE_DEBUG') && STYLE_DEBUG == true ? '' : '.min';

        // version for development.
        $version = rand(0, 99);
        wp_enqueue_style('bootstrap-style', get_template_directory_uri() . '/html/dist/css/bootstrap.min.css');
        wp_enqueue_style('bundle-style', get_template_directory_uri() . '/html/dist/css/bundle.min.css');
        wp_enqueue_style('main-style', get_template_directory_uri() . '/html/dist/css/main' . $is_min . '.css', array(), time());
        wp_enqueue_style('iedg-style', get_stylesheet_uri());
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Enqueue Admin styles
 * ------------------------------------------------------------------------------------------------
 */
if (!function_exists('iedg_admin_styles')) {
    add_action('admin_enqueue_scripts', 'iedg_admin_styles', 1000);
    function iedg_admin_styles() {
        $is_min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG == true ? '' : '.min';
        $version = rand(0, 99);
        wp_enqueue_style('admin-style', get_template_directory_uri() . '/html/dist/admin/admin.css', array(), time());
        wp_enqueue_script('admin-js', get_template_directory_uri() . '/html/dist/admin/admin.js');

        // // Localize the variable
        // wp_localize_script('admin-js', 'theme_vars', array(
        //     'placeholder_image' => get_template_directory_uri() . '/html/dist/images/no-image-avaliable.jpg',
        // ));

        if (!did_action('wp_enqueue_media')) {
            wp_enqueue_media();
        }
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Enqueue scripts
 * ------------------------------------------------------------------------------------------------
 */


if (!function_exists('iedg_scripts')) {
    add_action('wp_footer', 'iedg_scripts');
    function iedg_scripts() {
        // version for development.
        global $wp_query;

        $is_min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG == true ? '' : '.min';

        wp_enqueue_script('popper-js', get_template_directory_uri() . '/html/dist/js/popper.min.js');
        wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/html/dist/js/bootstrap.min.js');
        wp_enqueue_script('bundle-js', get_template_directory_uri() . '/html/dist/js/bundle.min.js');
        wp_enqueue_script('script-js', get_template_directory_uri() . '/html/dist/js/scripts' . $is_min . '.js', array(), time(), true);

        $wp_script_data = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'home_url' => home_url(),
            'posts' => serialize($wp_query->query_vars),
            'theme_url' => get_template_directory_uri(),
            'rest_url' => rest_url(),
            'rest_nonce' => wp_create_nonce('wp_rest')
        );

        wp_localize_script('bundle-js', 'wp_vars', $wp_script_data);
    }
}
//Add defer to script
function iedg_defer_script($tag, $handle) {
    $arr = [
        'bundle-js',
        'script-js',
    ];
    if (in_array($handle, $arr)) {
        return str_replace(' src', ' defer src', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'iedg_defer_script', 10, 2);

//Add sticky events
add_action('init', 'my_sticky_events');
function my_sticky_events() {
    add_post_type_support('events', 'sticky');
}

/**
 * ------------------------------------------------------------------------------------------------
 * Load all CORE Classes and files
 * ------------------------------------------------------------------------------------------------
 */
require 'core/core.php';
require 'inc/acf.php';
require 'inc/common.php';
require 'inc/navigation.php';
require 'inc/customizer.php';
require 'inc/translate.php';

add_filter('big_image_size_threshold', '__return_false');

if (!current_user_can('administrator')) {
    show_admin_bar(false);
}
