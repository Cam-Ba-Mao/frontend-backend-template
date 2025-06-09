<?php


namespace BM\Core\Pages;


class Event {
    public static function init() {
        static $init = null;

        if ($init === null) {
            $init = new self();
            $init->setupAction();
        }

        return $init;
    }

    private function setupAction() {
        add_action('rt_content_event_page', [$this, 'content']);
    }

    /**
     * Content Event Archive
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

        $templateEventID = get_page_id_by_template('page-templates/event.php');
        if ($templateEventID) {
            $data['archive_link'] = get_permalink($templateEventID);
        }
        $data['events'] = \BM\Core\Event\EventFunctions::getEvents(); //initialize the most recent events
        set_query_var('data', $data);
        get_template_part('template-parts/common/banner');
        get_template_part('template-parts/event/archive');
        get_template_part('template-parts/common/gift');
    }
}
