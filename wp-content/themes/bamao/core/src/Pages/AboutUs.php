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
        add_action('body_class', [$this, 'bodyClass']);
        add_action('rt_content_about_us_page', [$this, 'content']);
    }

    /**
     * @param: array $bodyClass
     */
    function bodyClass($bodyClass) {
        if (is_page_template('page-templates/about-us.php'))
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

        $data['faqs'] = \BM\Core\Faq\FaqFunctions::getFaq(1, -1);

        set_query_var('data', $data);

        get_template_part('template-parts/about-us/banner');
        get_template_part('template-parts/about-us/intro');
        get_template_part('template-parts/about-us/offer');
        get_template_part('template-parts/about-us/learning');
        get_template_part('template-parts/about-us/faq');
        get_template_part('template-parts/general/join');
    }
}
