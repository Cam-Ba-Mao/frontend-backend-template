<?php

namespace BM\Core\Pages;

class AboutUs {
    public static function init() {
        static $init = null;

        if ($init === null) {
            $init = new self();
            $init->setupAction();
        }

        return $init;
    }

    private function setupAction() {
        add_action('rt_content_aboutus_page', [$this, 'content']);
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

        if ($data) {
            $data = array_merge($options, $data);
        }

        set_query_var('data', $data);

        get_template_part('template-parts/about/banner');
        get_template_part('template-parts/about/intro');
        get_template_part('template-parts/common/why-us');
        get_template_part('template-parts/common/strategic-partnership');
        get_template_part('template-parts/about/discover');
        get_template_part('template-parts/common/gift');
    }
}
