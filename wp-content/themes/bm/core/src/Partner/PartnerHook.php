<?php

namespace BM\Core\Partner;

class PartnerHook
{
    public static function init()
    {
        static $init = null;

        if ($init === null) {
            $init = new self();
            $init->setupAction();
        }

        return $init;
    }

    private function setupAction()
    {
        add_action('init', [$this, 'registerPartner']);
        add_action('init', [$this, 'registerTaxonomyPartner']);
    }

    public static function registerPartner()
    {
        $args = [
            'supports' => [
                'title',
            ],
            'labels' => [
                'name' => 'Partners',
                'singular_name' => 'Partners',
                'menu_name' => 'Partners',
                'name_admin_bar' => 'Partners',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Partner',
                'new_item' => 'New Partner',
                'edit_item' => 'Edit Partner',
                'view_item' => 'View Partner',
                'all_items' => 'All Partners',
                'search_items' => 'Search Partner',
                'not_found' => 'No Partner Found.',
            ],
            'public' => true,
            'show_in_rest' => false,
            'query_var' => true,
            'has_archive' => false,
            'hierarchical' => false,
            'publicly_queryable' => false,
            'rewrite' => ['slug' => 'doi-tac'],
            'menu_icon' => 'dashicons-groups'
        ];

        register_post_type('partner', $args);
    }

    public static function registerTaxonomyPartner() {
        $labels = array(
            'name' => 'Category Partner',
            'singular_name' => 'Category Partner',
            'search_items' => 'Search Category Partner',
            'all_items' => 'All Partners',
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => 'Edit Partner',
            'update_item' => 'Update Partner',
            'add_new_item' => 'Add New Partner',
            'new_item_name' => 'Partner',
            'menu_name' => 'Category Partner',
        );

        register_taxonomy( 'cat_partner', ['partner'], array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'publicly_queryable' => false,
            'rewrite' => array( 'slug' => __('doi-tac', 'rt') ),
        ));
    }

}