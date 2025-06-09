<?php

namespace BM\Core\Experience;

class ExperienceFunctions {
    /**
     * Get Experiences
     *
     * @param int $catId
     * @param int $page
     * @param int $limit
     * @param array $except
     * @return \WP_Query
     */
    public static function getExperiences($catId = 0, $page = 0, $limit = 0, $except = [], $in = [])
    {
        if (!$limit) {
            $limit = get_option('posts_per_page');
        }
        if(empty($page)) {
            $page = get_query_var('paged') ? get_query_var('paged') : 1;
        }

        $args = [
            'post_type' => 'experiences',
            'posts_per_page' => $limit,
            'paged' => $page,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'desc',
            'ignore_sticky_posts' => 1,
        ];

        if (is_array($except) && count($except) > 0) {
            $args['post__not_in'] = $except;
        }

        if (is_array($in) && count($in) > 0) {
            $args['post__in'] = $in;
        }

        if (!empty($catId)) {
            $args['tax_query'] = array([
                'terms' => $catId,
                'field' => 'term_id',
                'taxonomy' => 'cat_experience',
            ]);
        }

        return new \WP_Query($args);
    }

    /**
     * Get Experiences Featured
     *
     * @param int $limit
     * @param int $page
     * @param null $catId
     * @param array $except
     * @return \WP_Query
     */
    public static function getExperiencesFeatured($limit = 1, $page = 1, $except = [])
    {
        if(!$limit) {
            $limit = get_option('posts_per_page');
        }

        $args = [
            'post_type' => 'faqs',
            'posts_per_page' => $limit,
            'ignore_sticky_posts' => 1,
            'paged' => $page,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'post__in' => get_option( 'sticky_posts')
        ];

        if (is_array($except) && count($except) > 0) {
            $args['post__not_in'] = $except;
        }

        return new \WP_Query($args);
    }

    /**
     * Get Categories
     *
     * @param string $orderBy
     * @param string $order
     * @param bool $hideEmpty
     * @return array|int|\WP_Error
     */
    public static function getCategories($orderBy = 'term_order', $order = 'ASC', $hideEmpty = true)
    {
        $categories = get_terms([
            'hide_empty' => $hideEmpty,
            'taxonomy' => 'cat_experience',
            'orderby' => $orderBy,
            'order' => $order,
        ]);

        return $categories;
    }

}
