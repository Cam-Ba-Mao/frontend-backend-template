<?php

namespace BM\Core\Pages;

class Archive
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
        add_filter( 'body_class', [$this, 'bodyClass']);
        add_action('rt_content_post_archive', [$this, 'contentPost']);
        add_action('rt_content_course_cat', [$this, 'contentCourseCat']);
    }

    /**
     * @param: array $bodyClass
     */
    function bodyClass($bodyClass)
    {
        if (is_tax('cat_course')) {
            array_push($bodyClass, 'page-template-programs', 'is-transparent');
        }
        return $bodyClass;
    }

    /**
     * Post Archive
     * @param $id
     */
    public static function contentPost($id) {
        $options = get_fields('option');
        if (empty($options)) {
            $options = [];
        }

        $data = get_fields($id);
        if (empty($data)) {
            $data = [];
        }

        set_query_var('data', $data);
    }
    
    /**
     * Course Category
     * @param $id
     */
    public static function contentCourseCat($id) {
        $options = get_fields('option');
        if (empty($options)) {
            $options = [];
        }
        
        $term = get_queried_object();
        $term_id = $term->term_id;
        $term_taxonomy = $term->taxonomy;

        $data = get_fields($term_taxonomy . '_' . $term_id);
        if (empty($data)) {
            $data = [];
        }

        $data = array_merge($options, $data, (array) $term, [
            'courses' => \BM\Core\Course\CourseFunctions::getCourses($term_id)
        ]);

        set_query_var('data', $data);

        get_template_part('template-parts/course/course-cat/banner');
        get_template_part('template-parts/course/course-cat/intro');
        get_template_part('template-parts/course/course-cat/content');
        get_template_part('template-parts/general/join');
    }
}
