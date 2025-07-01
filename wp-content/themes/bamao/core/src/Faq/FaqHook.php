<?php

namespace BM\Core\Faq;

class FaqHook {
    public static function init() {
        static $init = null;

        if ($init === null) {
            $init = new self();
            $init->setupAction();
        }

        return $init;
    }

    private function setupAction() {
        add_action('init', [$this, 'registerFaq']);
    }

    public static function registerFaq() {
        $args = [
            'supports' => [
                'title',
                'editor',
            ],
            'labels' => [
                'name' => 'FAQs',
                'singular_name' => 'FAQs',
                'menu_name' => 'FAQs',
                'name_admin_bar' => 'FAQs',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New FAQ',
                'new_item' => 'New FAQ',
                'edit_item' => 'Edit FAQ',
                'view_item' => 'View FAQ',
                'all_items' => 'All FAQs',
                'search_items' => 'Search FAQs',
                'not_found' => 'No FAQ Found.',
            ],
            'public' => true,
            'show_in_rest' => false,
            'query_var' => true,
            'has_archive' => false,
            'hierarchical' => true,
            'publicly_queryable' => false,
            'rewrite' => ['slug' => 'cau-hoi-thuong-gap'],
            'menu_icon' => 'dashicons-editor-help'
        ];

        register_post_type('faq', $args);
    }
}
