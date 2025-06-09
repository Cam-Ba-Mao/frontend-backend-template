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
        add_action('rt_content_home_page', [$this, 'content']);
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

        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $limit = 6;
        $data['paged'] = $paged;
        $data['events'] = \BM\Core\Event\EventFunctions::getEventFeatured($paged, $limit, [])->posts;
        // dd($data['events']);
       
        set_query_var('data', $data);

        get_template_part('template-parts/home/banner'); 
        get_template_part('template-parts/home/vist-location'); 
        get_template_part('template-parts/home/intro'); 
        get_template_part('template-parts/common/why-us'); 
        get_template_part('template-parts/home/prestigious-university'); 
        get_template_part('template-parts/common/form'); 
        get_template_part('template-parts/common/strategic-partnership'); 
        get_template_part('template-parts/common/featured-events'); 
        get_template_part('template-parts/common/gift'); 
    }
}
