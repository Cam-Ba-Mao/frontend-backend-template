<?php

namespace BM\Core\Pages;

class Degrees {
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
        add_action('rt_content_degrees_page', [$this, 'content']);
    }

    /**
     * @param: array $bodyClass
     */
    function bodyClass($bodyClass) {
        if (is_page_template('page-templates/degrees.php'))
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

        get_template_part('template-parts/degrees/banner');
        get_template_part('template-parts/degrees/intro');
        get_template_part('template-parts/degrees/pathways');
        get_template_part('template-parts/general/join');
    }
}
