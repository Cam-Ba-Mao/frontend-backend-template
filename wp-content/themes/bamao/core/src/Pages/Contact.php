<?php namespace BM\Core\Pages;

class Contact {

    var $pagenow = 'contact';

    public static function init()
    {
        static $init = null;
        if($init == null) {
            $init = new self();
            $init->setupHook();
        }
        return $init;
    }

    private function setupHook()
    {
        // add_filter( 'body_class', [$this, 'bodyClass']);
        add_action( 'rt_content_'.$this->pagenow.'_page', [$this, 'content']);
    }

    /**
     * @param: array $bodyClass
     */
    function bodyClass($bodyClass)
    {
        if (is_page_template('page-templates/'.$this->pagenow.'.php' )) {
            array_push($bodyClass, 'is-transparent');
        }
        return $bodyClass;
    }

    /**
     * content Thank You
     * @param $id
     */
    function content($id)
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
       
        get_template_part('template-parts/'.$this->pagenow.'/content');
    }
}