<?php

namespace BM\Core\Course;

class CourseFunctions {
    /**
     * Get Courses
     *
     * @param string $cat
     * @param int $page
     * @param int $limit
     * @param array $except
     * @return \WP_Query
     */
    public static function getCourses($cat = '', $page = 1, $limit = 0, $except = []) {
        if (!$limit) {
            $limit = get_option('posts_per_page');
        }

        $args = [
            'post_type' => 'course',
            'posts_per_page' => $limit,
            'paged' => $page,
            'post_status' => 'publish',
        ];

        if (is_array($except) && count($except) > 0) {
            $args['post__not_in'] = $except;
        }

        if (!empty($cat)) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'cat_course',
                    'field' => 'term_id',
                    'terms' => $cat
                ]
            ];
        }

        return new \WP_Query($args);
    }

    /**
     * Get Course Categories
     *
     * @param string $orderBy
     * @param string $order
     * @param bool $hideEmpty
     * @return array|int|\WP_Error
     */
    public static function getCategories($orderBy = 'term_order', $order = 'ASC', $hideEmpty = false) {
        $categories = get_terms(array(
            'taxonomy' => 'cat_course',
            'orderby' => $orderBy,
            'order' => $order,
            'hide_empty' => $hideEmpty,
            'parent' => 0
        ));

        return $categories;
    }

    /**
     * Get Related Courses
     *
     * @param integer $postId
     * @param integer $catId
     * @param array $args
     * @return array|int|\WP_Error
     */
    public static function getRelatedCourses($postId, $catId = null, $limit = 1, $args = []) {
        $default = [
            'post_type' => 'course',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        ];

        if (!empty($limit)) {
            $args['posts_per_page'] = $limit;
        }

        if (!empty($catId)) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'cat_course',
                    'field'    => 'term_id',
                    'terms'    => $catId,
                    'include_children' => true, //get post in parent & children categories
                ]
            ];
        }

        $args = wp_parse_args($args, $default);

        // Always exclude the current post
        $args['post__not_in'] = [$postId];

        return new \WP_Query($args);
    }
}
