<?php namespace BM\Core\Pages;

class Search
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
        add_action('rt_content_search_page', [$this, 'content']);
    }

    /**
     * Content Search Page
     * @param $id
     */
    public static function content($id)
    {
        $options = get_fields('option');
        if (empty($options)) {
            $options = [];
        }

        $data = get_fields($id);
        if (empty($data)) {
            $data = [];
        }

        $keyword = get_search_query();
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $limit = 10;
        
        $data = array_merge($options, $data);

        $data['key'] = $keyword;
        $data['result'] = self::getAllPosts($data['key'], $paged, $limit);
        $data['pagination'] = iedg_pagination($data['result'], 'list', '', '', false);
        $data['limit'] = $limit;
        $data['count'] = $data['result']->found_posts;
        
        set_query_var('data', $data);

        get_template_part('template-parts/search/header');
        get_template_part('template-parts/search/results');
        
    }

    /**
     * Get All Posts
     *
     * @param int $page
     * @param int $limit
     * @param string $key
     * @return \WP_Query
     */
    public static function getAllPosts($key = '', $page = 1, $limit = 0)
    {
        if (!$limit) {
            $limit = get_option('posts_per_page');
        }

        $args = [
            'post_type' => ['post', 'page', 'course'],
            'posts_per_page' => $limit,
            'paged' => $page,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'ignore_sticky_posts' => 1,
            's' => $key
        ];

        return new \WP_Query($args);
    }
}