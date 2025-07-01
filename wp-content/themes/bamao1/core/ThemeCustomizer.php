<?php

    function customizeFooterLogo($wp_customize) 
    {
        // add footer logo section to customizer
        $wp_customize->add_section( 'small_logo_option' , array(
            'title'      => __( 'Footer Logo', 'bamao' ),
            'priority'   => 35,
            'capability'  => 'edit_theme_options',
            'description' => __('Footer logo.', 'bamao'),
        ) );

        $wp_customize->add_setting( 'footer_logo',
            array(
                'default'    => '',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
            ) 
        );
        
        $wp_customize->add_control( new \WP_Customize_Image_Control(
            $wp_customize,
            'iedg_footer_logo',
            array(
                'label'      => __( 'Footer Logo', 'bamao' ),
                'settings'   => 'footer_logo',
                'priority'   => 10,
                'section'    => 'title_tagline',
                'button_labels' => array(
                    'select' => __( 'Select Image' ),
                    'change' => __( 'Change Image' ),
                    'remove' => __( 'Remove' ),
                    'default' => __( 'Default' ),
                    'placeholder' => __( 'No image selected' ),
                    'frame_title' => __( 'Select Image' ),
                    'frame_button' => __( 'Choose Image' ),
                 )
            ) 
        ));
    }
    add_action( 'customize_register', 'customizeFooterLogo' );

    function custom_theme_setup() {
        add_image_size('iedg_blog_thumbnail', 400, 0, true );
        add_image_size('iedg_blog_large', 800, 0, true );
    }
    
    function iedg_login_logo() { ?>
        <style type="text/css">
            #login h1 a, .login h1 a {
                background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/html/dist/images/logo.png);
                height: 50px;
                width: 210px;
                background-size: 210px 50px;
                background-repeat: no-repeat;
            }
        </style>
    <?php }
    add_action( 'login_enqueue_scripts', 'iedg_login_logo' );
    
    // changing the logo link from wordpress.org to your site
    function iedg_login_url() {  
        return home_url(); 
    }
    add_filter( 'login_headerurl', 'iedg_login_url' );
    
    // changing the alt text on the logo to show your site name
    function iedg_login_title() { 
        return get_option( 'blogname' );
     }
    add_filter( 'login_headertext', 'iedg_login_title' );