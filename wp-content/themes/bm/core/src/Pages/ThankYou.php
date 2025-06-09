<?php

namespace BM\Core\Pages;

class ThankYou
{
    public static function init()
    {
        static $init = null;

        if ($init === null) {
            $init = new self();
            $init->setupAction();
        }

        return $init;
    }

    private function setupAction()
    {
        add_action('rt_content_thank_you', [$this, 'content']);
    }

    /**
     * Content Thank You 
     * @param $id
     */
    public static function content($id)
    {
        $options = get_fields('option');
        if (empty($options)) {
            $options = [];
        }

        $data = get_fields($id);

        if ($data) {
            $data = array_merge($options, $data);
        }

        set_query_var('data', $data);
        get_template_part('template-parts/thank-you/content'); 
        get_template_part('template-parts/common/gift'); 

    }
}