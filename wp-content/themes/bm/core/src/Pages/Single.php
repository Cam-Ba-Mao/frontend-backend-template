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
        add_action('rt_content_single_post', [$this, 'contentPost']);
        add_action('rt_content_single_school', [$this, 'contentSchool']);
        add_action('rt_content_single_events', [$this, 'contentEvent']);
        add_action('rt_content_single_scholarship', [$this, 'contentScholarship']);
        add_action('rt_content_single_experiences', [$this, 'contentExperiences']);
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

        $templateID = get_page_id_by_template('page-templates/news.php');
        if ($templateID) {
            $data['back_link'] = get_the_permalink($templateID);
        }

        $data['related'] = \BM\Core\Blog\BlogFunctions::getRelatedBlogs($id, $term);
        $data['show_cat'] = false;

        set_query_var('data', $data);

        get_template_part('template-parts/single/post/banner');
        get_template_part('template-parts/single/post/content');
        get_template_part('template-parts/common/gift');
        get_template_part('template-parts/common/form');
        get_template_part('template-parts/single/post/related');
        get_template_part('template-parts/single/post/back-link');
    }

    public static function contentSchool($id) {
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

        get_template_part('template-parts/single/school/banner');
        get_template_part('template-parts/single/school/content');
        get_template_part('template-parts/common/gift'); 
        get_template_part('template-parts/common/form'); 
        get_template_part('template-parts/single/school/related');
    }

    public static function contentEvent($id) {
        $options = get_fields('option');
        if (empty($options)) {
            $options = array();
        }

        $data = get_fields($id);
        if (empty($data)) {
            $data = array();
        }

        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $limit = 6;
        $data['paged'] = $paged;
        $data['events'] = \BM\Core\Event\EventFunctions::getEventFeatured($paged, $limit, array($id))->posts;

        $templateEventID = get_page_id_by_template('page-templates/event.php');
        if ($templateEventID) {
            $data['archive_link'] = get_permalink($templateEventID);
        }

        $data = array_merge($data, $options);
        set_query_var('data', $data);

        get_template_part('template-parts/single/event/banner');
        get_template_part('template-parts/single/event/content');
        get_template_part('template-parts/single/event/form');
        get_template_part('template-parts/common/featured-events');
        get_template_part('template-parts/common/gift');
    }

    public static function contentScholarship($id) {
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

        $templateID = get_page_id_by_template('page-templates/scholarship.php');
        if ($templateID) {
            $data['back_link'] = get_the_permalink($templateID);
        }

        $data['related'] = \BM\Core\Scholarship\ScholarshipFunctions::getScholarship(1, 8, [$id]);
        $data['show_cat'] = false;

        set_query_var('data', $data);

        get_template_part('template-parts/single/post/banner');
        get_template_part('template-parts/single/post/content');
        get_template_part('template-parts/common/gift');
        get_template_part('template-parts/common/form');
        get_template_part('template-parts/single/post/related');
        get_template_part('template-parts/single/post/back-link');
    }

    public static function contentExperiences($id) {
        $data = get_fields($id);

        $terms = $listTerms = wp_get_post_terms($id, 'cat_experience', array(
            'orderby' => 'parent',
            'order'   => 'ASC',
        ));

        $term = '';
        if (is_array($listTerms) && count($listTerms) > 0) {
            $data['termName'] = $listTerms[0]->name;
            $term = array_shift($terms)->term_id;
        }

        $options = get_fields('option');
        if (empty($options)) {
            $options = [];
        }



        if ($data) {
            $data = array_merge($options, $data);
        } else {
            $data = $options;
        }

        $templateID = get_page_id_by_template('page-templates/experience.php');
        if ($templateID) {
            $data['back_link'] = get_the_permalink($templateID);
        }

        $data['related'] = \BM\Core\Experience\ExperienceFunctions::getExperiences($term, 1, 8, [$id]);
        $data['show_cat'] = true;

        set_query_var('data', $data);

        get_template_part('template-parts/single/post/banner');
        get_template_part('template-parts/single/post/content');
        get_template_part('template-parts/common/gift');
        get_template_part('template-parts/common/form');
        get_template_part('template-parts/single/post/related');
        get_template_part('template-parts/single/post/back-link');
    }
}
