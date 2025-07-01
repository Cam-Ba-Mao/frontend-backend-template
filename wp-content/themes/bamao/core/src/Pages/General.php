<?php

namespace BM\Core\Pages;

class General {
    public static function init() {
        static $init = null;

        if ($init === null) {
            $init = new self();
            $init->setupAction();
        }

        return $init;
    }

    private function setupAction() {
        add_action('before_header', [$this, 'beforeHeader']);
        add_action('rt_content_general_page', [$this, 'content']);
    }

    /**
     * Before Header
     * 
     */
    public static function beforeHeader() {
        if (!\is_page_template('page-templates/degrees.php')) {
            get_template_part('template-parts/general/topbar');
        }
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

        // get_template_part('template-parts/general/content');

    }
}
