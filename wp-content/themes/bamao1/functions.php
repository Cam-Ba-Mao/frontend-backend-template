<?php
/**
@ Khai bao hang gia tri
	@ THEME_URL = lay duong dan thu muc theme
	@ CORE = lay duong dan cua thu muc /core
**/
define( 'THEME_URL', get_stylesheet_directory() );
define ( 'CORE', THEME_URL . "/core" );

/**
@ Nhung file /core/init.php
**/
require_once( CORE . "/init.php" );
require_once( CORE . "/acf.php" );
require_once( CORE . "/navigation.php" );
require_once( CORE . "/ThemeCustomizer.php" );
require_once( CORE . "/common.php" );
require_once( CORE . "/Product/ProductHook.php" );
require_once( CORE . "/Product/ProductFunctions.php" );
require_once( CORE . "/Pages/Archive.php" );
require_once( CORE . "/Pages/Single.php" );
/**
@ Thiet lap chieu rong noi dung
**/
if ( !isset($content_width) ) {
	$content_width = 620;
}

/**
@ Khai bao chuc nang cua theme 
**/
if ( !function_exists('bamao_theme_setup') ) {
	function bamao_theme_setup() {

		/* Thiet lap textdomain */
		$language_folder = THEME_URL . '/languages';
		load_theme_textdomain( 'bamao', $language_folder );
		/* Tu dong them link RSS len <head> **/
		add_theme_support( 'automatic-feed-links' );

		/* Them post thumbnail */
		add_theme_support( 'post-thumbnails' );

		/* Post Format */
		add_theme_support( 'post-formats', array(
			'image',
			'video',
			'gallery',
			'quote',
			'link'
		) );

		/* Them title-tag */
		add_theme_support( 'title-tag' );

		/* Them custom background */
		$default_background = array(
			'default-color' => '#e8e8e8'
		);
		add_theme_support( 'custom-background', $default_background );

		

		/* Them menu */
		register_nav_menu( 'primary-menu', __('Primary Menu', 'bamao') );

		/* Tao sidebar */
		$sidebar = array(
			'name' => __('Main Sidebar', 'bamao'),
			'id' => 'main-sidebar',
			'description' => __('Default sidebar'),
			'class' => 'main-sidebar',
			'before_title' => '<h3 class="widgettitle">',
			'after_title' => '</h3>'
		);
		register_sidebar( $sidebar );

		

	}
	add_action( 'init', 'bamao_theme_setup' );
}

/**
 * Add support for core custom logo.
 *
 * @link https://codex.wordpress.org/Theme_Logo
 */
function theme_prefix_setup() {
	
	add_theme_support( 'custom-logo', array(
		'height' => 250, 
		'width' => 250, 
		'flex-width' => true, 
		'flex-height' => true
	) );

	/**
	 * Add support woocommerce
	 */
	add_theme_support( 'woocommerce' );

}
add_action( 'after_setup_theme', 'theme_prefix_setup' );

function theme_prefix_the_custom_logo() {
	
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}

}


/**
 * ------------------------------------------------------------------------------------------------
 * Enqueue styles
 * ------------------------------------------------------------------------------------------------
 */
if (!function_exists('iedg_styles')) {
    add_action('wp_enqueue_scripts', 'iedg_styles', 1000);
    function iedg_styles()
    {
        $is_min = defined('STYLE_DEBUG') && STYLE_DEBUG == true ? '' : '.min';
        
        // version for development.
        $version = rand(0, 99);
        wp_enqueue_style('bootstrap-style', get_template_directory_uri() . '/html/dist/css/bootstrap.css');
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
    function iedg_admin_styles()
    {
        $is_min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG == true ? '' : '.min';
        $version = rand(0, 99);
        wp_enqueue_style('bootstrap-style', get_template_directory_uri() . '/html/dist/admin/admin.css', array(), time());
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Enqueue scripts
 * ------------------------------------------------------------------------------------------------
 */


if (!function_exists('iedg_scripts')) {
    add_action('wp_footer', 'iedg_scripts');
    function iedg_scripts()
    {
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
function iedg_defer_script($tag, $handle)
{
    $arr = [
        'bundle-js',
        'script-js',
    ];
    if (in_array($handle, $arr)) {
        return str_replace(' src', ' defer src', $tag);
    }
    return $tag;
}




