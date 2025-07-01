<?php

namespace BM\Core\Common;

class ThemeCustomizer
{
    public static function init()
    {
        static $init = null;

        if ($init === null) {
            $init = new self();
            $init->addAction();
        }

        return $init;
    }

    private function addAction()
    {
        add_action( 'customize_register', [$this, 'customizeFooterLogo'] );
    }

    public function customizeFooterLogo($wp_customize) 
    {
        // add footer logo section to customizer
        $wp_customize->add_section( 'small_logo_option' , array(
            'title'      => __( 'Footer Logo', 'rt' ),
            'priority'   => 35,
            'capability'  => 'edit_theme_options',
            'description' => __('Footer logo.', 'rt'),
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
            'rt_footer_logo',
            array(
                'label'      => __( 'Footer Logo', 'rt' ),
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
}