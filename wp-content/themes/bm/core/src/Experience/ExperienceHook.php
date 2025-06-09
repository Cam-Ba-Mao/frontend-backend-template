<?php

namespace BM\Core\Experience;

class ExperienceHook
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
        add_action('init', [$this, 'registerExperience']);
        add_action('init', [$this, 'registerTaxonomyExperience']);
        add_action('init', [$this, 'rewriteRuleTaxonomy']);

        add_filter('term_link', [$this, 'linkTaxonomy'], 999);
        add_filter('pll_the_language_link', [$this, 'linkTaxonomy']);
        add_action('template_redirect', [$this, 'redirectTaxonomy']);
    }

    public static function registerExperience()
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
                'name' => 'Experiences',
                'singular_name' => 'Experiences',
                'menu_name' => 'Experiences',
                'name_admin_bar' => 'Experiences',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Experience',
                'new_item' => 'New Experience',
                'edit_item' => 'Edit Experience',
                'view_item' => 'View Experience',
                'all_items' => 'All Experiences',
                'search_items' => 'Search Experience',
                'not_found' => 'No Experience Found.',
            ],
            'public' => true,
            'show_in_rest' => false,
            'query_var' => true,
            'has_archive' => false,
            'hierarchical' => true,
            'publicly_queryable' => true,
            'rewrite' => ['slug' => 'experience'],
            'menu_icon' => 'dashicons-book'
        ];

        register_post_type('experiences', $args);
    }

    public static function registerTaxonomyExperience() {
        $labels = array(
            'name' => 'Category Experience',
            'singular_name' => 'Category Experience',
            'search_items' => 'Search Category Experience',
            'all_items' => 'All Experiences',
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => 'Edit Experience',
            'update_item' => 'Update Experience',
            'add_new_item' => 'Add New Experience',
            'new_item_name' => 'Experience',
            'menu_name' => 'Category Experience',
        );

        register_taxonomy( 'cat_experience', ['experiences'], array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => __('kinh-nghiem', 'rt') ),
        ));
    }

    /**
     * @param: void
     */
    public static function rewriteRuleTaxonomy()
    {
        add_rewrite_rule('en/experience/([^/]*)/?','index.php?cat_experience=$matches[1]','top');
        add_rewrite_rule('en/experience/page/(.+?)/?$','index.php?p=$matches[1]&page=$matches[2]','top');
    }

    /**
     * @param: void
     */
    public static function redirectTaxonomy()
    {
        global $wp;
        $link = home_url($wp->request);
        if(strpos($link, '/en/kinh-nghiem/')) {
            $link = str_replace('/en/kinh-nghiem/', '/en/experience/', $link);
            wp_redirect($link); exit;
        }
    }

    /**
     * @param: string $link
     */
    public static function linkTaxonomy($link)
    {
        if(strpos($link, '/en/kinh-nghiem/')) {
            $link = str_replace('/en/kinh-nghiem/', '/en/experience/', $link);
        }
        return $link;
    }

}