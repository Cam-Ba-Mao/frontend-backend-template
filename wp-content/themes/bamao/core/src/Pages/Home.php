<?php

namespace BM\Core\Pages;

class Home {
    public static function init() {
        static $init = null;

        if ($init === null) {
            $init = new self();
            $init->setupAction();
        }

        return $init;
    }

    private function setupAction() {
        add_filter('body_class', [$this, 'bodyClass']);
        add_action('rt_content_home_page', [$this, 'content']);
    }

    /**
     * @param: array $bodyClass
     */
    function bodyClass($bodyClass) {
        if (is_page_template('page-templates/home.php') || is_front_page())
            array_push($bodyClass, 'is-transparent');
        return $bodyClass;
    }

    /**
     * Content Post Single
     * @param $id
     */
    public static function content($id) {
        $options = get_fields('option');
        if (empty($options)) {
            $options = [];
        }

        $data = get_fields($id);
        if (empty($data)) {
            $data = [];
        }
        $data = array_merge($options, $data);

        set_query_var('data', $data);

        get_template_part('template-parts/home/banner');
        get_template_part('template-parts/home/intro');
        get_template_part('template-parts/home/program');
        get_template_part('template-parts/home/whyus');
        get_template_part('template-parts/home/stories');
        get_template_part('template-parts/home/schools');
        get_template_part('template-parts/general/join');
    }
}
