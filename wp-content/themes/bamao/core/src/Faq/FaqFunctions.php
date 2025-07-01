<?php

namespace BM\Core\Faq;

class FaqFunctions {
    /**
     * Get Tuition Faq
     *
     * @param int $page
     * @param int $limit
     * @param null $catId
     * @param array $except
     * @return \WP_Query
     */
    public static function getFaq($page = 1, $limit = 0) {
        if (!$limit) {
            $limit = get_option('posts_per_page');
        }

        $args = [
            'post_type' => 'faq',
            'posts_per_page' => $limit,
            'paged' => $page,
            'post_status' => 'publish',
        ];

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
    public static function getCategories($orderBy = 'term_order', $order = 'ASC', $hideEmpty = false) {
        $categories = get_terms(array(
            'taxonomy' => 'cat_faq',
            'orderby' => $orderBy,
            'order' => $order,
            'hide_empty' => $hideEmpty,
            'parent' => 0
        ));

        return $categories;
    }
}
