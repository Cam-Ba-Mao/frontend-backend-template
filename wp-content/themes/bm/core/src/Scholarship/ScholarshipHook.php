<?php

namespace BM\Core\Scholarship;

class ScholarshipHook
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
        add_action('init', [$this, 'registerScholarship']);
        
    }

    public static function registerScholarship()
    {
        $args = [
            'supports' => [
                'title',
                'editor',
                'thumbnail',
                'excerpt', 
                'author',
            ],
            'labels' => [
                'name' => 'Scholarships',
                'singular_name' => 'Scholarships',
                'menu_name' => 'Scholarships',
                'name_admin_bar' => 'Scholarships',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Scholarship',
                'new_item' => 'New Scholarship',
                'edit_item' => 'Edit Scholarship',
                'view_item' => 'View Scholarship',
                'all_items' => 'All Scholarships',
                'search_items' => 'Search Scholarship',
                'not_found' => 'No Scholarship Found.',
            ],
            'public' => true,
            'show_in_rest' => false,
            'query_var' => true,
            'has_archive' => false,
            'hierarchical' => true,
            'publicly_queryable' => true,
            'rewrite' => ['slug' => 'scholarship'],
            'menu_icon' => 'dashicons-welcome-learn-more'
        ];

        register_post_type('scholarship', $args);
    }

}