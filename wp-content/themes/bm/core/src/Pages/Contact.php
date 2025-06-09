<?php

namespace BM\Core\Pages;

class Contact
{
    /**
     * @param: void
     */
    public static function init()
    {
        static $init = null;

        if ($init === null) {
            $init = new self();
            $init->setupAction();
        }

        return $init;
    }

    /**
     * @param: void
     */
    private function setupAction()
    {
        add_action('rt_content_contact_page', [$this, 'content']);
    }

    /**
     * Content Section Form
     * @param $id
     */
    public static function content($id)
    {
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

        get_template_part('template-parts/contact/content');
    }

} // End class