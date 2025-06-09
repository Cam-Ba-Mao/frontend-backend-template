<?php

namespace BM\Core;

class BMInit {
    public static function init() {
        static $init = null;

        if ($init === null) {
            $init = new self();
            $init->setupAction();
            $init->setupFilter();
        }

        return $init;
    }

    private function setupAction() {
        //add_action('init', [$this, 'registerSession']);
        add_action('rt_breadcrumb', [$this, 'breadcrumb']);
        add_action('pre_get_posts', [$this, 'preOrderByModified']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminScripts']);
        add_action('init', [$this, 'removeEditor']);
        add_action('init', [$this, 'redirectUserSubscriber']);

        add_action('comment_form_top', [$this, 'customCommentFormTop'], 10);
    }

    private function setupFilter() {
        add_filter('wp_mail_content_type', [$this, 'setEmailContentType']);
        add_filter('excerpt_length_definition', [$this, 'excerptLengthDefinition']);
        add_filter('excerpt_more', [$this, 'excerptMore']);
        add_filter('excerpt_length', [$this, 'excerptLength'], 999);
        add_filter('upload_mimes', [$this, 'allowUploadFileTypes']);
        add_filter('body_class', [$this, 'bodyClass']);

        add_filter('acf/fields/google_map/api', [$this, 'setGoogleMapApiAcf']);
        add_filter('comment_form_fields', [$this, 'moveCommentFieldToBottom']);

        // add_action( 'template_redirect', [$this, 'forceRedirect']);
    }

    /**
     * Breadcrumb
     */
    static function breadcrumb() {
        get_template_part('template-parts/common/breadcrumb');
    }

    /**
     * pre-order by modified
     * @param $query
     */
    static function preOrderByModified($query) {
        if ($query->get('orderby') == "modified") {
            $query->set('orderby', 'modified');
            $query->set('order', 'DESC');
        }
    }


    /**
     * Admin style
     */
    static function enqueueAdminScripts() {
        //wp_register_style('admin-custom', get_template_directory_uri() . '/html/src/scss/admin-custom.css', array(), time());
        //wp_enqueue_style('admin-custom');
    }


    /**
     * Set email content type
     * @return string
     */
    static function setEmailContentType() {
        return "text/html";
    }

    /**
     * Excerpt length definition
     *
     * @param $length
     * @return mixed
     */
    static function excerptLengthDefinition($length) {
        return $length;
    }

    /**
     * Excerpt more text
     * @param $more
     * @return string
     */
    static function excerptMore($more) {
        return '...';
    }

    /**
     * Excerpt length
     * @param $length
     * @return int
     */
    static function excerptLength($length) {
        return 30;
    }

    /**
     * Add more upload file type
     * @param $type
     * @return array
     */
    static function allowUploadFileTypes($type) {
        $type['svg'] = 'image/svg';
        // $type['svg'] = 'image/svg+xml';
        return $type;
    }

    public static function removeEditor() {
        if (isset($_GET['post'])) {
            $id = $_GET['post'];
            $template = get_post_meta($id, '_wp_page_template', true);
            $removedTemplate = [
                'page-templates/home.php',
                'page-templates/thank-you.php',
                'page-templates/about.php',
                'page-templates/contact.php',
                'page-templates/school.php',
            ];

            if (in_array($template, $removedTemplate)) {
                remove_post_type_support('page', 'editor');
            }
        }
    }

    public static function registerSession() {
        if (!session_id()) {
            session_start();
        }
    }

    public static function bodyClass($classes) {
        if (is_page_template('page-templates/home.php') || is_front_page() || is_page_template('page-templates/thank-you.php') || is_404()) {
            array_push($classes, 'page-template-home is-transparent');
        } elseif (is_page_template('page-templates/contact.php')) {
            array_push($classes, 'page-template-contact is-transparent');
        } elseif (is_page_template('page-templates/school.php') || is_tax('school_country_state')) {
            array_push($classes, 'page-template-schools is-transparent');
        } elseif (is_singular('school')) {
            array_push($classes, 'is-transparent');
        } elseif (is_page_template('page-templates/about.php')) {
            array_push($classes, 'is-transparent');
        } elseif (is_page_template('page-templates/event.php')) {
            array_push($classes, 'is-transparent');
        } elseif (is_page_template('page-templates/experience.php') || is_tax('cat_experience') || is_page_template('page-templates/news.php') || is_tax('category') || is_page_template('page-templates/scholarship.php')) {
            array_push($classes, 'is-transparent');
        } else if (is_singular('events') ) {
            array_push($classes, 'is-transparent');
        } else if( is_singular('post') || is_singular('scholarship') || is_singular('experiences') ) {
            array_push($classes, 'is-transparent single-post');
        }
        return $classes;
    }

    public static function setGoogleMapApiAcf($api) {
        $api['key'] = GOOGLE_MAP_API_KEY;
        return $api;
    }

    function redirectUserSubscriber() {
        if (is_admin() && current_user_can('subscriber') && !(defined('DOING_AJAX') && DOING_AJAX)) {
            wp_redirect(home_url());
            exit;
        }
    }

    public function forceRedirect() {
    }

    function customCommentFormTop() {
        echo '<p class="comment-reply-desc">' . sprintf(__('Bạn đang nhận xét cho bài viết "%s"', 'isa'), get_the_title()) . '</p>';
    }

    function moveCommentFieldToBottom($fields) {
        $comment_field = $fields['comment'];
        unset($fields['comment']);

        $fields['comment'] = $comment_field;
        return $fields;
    }
}
