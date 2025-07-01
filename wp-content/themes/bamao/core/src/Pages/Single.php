<?php

namespace BM\Core\Pages;


class Single {
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
        add_action('rt_content_single_post', [$this, 'contentPost']);
        add_action('rt_content_single_course', [$this, 'contentCourse']);
    }

    /**
     * @param: array $bodyClass
     */
    function bodyClass($bodyClass) {
        if (is_singular('course'))
            array_push($bodyClass, 'is-transparent');
        return $bodyClass;
    }

    /**
     * Content Course Single
     * @param $id
     */
    public static function contentCourse($id) {
        $options = get_fields('option');
        if (empty($options)) {
            $options = [];
        }

        $data = get_fields($id);

        if ($data) {
            $data = array_merge($options, $data);
        } else {
            $data = $options;
        }

        $catId = \get_the_terms($id, 'cat_course');
        if (!empty($catId)) {
            $catId = $catId[0]; // Get only the first category
            $relatedCourses = \BM\Core\Course\CourseFunctions::getRelatedCourses($id, $catId->term_id, 8);

            if (!empty($relatedCourses->posts)) {
                $data['related_courses'] = $relatedCourses->posts;
            }
        }

        set_query_var('data', $data);

        get_template_part('template-parts/single/course/details');
        get_template_part('template-parts/single/course/content');
        get_template_part('template-parts/single/course/knowledge');
        get_template_part('template-parts/single/course/related-courses');
    }

    /**
     * Content Post Single
     * @param $id
     */
    public static function contentPost($id) {
        $terms = $listTerms = wp_get_post_terms($id, 'category', array(
            'orderby' => 'parent',
            'order'   => 'ASC',
        ));

        $term = '';
        if (is_array($listTerms) && count($listTerms) > 0) {
            $term = array_shift($terms)->term_id;
            $termName = array_shift($listTerms)->name;
        }

        $options = get_fields('option');
        if (empty($options)) {
            $options = [];
        }

        $data = get_fields($id);

        if ($data) {
            $data = array_merge($options, $data);
        } else {
            $data = $options;
        }

        set_query_var('data', $data);
    }
}
