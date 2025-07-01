<?php
    function registerGermanyCountry()
    {
        $args = [
            'supports' => [
                'title',
                'thumbnail',
                'editor',
                'comments'
            ],
            'labels' => [
                'name' => __('Car', 'iedg'),
                'singular_name' => __('Car', 'iedg'),
                'menu_name' => __('Car', 'iedg'),
                'name_admin_bar' => __('IEDGer', 'iedg'),
                'add_new' => __('Add New', 'iedg'),
                'add_new_item' => __('Add New Car'),
                'new_item' => __('New Car'),
                'edit_item' => __('Edit Car'),
                'view_item' => __('View Car'),
                'all_items' => __('All Car'),
                'search_items' => __('Search Car'),
                'not_found' => __('No Car Found.'),
            ],
            'public' => true,
            'show_in_rest' => true,
            'query_var' => false,
            'has_archive' => false,
            'hierarchical' => false,
            'publicly_queryable' => true,
            'rewrite' => ['slug' => 'oto-car'],
            // 'menu_icon' => 'dashicons-editor-help'
        ];

        register_post_type('car', $args);
    }

    function registerTaxonomyGermanyCountry() 
    {
        $labels = array(
            'name' => 'Car Category',
            'singular_name' => 'Car Category',
            'search_items' => 'Search Car Category',
            'all_items' => 'All Car Category',
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => 'Edit Car Category',
            'update_item' => 'Update Car Category',
            'add_new_item' => 'Add New Car Category',
            'new_item_name' => 'Name Car Category',
            'menu_name' => 'Car Category',
        );
    
        register_taxonomy( 'car_cat', 'car', array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'publicly_queryable' => true,
            'rewrite' => array( 'slug' => 'car-cat' ),
        ));
    }

    add_action('init', 'registerGermanyCountry');
    add_action('init', 'registerTaxonomyGermanyCountry');