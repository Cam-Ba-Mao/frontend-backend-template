<?php

namespace BM\Core\Event;

use WP_Query;

class EventFunctions {

    /**
     * Get Events
     *
     * @param int $page
     * @param int $limit
     * @param null $catId
     * @param array $except
     * @return \WP_Query
     */
    public static function getEvents($filter = '', $page = 1, $limit = 0, $postId = '', $count = false) {
        if (empty($limit)) {
            $limit = self::getSettings('limit', get_option('posts_per_page'));
        }

        $filter = !empty($_POST['filter']) ? sanitize_title($_POST['filter']) : '';
        $offset = !empty($_POST['offset']) ? intval($_POST['offset']) : 0;

        $args = array(
            'post_type' => 'events',
            'posts_per_page' => $limit,
            'paged' => $page,
            'post_status' => 'publish',
            'offset' => $offset,
            'meta_key' => 'event_date_start', // MUST HAVE META_KEY TO FORCE WORDPRESS JOIN META TABLES
            'get_events' => true,
        );

        if (!empty($postId)) {
            $args['post__not_in'] = [$postId];
        }

        if (!empty($filter)) {
            //Upcoming Events
            if ($filter === 'coming') {
                $metaQuery = array(
                    array(
                        'key' => 'event_date_start',
                        'value' => date('Ymd'),
                        'type' => 'DATE',
                        'compare' => '>='
                    ),
                    array(
                        'key' => 'event_date_start',
                        'value' => date('Ymd', strtotime('+3 month')),
                        'type' => 'DATE',
                        'compare' => '<='
                    )
                );

                $args['meta_query'] = $metaQuery;
            }
        }

        $event = new \WP_Query($args);

        if ($count) {
            return $event->found_posts;
        }

        return $event->posts;
    }

    /**
     * @param: string $key
     * @param: mixed $default
     */
    public static function getSettings($key, $default = null) {
        $value = $default;
        $ID = get_page_id_by_template('page-templates/event.php');
        $page = get_post($ID);
        if (isset($page->ID) and $key) {
            switch (strtolower($key)) {
                default:
                    if (isset($page->$key)) {
                        $value = $page->$key;
                    } else {
                        $value = get_field($key, $ID);
                    }
                    break;
                case 'limit':
                case 'number':
                case 'showposts':
                case 'posts_per_page':
                    $key = 'event_posts_per_page';
                    $value = get_field($key, $ID);
                    break;
            }
        }
        return $value;
    }

    /**
     * @return array
     */
    public static function getDateThisWeek() {
        //check the current day
        if (date('D') != 'Mon') {
            //take the last monday
            $dateStart = date('Ymd', strtotime('last Monday'));
        } else {
            $dateStart = date('Ymd');
        }

        if (date('D') != 'Sun') {
            $endDate = date('Ymd', strtotime('next Sunday'));
        } else {
            $endDate = date('Ymd');
        }

        return [
            'start' => $dateStart,
            'end' => $endDate,
        ];
    }

    public static function isComingEvent($eventStart, $eventTimeStart) {
        $isComing = false;
        $eventdatetime = $eventStart . ', ' . $eventTimeStart;
        $eventdatetime = str_replace("/", "-", $eventdatetime);

        if (strtotime($eventdatetime) > current_time('timestamp')) {
            $isComing = true;
        }

        return $isComing;
    }

    /**
     * Get Event Featured
     *
     * @param int $page
     * @param int $limit
     * @param null $catId
     * @param array $except
     * @return \WP_Query
     */
    public static function getEventFeatured($page = 1, $limit = 10, $except = []) {
        if (!$limit) {
            $limit = get_option('posts_per_page');
        }

        $args = array(
            'post_type' => 'events',
            'posts_per_page' => $limit,
            'paged' => $page,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'post__in' => get_option('sticky_posts'),
        );

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
    public static function getCategories($orderBy = 'term_order', $order = 'ASC', $hideEmpty = true) {
        $categories = get_terms(array(
            'taxonomy' => 'cat_event',
            'orderby' => $orderBy,
            'order' => $order,
            'hide_empty' => $hideEmpty,
            'parent' => 0
        ));

        return $categories;
    }
}
