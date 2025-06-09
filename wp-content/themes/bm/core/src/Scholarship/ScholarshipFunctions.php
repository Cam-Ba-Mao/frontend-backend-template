<?php

namespace BM\Core\Scholarship;

class ScholarshipFunctions {
    /**
     * Get Scholarship
     *
     * @param int $catId
     * @param int $page
     * @param int $limit
     * @param array $except
     * @return \WP_Query
     */
    public static function getScholarship($page = 1, $limit = 0, $except = [], $in = [])
    {
        if (!$limit) {
            $limit = get_option('posts_per_page');
        }
        if(empty($page)) {
            $page = get_query_var('paged') ? get_query_var('paged') : 1;
        }

        $args = [
            'post_type' => 'scholarship',
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

        return new \WP_Query($args);
    }
}
