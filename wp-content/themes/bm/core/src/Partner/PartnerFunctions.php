<?php

namespace BM\Core\Partner;

class PartnerFunctions {
    /**
     * Get Experiences
     *
     * @param int $catId
     * @param int $page
     * @param int $limit
     * @param array $except
     * @return \WP_Query
     */
    public static function getPartners($catId = 0, $page = 0, $limit = 0, $except = [], $in = [])
    {
        if (!$limit) {
            $limit = get_option('posts_per_page');
        }

        if(empty($page)) {
            $page = get_query_var('paged') ? get_query_var('paged') : 1;
        }

        $args = [
            'post_type' => 'partner',
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
                'taxonomy' => 'cat_partner',
            ]);
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
            'taxonomy' => 'cat_partner',
            'orderby' => $orderBy,
            'order' => $order,
        ]);

        return $categories;
    }

}
