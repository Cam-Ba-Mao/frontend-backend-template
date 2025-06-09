<?php

namespace BM\Core\Event;

class EventHook {
    public static function init() {
        static $init = null;

        if ($init === null) {
            $init = new self();
            $init->setupAction();
        }

        return $init;
    }

    private function setupAction() {
        add_action('init', [$this, 'registerEvent']);
        // add_action('init', [$this, 'addRewriteRule']);
        add_action('wp_ajax_rt_event_loaddata', [$this, 'ajaxLoadData']);
        add_action('wp_ajax_nopriv_rt_event_loaddata', [$this, 'ajaxLoadData']);
        //add_action('init', [$this, 'registerTaxonomyEvent']); // no category for Events

        // add_filter('post_type_link', [$this, 'postTypeLink'], 1, 2);
        // add_filter('pll_the_language_link', [$this, 'pllTheLanguageLink'], 10, 2);
        add_filter('posts_clauses', [$this, 'customizeQuery'], 20, 2);
    }

    public static function customizeQuery($clauses, $query) {
        if (isset($query->query['get_events'])) { //only customize the query which has 'get_events' parameter
            $fields = implode(",", array(
                "IF(wp_postmeta.`meta_key` = 'event_date_start' AND wp_postmeta.`meta_value` >= CURDATE(), 1, 0) is_coming",
                "IF(wp_postmeta.`meta_key` = 'event_date_start' AND wp_postmeta.`meta_value` >= CURDATE(), CONCAT('A', wp_postmeta.`meta_value`), 'B') AS is_coming_order"
            ));
            $orderBy = implode(",", array(
                "is_coming DESC",
                "is_coming_order ASC",
                "wp_postmeta.`meta_value` DESC",
                "wp_posts.post_date DESC"
            ));
            $isGetEvents = $query->query['get_events'];

            if ($isGetEvents) {
                $clauses['fields'] = sprintf('%s, %s', $clauses['fields'], $fields);
                $clauses['orderby'] = $orderBy;
            }
        }
        return $clauses;
    }

    public static function ajaxLoadData() {
        $redirect = '';
        $limit = \BM\Core\Event\EventFunctions::getSettings('limit');
        $posts = \BM\Core\Event\EventFunctions::getEvents();
        $count = \BM\Core\Event\EventFunctions::getEvents('', 1, '', '', true);

        if ($count and $posts) {
            foreach ($posts as $i => $event) {
                ob_start();
                get_template_part('template-parts/event/loop', null, $event);
                $posts[$i] = ob_get_clean();
            }
        } else {
            ob_start();
            get_template_part('template-parts/event/empty');
            $posts[] = ob_get_clean();
        }

        wp_send_json(array(
            'success' => true,
            'results' => array(
                'posts' => $posts,
                'count' => $count,
                'redirect' => $redirect,
                'perpage' => $limit
            ),
        ));
        exit;
    }

    public static function registerEvent() {
        $args = [
            'supports' => [
                'title',
                'editor',
                'thumbnail',
                'excerpt',
            ],
            'labels' => [
                'name' => 'Events',
                'singular_name' => 'Events',
                'menu_name' => 'Events',
                'name_admin_bar' => 'Events',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Event',
                'new_item' => 'New Event',
                'edit_item' => 'Edit Event',
                'view_item' => 'View Event',
                'all_items' => 'All Events',
                'search_items' => 'Search Event',
                'not_found' => 'No Event Found.',
            ],
            'public' => true,
            'show_in_rest' => false,
            'query_var' => true,
            'has_archive' => false,
            'hierarchical' => true,
            'publicly_queryable' => true,
            'rewrite' => ['slug' => 'su-kien'],
            'menu_icon' => 'dashicons-calendar-alt'
        ];

        register_post_type('events', $args);
    }

    public static function registerTaxonomyEvent() {
        $labels = array(
            'name' => 'Category Event',
            'singular_name' => 'Category Event',
            'search_items' => 'Search Category Event',
            'all_items' => 'All Category Events',
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => 'Edit Category Event',
            'update_item' => 'Update Category Event',
            'add_new_item' => 'Add New Category Event',
            'new_item_name' => 'Name Category Event',
            'menu_name' => 'Category Events',
        );

        register_taxonomy('cat_event', 'events', array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'publicly_queryable' => false,
            'rewrite' => array('slug' => 'Category Event'),
        ));
    }

    /**
     * @param: void
     */
    function addRewriteRule() {
        add_rewrite_rule('su-kien/([a-z0-9-]+)[/]?$', 'index.php?events=$matches[1]', 'top');
        add_rewrite_rule('en/event/([a-z0-9-]+)[/]?$', 'index.php?events=$matches[1]', 'top');

        add_rewrite_rule('^su-kien/page/([0-9]+)', 'index.php?pagename=su-kien&paged=$matches[1]', 'top');
    }

    /**
     * @param: string $link
     * @param: object $post
     */
    public static function postTypeLink($link, $post) {
        if (empty($post)) {
            return $link;
        }

        if (function_exists('pll_current_language')) {
            // $locale = pll_current_language();
            // dd(pll_get_post_language( $post->ID));
            if ('events' == get_post_type($post)) {
                $translations = $GLOBALS["polylang"]->model->post->get_translations($post->ID);
                foreach ($translations as $locale => $ID) {
                    if ($ID == $post->ID) {
                        switch ($locale) {
                            case 'en':
                                $link = str_replace('/su-kien/', '/en/event/', $link);
                                break;
                            case 'vi':
                                $link = str_replace('/event/', '/su-kien/', $link);
                                break;
                        }
                    }
                }
            }
        }

        return $link;
    }

    /**
     * @param: string $url
     * @param: string $slug
     */
    public static function pllTheLanguageLink($url, $slug) {
        if (($slug == 'en') and strpos($url, '/su-kien/')) {
            $url = str_replace('/su-kien/', '/event/', $url);
        }

        if (($slug == 'vi') and strpos($url, '/event/')) {
            $url = str_replace('/event/', '/su-kien/', $url);
        }

        return $url;
    }
}
