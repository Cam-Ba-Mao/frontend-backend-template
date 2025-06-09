<?php

namespace BM\Core\Blog;

class BlogFunctions
{
    /**
     * Get Blog
     *
     * @param int $page
     * @param int $limit
     * @param null $catId
     * @param array $except
     * @return \WP_Query
     */
    public static function getBlogs($catId = null, $page = 1, $limit = 0, $except = [], $in = [])
    {
        if (!$limit) {
            $limit = get_option('posts_per_page');
        }

        $args = [
            'post_type' => 'post',
            'posts_per_page' => $limit,
            'paged' => $page,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'ignore_sticky_posts' => 1,
        ];

        if (is_array($except) && count($except) > 0) {
            $args['post__not_in'] = $except;
        }

        if (is_array($in) && count($in) > 0) {
            $args['post__in'] = $in;
        }

        if (!empty($catId)) {
            $args['category__in'] = is_array($catId) ? $catId : array($catId);
        }

        return new \WP_Query($args);
    }

    public static function getBlogsTag($tagID = null, $page = 1, $limit = 0)
    {
        if (!$limit) {
            $limit = get_option('posts_per_page');
        }
        $tag_ids = array();
        $args = [
            'post_type' => 'post',
            'posts_per_page' => $limit,
            'paged' => $page,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            
        ];
        

        if (!empty($tagID)) {
            $args['tag__in'] = is_array($tagID) ? $tagID : array($tagID );
        }
        return new \WP_Query($args);
    }
    
    public static function getRelatedBlogs($postId, $catId, $args = [])
    {
        $default = [
            'post_type' => 'post',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => 8,
            'category__in' => [$catId],
            'post__not_in' => [$postId]
        ];

        $args = wp_parse_args($args, $default);

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
    public static function getCategories($parent = 0, $orderBy = 'term_order', $order = 'ASC', $hideEmpty = false)
    {
        $categories = get_terms(array(
            'taxonomy' => 'category',
            'orderby' => $orderBy,
            'order' => $order,
            'hide_empty' => $hideEmpty,
            'parent' => $parent
        ));

        return $categories;
    }

    /**
     * Get Blog Featured
     *
     * @param int $page
     * @param int $limit
     * @param null $catId
     * @param array $except
     * @return \WP_Query
     */
    public static function getBlogFeatured($page = 1, $limit = 6, $except = [])
    {
        if (!$limit) {
            $limit = get_option('posts_per_page');
        }

        $args = [
            'post_type' => 'post',
            'posts_per_page' => $limit,
            'ignore_sticky_posts' => 1,
            'paged' => $page,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'post__in' => get_option( 'sticky_posts' )
        ];

        if (is_array($except) && count($except) > 0) {
            $args['post__not_in'] = $except;
        }

        return new \WP_Query($args);
    }
}