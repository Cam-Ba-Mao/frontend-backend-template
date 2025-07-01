<?php

/**
 * Get Germany Country
 *
 * @param int $page
 * @param int $limit
 * @param null $cat
 * @param array $except
 * @return \WP_Query
 */
function getCar($cat = null, $page = 1, $limit = 0, $except = [], $orderBy='date', $order = 'DESC')
{
    $taxQuery = [];

    if (!$limit) {
        $limit = get_option('posts_per_page');
    }

    $args = [
        'post_type' => 'car',
        'posts_per_page' => $limit,
        'paged' => $page,
        'post_status' => 'publish',
        'orderby' => $orderBy,
        'order' => $order,
    ];

    if (is_array($except) && count($except) > 0) {
        $args['post__not_in'] = $except;
    }

    if( !empty($cat) ) {
        array_push($taxQuery, [
            'taxonomy' => 'car_cat',
            'field'    => 'term_id',
            'terms'    => $cat,
        ]);
    }

    if( count($taxQuery) > 0 ) {
        $args['tax_query'] = $taxQuery;
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
function getCategories($orderBy = 'term_order', $order = 'ASC', $hideEmpty = false)
{
    $categories = get_terms(array(
        'taxonomy' => 'car_cat',
        'orderby' => $orderBy,
        'order' => $order,
        'hide_empty' => $hideEmpty,
        'parent' => 0
    ));

    return $categories;
}